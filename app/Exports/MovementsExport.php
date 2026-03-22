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

class MovementsExport implements FromCollection, WithHeadings, WithStyles, ShouldAutoSize, WithEvents
{
    public $movements;

    public function __construct($movements)
    {
        $this->movements = $movements;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return $this->movements->map(function($movement){
            return [
                $movement->id,
                $movement->date,
                $movement->type == 1 ? 'Ingreso' : 'Salida',
                $movement->serie,
                $movement->correlative,
                $movement->warehouse->name,
                $movement->total,
                $movement->observation,
                $movement->reason->name,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'id',
            'date',
            'type',
            'serie',
            'correlative',
            'warehouse',
            'total',
            'observation',
            'reason',
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
