<?php

namespace App\Exports;

use App\Models\ApprovalType;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Maatwebsite\Excel\Concerns\WithEvents;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Maatwebsite\Excel\Concerns\FromCollection;
use PhpOffice\PhpSpreadsheet\Style\Border;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithTitle;

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
            ->where('mcategory_ismorethanone', 0)
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
            ->where('k.mcategory_ismorethanone', '=', 0)
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

            if ($item->model_category) {
                $formattedData[$implantId][$item->model_category . "_model"] = $item->model_code ?? 'N/A';
                $formattedData[$implantId][$item->model_category . "_serial"] = $item->implant_model_sn ?? 'N/A';
                $formattedData[$implantId][$item->model_category . "_qty"] = $item->implant_model_qty ?? 'N/A';
                $formattedData[$implantId][$item->model_category . "_price"] = $item->implant_model_itemPrice ? 'RM ' . number_format($item->implant_model_itemPrice, 2) : 'N/A';
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
                
                // Get the highest column and row
                $highestColumn = $sheet->getHighestColumn();
                $highestRow = $sheet->getHighestRow();
                
                // Add company title
                $sheet->setCellValue('A1', 'Abbott | Cardiac Rhythm Management Division');
                $sheet->mergeCells('A1:' . $highestColumn . '1');
                
                // Add report title
                $sheet->setCellValue('A2', 'Implant List');
                $sheet->mergeCells('A2:' . $highestColumn . '2');
                
                // Add generation date
                $sheet->setCellValue('A3', 'Generated on: ' . date('d/m/Y H:i:s'));
                $sheet->mergeCells('A3:' . $highestColumn . '3');
                
                // Style the main title (Row 1)
                $sheet->getStyle('A1')->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'size' => 16,
                        'color' => ['rgb' => '00000'],
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER,
                    ],
                ]);
                
                // Style the subtitle (Row 2)
                $sheet->getStyle('A2')->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'size' => 14,
                        'color' => ['rgb' => '000000'],
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER,
                    ],
                ]);
                
                // Style the date (Row 3)
                $sheet->getStyle('A3')->applyFromArray([
                    'font' => [
                        'size' => 10,
                        'italic' => true,
                        'color' => ['rgb' => '666666'],
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER,
                    ],
                ]);
                
                // Set row heights
                $sheet->getRowDimension('1')->setRowHeight(30);
                $sheet->getRowDimension('2')->setRowHeight(25);
                $sheet->getRowDimension('3')->setRowHeight(20);
                $sheet->getRowDimension('4')->setRowHeight(25); // Header row
                
                // Style the header row (Row 4)
                $sheet->getStyle('A4:' . $highestColumn . '4')->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'size' => 11,
                        'color' => ['rgb' => 'FFFFFF'],
                    ],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['rgb' => '333333'], // Dark gray
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
                
                // Style data rows with alternating colors
                for ($row = 5; $row <= $highestRow; $row++) {
                    $fillColor = ($row % 2 == 0) ? 'F8F9FA' : 'FFFFFF'; // Light gray and white alternating
                    
                    $sheet->getStyle('A' . $row . ':' . $highestColumn . $row)->applyFromArray([
                        'fill' => [
                            'fillType' => Fill::FILL_SOLID,
                            'startColor' => ['rgb' => $fillColor],
                        ],
                        'alignment' => [
                            'vertical' => Alignment::VERTICAL_CENTER,
                            'wrapText' => true,
                        ],
                        'borders' => [
                            'allBorders' => [
                                'borderStyle' => Border::BORDER_THIN,
                                'color' => ['rgb' => 'DDDDDD'],
                            ],
                        ],
                    ]);
                    
                    // Set row height for data rows
                    $sheet->getRowDimension($row)->setRowHeight(20);
                }
                
                // Set column widths
                $columnWidths = [
                    'A' => 6,   // No
                    'B' => 15,  // Implant Date
                    'C' => 35,  // Hospital
                    'D' => 12,  // Region
                    'E' => 20,  // Product Group
                    'F' => 30,  // Doctor
                    'G' => 20,  // Generator Name
                    'H' => 18,  // Generator Model
                    'I' => 18,  // Serial Number
                    'J' => 8,   // Qty
                    'K' => 15,  // Price
                ];
                
                // Apply static column widths
                foreach ($columnWidths as $column => $width) {
                    $sheet->getColumnDimension($column)->setWidth($width);
                }
                
                // Dynamic column widths for model categories
                $modelCategories = DB::table('model_categories')
                    ->where('mcategory_ismorethanone', 0)
                    ->pluck('mcategory_name')
                    ->toArray();
                
                $columnLetter = 'L'; // Start after the static columns
                
                foreach ($modelCategories as $category) {
                    $sheet->getColumnDimension($columnLetter)->setWidth(20); // Model
                    $columnLetter++;
                    $sheet->getColumnDimension($columnLetter)->setWidth(18); // Serial Number
                    $columnLetter++;
                    $sheet->getColumnDimension($columnLetter)->setWidth(8);  // Qty
                    $columnLetter++;
                    $sheet->getColumnDimension($columnLetter)->setWidth(15); // Price
                    $columnLetter++;
                }
                
                // Set widths for ending columns
                $endingWidths = [30, 15, 20, 15, 25]; // Patient Name, MRN, IC/Passport, Total Sales, Added By
                
                foreach ($endingWidths as $width) {
                    $sheet->getColumnDimension($columnLetter)->setWidth($width);
                    $columnLetter++;
                }
                
                // Center align specific columns (numbers, dates, etc.)
                $centerAlignColumns = ['A', 'B', 'D', 'J', 'K']; // No, Date, Region, Qty, Price
                
                foreach ($centerAlignColumns as $column) {
                    $sheet->getStyle($column . '5:' . $column . $highestRow)->getAlignment()
                        ->setHorizontal(Alignment::HORIZONTAL_CENTER);
                }
                
                // Apply borders to the entire table
                $sheet->getStyle('A1:' . $highestColumn . $highestRow)->applyFromArray([
                    'borders' => [
                        'outline' => [
                            'borderStyle' => Border::BORDER_MEDIUM,
                            'color' => ['rgb' => '333333'],
                        ],
                    ],
                ]);
                
                // Freeze the header rows
                $sheet->freezePane('A5');
                
                // Auto-filter for the data
                $sheet->setAutoFilter('A4:' . $highestColumn . $highestRow);
            },
        ];
    }
}