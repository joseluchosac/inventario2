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

class PurchaseOrdersExport implements FromCollection, WithHeadings, WithStyles, ShouldAutoSize, WithEvents
{
    public $purchaseOrders;

    public function __construct($purchaseOrders)
    {
        $this->purchaseOrders = $purchaseOrders;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return $this->purchaseOrders->map(function($purchaseOrder){
            return [
                $purchaseOrder->id,
                $purchaseOrder->date,
                $purchaseOrder->voucher_type == 1 ? 'Factura' : 'Boleta',
                $purchaseOrder->serie,
                $purchaseOrder->correlative,
                $purchaseOrder->supplier->name,
                $purchaseOrder->total,
                $purchaseOrder->observation,
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
            'supplier',
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
