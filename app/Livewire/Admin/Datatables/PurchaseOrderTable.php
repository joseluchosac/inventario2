<?php

namespace App\Livewire\Admin\Datatables;

use App\Exports\PurchaseOrdersExport;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\PurchaseOrder;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use Rappasoft\LaravelLivewireTables\Views\Filters\DateRangeFilter;

class PurchaseOrderTable extends DataTableComponent
{
    public $form = [
        'open' => false,
        'document' => '',
        'client' => '',
        'email' => '',
        'model' => null,
        'view_pdf_path' => 'admin.purchase_orders.pdf',
    ];

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setDefaultSort('id', 'desc');

        // Configurar area para modal
        $this->setConfigurableAreas([
            'after-wrapper' => ['admin.pdf.modal']
        ]);

    }

    public function filters(): array
    {
        return [
            DateRangeFilter::make('Fecha')
                ->config([
                    'placeholder' => 'Seleccione un rango de fechas',
                ])
                ->filter(function($query, array $dateRange){
                    $query->whereBetween('date', [
                        $dateRange['minDate'], 
                        $dateRange['maxDate']
                    ]);
                })
        ];
    }
    
    public function columns(): array
    {
        return [
            Column::make("Id", "id")
                ->sortable(),
            Column::make("Fecha", "date")
                ->sortable()
                ->format(fn($value) => $value->format('Y-m-d')),
            // Column::make("Voucher type", "voucher_type")
            //     ->sortable(),
            Column::make("Serie", "serie")
                ->sortable(),
            Column::make("Correlativo", "correlative")
                ->sortable(),
            Column::make("Nº Documento", "supplier.document_number")
                ->sortable(),
            Column::make("Razón social", "supplier.name")
                ->sortable(),
            Column::make("Total", "total")
                ->sortable()
                ->format(fn($value) => 'S/ ' . number_format($value, 2, '.', ',')),
            // Column::make("Observation", "observation")
            //     ->sortable(),
            // Column::make("Created at", "created_at")
            //     ->sortable(),
            // Column::make("Updated at", "updated_at")
            //     ->sortable(),
            Column::make("Acciones")
                ->label(function($row){
                    return view('admin.purchase_orders.actions', [
                        'purchaseOrder' => $row
                    ]);
                })
        ];
    }

    // evita N+1
    public function builder(): Builder
    {
        return PurchaseOrder::query()->with(['supplier']);
    }

    public function openModal(PurchaseOrder $purchaseOrder)
    {
        $this->form['open'] = true;
        $this->form['document'] = 'Orden de Compra '. $purchaseOrder->serie . '-' . $purchaseOrder->correlative;
        $this->form['client'] = $purchaseOrder->supplier->name . ' - ' . $purchaseOrder->supplier->document_number;
        $this->form['email'] = $purchaseOrder->supplier->email;
        $this->form['model'] = $purchaseOrder;
    }

    public function sendEmail()
    {
        $this->validate([
            'form.email' => 'required|email'
        ]);

        // Llamar a un mailable
        Mail::to($this->form['email'])
            ->send(new \App\Mail\PdfSend($this->form));
        
        // Disparar un evento
        $this->dispatch('swal', [
            'title' => 'Correo enviado',
            'text' => 'El correo ha sido enviado correctamente',
            'icon' => 'success',
        ]);

        $this->reset('form');
    }

    public function bulkActions(): array
    {
        return [
            'exportSelected' => 'Exportar'
        ];
    }

    public function exportSelected()
    {
        $selected = $this->getSelected();
        $purchaseOrders = count($selected)
            ? PurchaseOrder::whereIn('id', $selected)->get()
            : PurchaseOrder::all();

        return Excel::download(new PurchaseOrdersExport($purchaseOrders), 'ordenes_de_compra.xlsx');
    }
}
