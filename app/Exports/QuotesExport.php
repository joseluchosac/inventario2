<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class QuotesExport implements FromCollection, WithHeadings, WithStyles, ShouldAutoSize, WithEvents
{
    public $quotes;

    public function __construct($quotes)
    {
        $this->quotes = $quotes;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return $this->quotes->map(function($quote){
            return [
                $quote->id,
                $quote->date,
                $quote->voucher_type == 1 ? 'Factura' : 'Boleta',
                $quote->serie,
                $quote->correlative,
                $quote->customer->name,
                $quote->total,
                $quote->observation,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'id',
            'date',
            'voucher_type',
            'serie',
            'correlative',
            'customer',
            'total',
            'observation',
        ];
    }

    public function styles(Worksheet $worksheet): array
    {
        $lastRow = $worksheet->getHighestRow();
        $lastColumn = $worksheet->getHighestColumn();

        $fullRange = 'A1:' . $lastColumn . $lastRow;

        return [
            1 => [
                'font' => [
                    'bold' => 'true',
                ],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['argb' => 'FFCCCCCC']
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                ]
            ],
            $fullRange => [
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['argb' => 'FF000000']
                    ],
                ],
            ]
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event){
                $event->sheet->getDelegate()->setSelectedCell('A1');
            }
        ];
    }
}
