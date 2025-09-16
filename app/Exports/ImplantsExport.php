<?php

namespace App\Exports;

use App\Models\ApprovalType;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithEvents;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;

class ImplantsExport implements FromCollection, WithHeadings, WithEvents, WithCustomStartCell, WithTitle
{
    protected $selectedIds;

    public function __construct($selectedIds = null)
    {
        $this->selectedIds = $selectedIds ? explode(',', $selectedIds) : null;
    }

    public function startCell(): string
    {
        return 'A4'; // Start data from row 4 to leave space for title and headers
    }

    public function title(): string
    {
        return 'Implant List';
    }

    public function collection()
    {
        $modelCategories = DB::table('model_categories')
            // ->where('mcategory_ismorethanone', 0)
            ->pluck('mcategory_name')
            ->toArray();

        $data = DB::table('implants as a')
            ->select([
                'a.id',
                'a.implant_date',
                'd.hospital_name',
                'c.region_name',
                DB::raw("GROUP_CONCAT(DISTINCT h.product_group_name ORDER BY h.id ASC SEPARATOR ', ') as product_groups"),
                'e.doctor_name',
                'b.generator_name',
                'b.generator_code',
                'a.implant_generator_sn',
                'a.implant_generator_qty',
                'a.implant_generator_itemPrice',
                'k.mcategory_name as model_category',
                'j.model_code',
                'i.implant_model_sn',
                'i.implant_model_qty',
                'i.implant_model_itemPrice',
                'a.implant_pt_name',
                'a.implant_sales_total_price',
                'a.implant_generator_qty',
                'a.approval_type_id',
                'a.implant_pt_mrn',
                'a.implant_pt_icno',
            ])
            ->join('generators as b', 'a.generator_id', '=', 'b.id')
            ->join('regions as c', 'a.region_id', '=', 'c.id')
            ->join('hospitals as d', 'a.hospital_id', '=', 'd.id')
            ->join('doctors as e', 'a.doctor_id', '=', 'e.id')
            ->join('stock_locations as f', 'a.stock_location_id', '=', 'f.id')
            ->leftJoin('product_group_lists as g', 'a.id', '=', 'g.implant_id')
            ->leftJoin('product_groups as h', 'g.product_group_id', '=', 'h.id')
            ->leftJoin('implant_models as i', 'a.id', '=', 'i.implant_id')
            ->leftJoin('abbott_models as j', 'i.model_id', '=', 'j.id')
            ->leftJoin('model_categories as k', 'j.mcategory_id', '=', 'k.id')
            // ->where('k.mcategory_ismorethanone', '=', 0)
            ->groupBy([
                'a.id',
                'a.implant_date',
                'd.hospital_name',
                'c.region_name',
                'e.doctor_name',
                'b.generator_name',
                'b.generator_code',
                'a.implant_generator_sn',
                'a.implant_generator_qty',
                'a.implant_generator_itemPrice',
                'k.mcategory_name',
                'j.model_code',
                'i.implant_model_sn',
                'i.implant_model_qty',
                'i.implant_model_itemPrice',
                'a.implant_pt_name',
                'a.implant_pt_mrn',
                'a.implant_pt_icno',
                'a.implant_sales_total_price',
                'a.approval_type_id',
            ])
            ->orderBy('a.created_at', 'asc');

        if (!empty($this->selectedIds)) {
            $data->whereIn('a.id', $this->selectedIds);
        }

        $data = $data->get();

        $formattedData = [];
        $counter = 1;

        foreach ($data as $item) {
            $implantId = $item->id;

            if (!isset($formattedData[$implantId])) {
                $formattedData[$implantId] = [
                    'no' => $counter++,
                    'implant_date' => $item->implant_date ? date('d/m/Y', strtotime($item->implant_date)) : 'N/A',
                    'hospital_name' => $item->hospital_name ?? 'N/A',
                    'region_name' => $item->region_name ?? 'N/A',
                    'product_groups' => $item->product_groups ?? 'N/A',
                    'doctor_name' => $item->doctor_name ?? 'N/A',
                    'generator_name' => $item->generator_name ?? 'N/A',
                    'generator_code' => $item->generator_code ?? 'N/A',
                    'implant_generator_sn' => $item->implant_generator_sn ?? 'N/A',
                    'implant_generator_qty' => $item->implant_generator_qty ?? 'N/A',
                    'implant_generator_itemPrice' => $item->implant_generator_itemPrice ? 'RM ' . number_format($item->implant_generator_itemPrice, 2) : 'N/A',
                ];

                foreach ($modelCategories as $category) {
                    $formattedData[$implantId][$category . "_model"] = 'N/A';
                    $formattedData[$implantId][$category . "_serial"] = 'N/A';
                    $formattedData[$implantId][$category . "_qty"] = 'N/A';
                    $formattedData[$implantId][$category . "_price"] = 'N/A';
                }

                $formattedData[$implantId] = array_merge($formattedData[$implantId], [
                    'implant_pt_name' => $item->implant_pt_name ?? 'N/A',
                    'implant_pt_mrn' => $item->implant_pt_mrn ?? 'N/A',
                    'implant_pt_icno' => $item->implant_pt_icno ?? 'N/A',
                    'implant_sales_total_price' => $item->implant_sales_total_price ? 'RM ' . number_format($item->implant_sales_total_price, 2) : 'N/A',
                    'approval_type_id' => ApprovalType::where('id', $item->approval_type_id)->first()->approval_type_name ?? 'N/A',
                ]);
            }

            // if ($item->model_category) {
            //     $formattedData[$implantId][$item->model_category . "_model"] = $item->model_code ?? 'N/A';
            //     $formattedData[$implantId][$item->model_category . "_serial"] = $item->implant_model_sn ?? 'N/A';
            //     $formattedData[$implantId][$item->model_category . "_qty"] = $item->implant_model_qty ?? 'N/A';
            //     $formattedData[$implantId][$item->model_category . "_price"] = $item->implant_model_itemPrice ? 'RM ' . number_format($item->implant_model_itemPrice, 2) : 'N/A';
            // }

            if ($item->model_category) {
                $categoryKey = $item->model_category;

                // Append model codes
                $formattedData[$implantId][$categoryKey . "_model"] =
                    ($formattedData[$implantId][$categoryKey . "_model"] !== 'N/A'
                        ? $formattedData[$implantId][$categoryKey . "_model"] . "\n" . $item->model_code
                        : $item->model_code);

                // Append serial numbers
                $formattedData[$implantId][$categoryKey . "_serial"] =
                    ($formattedData[$implantId][$categoryKey . "_serial"] !== 'N/A'
                        ? $formattedData[$implantId][$categoryKey . "_serial"] . "\n" . $item->implant_model_sn
                        : $item->implant_model_sn);

                // Append qty
                $formattedData[$implantId][$categoryKey . "_qty"] =
                    ($formattedData[$implantId][$categoryKey . "_qty"] !== 'N/A'
                        ? $formattedData[$implantId][$categoryKey . "_qty"] . "\n" . $item->implant_model_qty
                        : $item->implant_model_qty);

                // Append price
                $formattedData[$implantId][$categoryKey . "_price"] =
                    ($formattedData[$implantId][$categoryKey . "_price"] !== 'N/A'
                        ? $formattedData[$implantId][$categoryKey . "_price"] . "\n" . 'RM ' . number_format($item->implant_model_itemPrice, 2)
                        : 'RM ' . number_format($item->implant_model_itemPrice, 2));
            }
        }

        return collect(array_values($formattedData));
    }

    public function headings(): array
    {
        $modelCategories = DB::table('model_categories')
            // ->where('mcategory_ismorethanone', 0)
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
            "Serial Number",
            "Qty",
            "Price (RM)",
        ];

        $dynamicHeaders = [];
        foreach ($modelCategories as $category) {
            $dynamicHeaders[] = $category . " Model";
            $dynamicHeaders[] = $category . " Serial Number";
            $dynamicHeaders[] = $category . " Qty";
            $dynamicHeaders[] = $category . " Price (RM)";
        }

        $endingHeaders = [
            "Patient Name",
            "MRN",
            "IC/Passport Number",
            "Total Sales (RM)",
            "Payment Method",
        ];

        return array_merge($baseHeaders, $dynamicHeaders, $endingHeaders);
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                $highestColumn = $sheet->getHighestColumn();
                $highestRow = $sheet->getHighestRow();

                // ---- TITLES ----
                $sheet->setCellValue('A1', 'Abbott | Cardiac Rhythm Management Division');
                $sheet->mergeCells("A1:{$highestColumn}1");

                $sheet->setCellValue('A2', 'Implant List');
                $sheet->mergeCells("A2:{$highestColumn}2");

                $sheet->setCellValue('A3', 'Generated on: ' . date('d/m/Y H:i:s'));
                $sheet->mergeCells("A3:{$highestColumn}3");

                // ---- STYLES (titles + headers) ----
                $sheet->getStyle('A1')->applyFromArray([
                    'font' => ['bold' => true, 'size' => 16],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER,
                    ],
                ]);

                $sheet->getStyle('A2')->applyFromArray([
                    'font' => ['bold' => true, 'size' => 14],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER,
                    ],
                ]);

                $sheet->getStyle('A3')->applyFromArray([
                    'font' => ['size' => 10, 'italic' => true, 'color' => ['rgb' => '666666']],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER,
                    ],
                ]);

                // ---- HEADER ROW ----
                $sheet->getRowDimension('4')->setRowHeight(25);

                $sheet->getStyle("A4:{$highestColumn}4")->applyFromArray([
                    'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['rgb' => '333333'],
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER,
                        'wrapText' => true,
                    ],
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['rgb' => 'FFFFFF'],
                        ],
                    ],
                ]);

                // ---- AUTO HEIGHT FOR ALL DATA ROWS ----
                for ($row = 5; $row <= $highestRow; $row++) {
                    $sheet->getRowDimension($row)->setRowHeight(-1); // auto height

                    // Apply wrapText to entire row (so newlines show properly)
                    $sheet->getStyle("A{$row}:{$highestColumn}{$row}")
                        ->getAlignment()->setWrapText(true);
                }

                // ---- AUTO WIDTH FOR ALL COLUMNS (even past Z) ----
                $highestColumnIndex = Coordinate::columnIndexFromString($highestColumn);
                for ($col = 1; $col <= $highestColumnIndex; $col++) {
                    $sheet->getColumnDimension(Coordinate::stringFromColumnIndex($col))->setAutoSize(true);
                }

                $sheet->getStyle("A1:{$highestColumn}{$highestRow}")
                    ->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

                // ---- TABLE BORDER ----
                $sheet->getStyle("A1:{$highestColumn}{$highestRow}")->applyFromArray([
                    'borders' => [
                        'outline' => [
                            'borderStyle' => Border::BORDER_MEDIUM,
                            'color' => ['rgb' => '333333'],
                        ],
                    ],
                ]);

                // ---- FREEZE + FILTER ----
                $sheet->freezePane('A5');
                $sheet->setAutoFilter("A4:{$highestColumn}{$highestRow}");
            },
        ];
    }
}
