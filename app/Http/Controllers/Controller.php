<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;


    // public function registerEvents(): array
    // {
    //     return [
    //         AfterSheet::class => function (AfterSheet $event) {
    //             $sheet = $event->sheet->getDelegate();

    //             // Get the highest column and row
    //             $highestColumn = $sheet->getHighestColumn();
    //             $highestRow = $sheet->getHighestRow();

    //             // Add company title
    //             $sheet->setCellValue('A1', 'Abbott | Cardiac Rhythm Management Division');
    //             $sheet->mergeCells('A1:' . $highestColumn . '1');

    //             // Add report title
    //             $sheet->setCellValue('A2', 'Implant List');
    //             $sheet->mergeCells('A2:' . $highestColumn . '2');

    //             // Add generation date
    //             $sheet->setCellValue('A3', 'Generated on: ' . date('d/m/Y H:i:s'));
    //             $sheet->mergeCells('A3:' . $highestColumn . '3');

    //             // Style the main title (Row 1)
    //             $sheet->getStyle('A1')->applyFromArray([
    //                 'font' => [
    //                     'bold' => true,
    //                     'size' => 16,
    //                     'color' => ['rgb' => '00000'],
    //                 ],
    //                 'alignment' => [
    //                     'horizontal' => Alignment::HORIZONTAL_CENTER,
    //                     'vertical' => Alignment::VERTICAL_CENTER,
    //                 ],
    //             ]);

    //             // Style the subtitle (Row 2)
    //             $sheet->getStyle('A2')->applyFromArray([
    //                 'font' => [
    //                     'bold' => true,
    //                     'size' => 14,
    //                     'color' => ['rgb' => '000000'],
    //                 ],
    //                 'alignment' => [
    //                     'horizontal' => Alignment::HORIZONTAL_CENTER,
    //                     'vertical' => Alignment::VERTICAL_CENTER,
    //                 ],
    //             ]);

    //             // Style the date (Row 3)
    //             $sheet->getStyle('A3')->applyFromArray([
    //                 'font' => [
    //                     'size' => 10,
    //                     'italic' => true,
    //                     'color' => ['rgb' => '666666'],
    //                 ],
    //                 'alignment' => [
    //                     'horizontal' => Alignment::HORIZONTAL_CENTER,
    //                     'vertical' => Alignment::VERTICAL_CENTER,
    //                 ],
    //             ]);

    //             // Set row heights
    //             $sheet->getRowDimension('1')->setRowHeight(30);
    //             $sheet->getRowDimension('2')->setRowHeight(25);
    //             $sheet->getRowDimension('3')->setRowHeight(20);
    //             $sheet->getRowDimension('4')->setRowHeight(25); // Header row

    //             // Style the header row (Row 4)
    //             $sheet->getStyle('A4:' . $highestColumn . '4')->applyFromArray([
    //                 'font' => [
    //                     'bold' => true,
    //                     'size' => 11,
    //                     'color' => ['rgb' => 'FFFFFF'],
    //                 ],
    //                 'fill' => [
    //                     'fillType' => Fill::FILL_SOLID,
    //                     'startColor' => ['rgb' => '333333'], // Dark gray
    //                 ],
    //                 'alignment' => [
    //                     'horizontal' => Alignment::HORIZONTAL_CENTER,
    //                     'vertical' => Alignment::VERTICAL_CENTER,
    //                     'wrapText' => true,
    //                 ],
    //                 'borders' => [
    //                     'allBorders' => [
    //                         'borderStyle' => Border::BORDER_THIN,
    //                         'color' => ['rgb' => 'FFFFFF'],
    //                     ],
    //                 ],
    //             ]);

    //             // Style data rows with alternating colors
    //             for ($row = 5; $row <= $highestRow; $row++) {
    //                 $fillColor = ($row % 2 == 0) ? 'F8F9FA' : 'FFFFFF'; // Light gray and white alternating

    //                 $sheet->getStyle('A' . $row . ':' . $highestColumn . $row)->applyFromArray([
    //                     'fill' => [
    //                         'fillType' => Fill::FILL_SOLID,
    //                         'startColor' => ['rgb' => $fillColor],
    //                     ],
    //                     'alignment' => [
    //                         'vertical' => Alignment::VERTICAL_CENTER,
    //                         'wrapText' => true,
    //                     ],
    //                     'borders' => [
    //                         'allBorders' => [
    //                             'borderStyle' => Border::BORDER_THIN,
    //                             'color' => ['rgb' => 'DDDDDD'],
    //                         ],
    //                     ],
    //                 ]);

    //                 // Set row height for data rows
    //                 $sheet->getRowDimension($row)->setRowHeight(20);
    //             }

    //             // Set column widths
    //             $columnWidths = [
    //                 'A' => 6,   // No
    //                 'B' => 15,  // Implant Date
    //                 'C' => 35,  // Hospital
    //                 'D' => 12,  // Region
    //                 'E' => 20,  // Product Group
    //                 'F' => 30,  // Doctor
    //                 'G' => 20,  // Generator Name
    //                 'H' => 18,  // Generator Model
    //                 'I' => 18,  // Serial Number
    //                 'J' => 8,   // Qty
    //                 'K' => 15,  // Price
    //             ];

    //             // Apply static column widths
    //             foreach ($columnWidths as $column => $width) {
    //                 $sheet->getColumnDimension($column)->setWidth($width);
    //             }

    //             // Dynamic column widths for model categories
    //             $modelCategories = DB::table('model_categories')
    //                 ->where('mcategory_ismorethanone', 0)
    //                 ->pluck('mcategory_name')
    //                 ->toArray();

    //             $columnLetter = 'L'; // Start after the static columns

    //             foreach ($modelCategories as $category) {
    //                 $sheet->getColumnDimension($columnLetter)->setWidth(20); // Model
    //                 $columnLetter++;
    //                 $sheet->getColumnDimension($columnLetter)->setWidth(18); // Serial Number
    //                 $columnLetter++;
    //                 $sheet->getColumnDimension($columnLetter)->setWidth(8);  // Qty
    //                 $columnLetter++;
    //                 $sheet->getColumnDimension($columnLetter)->setWidth(15); // Price
    //                 $columnLetter++;
    //             }

    //             // Set widths for ending columns
    //             $endingWidths = [30, 15, 20, 15, 25]; // Patient Name, MRN, IC/Passport, Total Sales, Added By

    //             foreach ($endingWidths as $width) {
    //                 $sheet->getColumnDimension($columnLetter)->setWidth($width);
    //                 $columnLetter++;
    //             }

    //             for ($row = 5; $row <= $highestRow; $row++) {
    //                 $sheet->getRowDimension($row)->setRowHeight(-1); // -1 lets Excel auto-fit height
    //             }

    //             // Center align specific columns (numbers, dates, etc.)
    //             $centerAlignColumns = ['A', 'B', 'D', 'J', 'K']; // No, Date, Region, Qty, Price

    //             foreach ($centerAlignColumns as $column) {
    //                 $sheet->getStyle($column . '5:' . $column . $highestRow)->getAlignment()
    //                     ->setHorizontal(Alignment::HORIZONTAL_CENTER);
    //             }

    //             // Apply borders to the entire table
    //             $sheet->getStyle('A1:' . $highestColumn . $highestRow)->applyFromArray([
    //                 'borders' => [
    //                     'outline' => [
    //                         'borderStyle' => Border::BORDER_MEDIUM,
    //                         'color' => ['rgb' => '333333'],
    //                     ],
    //                 ],
    //             ]);

    //             // Freeze the header rows
    //             $sheet->freezePane('A5');

    //             // Auto-filter for the data
    //             $sheet->setAutoFilter('A4:' . $highestColumn . $highestRow);
    //         },
    //     ];
    // }
}
