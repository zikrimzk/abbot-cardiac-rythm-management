<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class ImplantsExport implements FromCollection, WithHeadings, WithEvents
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $modelCategories = DB::table('model_categories')
            ->where('mcategory_ismorethanone', 0)
            ->pluck('mcategory_name')
            ->toArray();

        $data = DB::table('implants as a')
            ->join('generators as b', 'a.generator_id', 'b.id')
            ->join('regions as c', 'a.region_id', 'c.id')
            ->join('hospitals as d', 'a.hospital_id', 'd.id')
            ->join('doctors as e', 'a.doctor_id', 'e.id')
            ->join('stock_locations as f', 'a.stock_location_id', 'f.id')
            ->leftJoin('product_group_lists as g', 'a.id', 'g.implant_id')
            ->leftJoin('product_groups as h', 'g.product_group_id', 'h.id')
            ->leftJoin('implant_models as i', 'a.id', 'i.implant_id')
            ->leftJoin('abbott_models as j', 'i.model_id', 'j.id')
            ->leftJoin('model_categories as k', 'j.mcategory_id', 'k.id')
            ->where('k.mcategory_ismorethanone', 0)
            ->select(
                'a.id',
                'a.implant_date',
                'd.hospital_name',
                'c.region_name',
                DB::raw("GROUP_CONCAT(DISTINCT h.product_group_name ORDER BY h.id ASC SEPARATOR ', ') as product_groups"),
                'e.doctor_name',
                'b.generator_name',
                'b.generator_code',
                'a.implant_generator_sn',
                'k.mcategory_name as model_category',
                'j.model_code',
                'i.implant_model_sn',
                'a.implant_pt_name',
                'a.implant_invoice_no',
                'a.implant_sales',
                'a.implant_quantity',
                'a.implant_remark',
                'a.implant_pt_mrn',
                'a.implant_pt_icno',
                'a.implant_note',
            )
            ->groupBy(
                'a.id',
                'a.implant_date',
                'd.hospital_name',
                'c.region_name',
                'e.doctor_name',
                'b.generator_name',
                'b.generator_code',
                'a.implant_generator_sn',
                'k.mcategory_name',
                'j.model_code',
                'i.implant_model_sn',
                'a.implant_pt_name',
                'a.implant_invoice_no',
                'a.implant_sales',
                'a.implant_quantity',
                'a.implant_remark',
                'a.implant_pt_mrn',
                'a.implant_pt_icno',
                'a.implant_note',
            )
            ->orderBy('a.created_at', 'asc')
            ->get();

        $formattedData = [];

        foreach ($data as $item) {
            $implantId = $item->id;

            if (!isset($formattedData[$implantId])) {
                $formattedData[$implantId] = [
                    'id' => $item->id,
                    'implant_date' => $item->implant_date ?? 'N/A',
                    'hospital_name' => $item->hospital_name ?? 'N/A',
                    'region_name' => $item->region_name ?? 'N/A',
                    'product_groups' => $item->product_groups ?? 'N/A',
                    'doctor_name' => $item->doctor_name ?? 'N/A',
                    'generator_name' => $item->generator_name ?? 'N/A',
                    'generator_code' => $item->generator_code ?? 'N/A',
                    'implant_generator_sn' => $item->implant_generator_sn ?? 'N/A',
                ];

                foreach ($modelCategories as $category) {
                    $formattedData[$implantId][$category . "_model"] = 'N/A';
                    $formattedData[$implantId][$category . "_serial"] = 'N/A';
                }

                $formattedData[$implantId] = array_merge($formattedData[$implantId], [
                    'implant_pt_name' => $item->implant_pt_name ?? 'N/A',
                    'implant_invoice_no' => $item->implant_invoice_no ?? 'N/A',
                    'implant_sales' => $item->implant_sales ?? 'N/A',
                    'implant_quantity' => $item->implant_quantity ?? 'N/A',
                    'implant_remark' => $item->implant_remark ?? 'N/A',
                    'implant_pt_mrn' => $item->implant_pt_mrn ?? 'N/A',
                    'implant_pt_icno' => $item->implant_pt_icno ?? 'N/A',
                    'implant_note' => $item->implant_note ?? 'N/A',
                ]);
            }

            if ($item->model_category) {
                $formattedData[$implantId][$item->model_category . "_model"] = $item->model_code ?? 'N/A';
                $formattedData[$implantId][$item->model_category . "_serial"] = $item->implant_model_sn ?? 'N/A';
            }
        }

        return collect(array_values($formattedData));
    }

    public function headings(): array
    {
        $modelCategories = DB::table('model_categories')
            ->where('mcategory_ismorethanone', 0)
            ->pluck('mcategory_name')
            ->toArray();

        $baseHeaders = [
            "No",
            "Implant Date",
            "Hospital",
            "Region",
            "Product Group",
            "Doctor",
            "Generator Name",
            "Generator Model",
            "Serial Number"
        ];

        $dynamicHeaders = [];
        foreach ($modelCategories as $category) {
            $dynamicHeaders[] = $category . " Model";
            $dynamicHeaders[] = $category . " Serial Number";
        }

        $endingHeaders = [
            "Patient Name",
            "Invoice No",
            "Sales (RM)",
            "Quantity",
            "Remarks",
            "MRN",
            "IC/Passport Number",
            "Note",
            "Add by"
        ];

        return array_merge($baseHeaders, $dynamicHeaders, $endingHeaders);
    }



    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->getDelegate()->getRowDimension('1')->setRowHeight(20);

                $staticColumnWidths = [
                    'A' => 5,  // No
                    'B' => 12, // Implant Date
                    'C' => 25, // Hospital
                    'D' => 10, // Region
                    'E' => 15, // Product Group
                    'F' => 40, // Doctor
                    'G' => 18, // Generator Name
                    'H' => 18, // Generator Model
                    'I' => 15  // Serial Number
                ];

                foreach ($staticColumnWidths as $column => $width) {
                    $event->sheet->getDelegate()->getColumnDimension($column)->setWidth($width);
                }

                $modelCategories = DB::table('model_categories')
                    ->where('mcategory_ismorethanone', 0)
                    ->pluck('mcategory_name')
                    ->toArray();

                $columnLetter = 'J';

                foreach ($modelCategories as $category) {
                    $event->sheet->getDelegate()->getColumnDimension($columnLetter)->setWidth(25); // Model
                    $columnLetter++;
                    $event->sheet->getDelegate()->getColumnDimension($columnLetter)->setWidth(25); // Serial Number
                    $columnLetter++;
                }

                $extraColumns = [
                    "Patient Name" => 25,
                    "Invoice No" => 10,
                    "Sales (RM)" => 10,
                    "Quantity" => 10,
                    "Remarks" => 20,
                    "MRN" => 15,
                    "IC/Passport Number" => 20,
                    "Note" => 60,
                    "Add by" => 20
                ];

                foreach ($extraColumns as $name => $width) {
                    $event->sheet->getDelegate()->getColumnDimension($columnLetter)->setWidth($width);
                    $columnLetter++;
                }

                $event->sheet->getDelegate()->getStyle("A1:{$columnLetter}1")->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'color' => ['rgb' => '000000'],
                    ],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['rgb' => 'f3ff33'],
                    ],
                ]);
            },
        ];
    }
}
