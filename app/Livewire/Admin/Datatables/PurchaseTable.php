<?php

namespace App\Livewire\Admin\Datatables;

use App\Exports\PurchasesExport;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Purchase;
use App\Models\Supplier;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use Rappasoft\LaravelLivewireTables\Views\Filters\DateRangeFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\MultiSelectFilter;

class PurchaseTable extends DataTableComponent
{
    public $form = [
        'open' => false,
        'document' => '',
        'client' => '',
        'email' => '',
        'model' => null,
        'view_pdf_path' => 'admin.purchases.pdf',
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
                }),
            MultiSelectFilter::make('Proveedor')
                ->options(
                    Supplier::query()
                        ->orderBy('name')
                        ->get()
                        ->keyBy('id')
                        ->map(fn($tag) => $tag->name)
                        ->toArray()
                )
                ->filter(function($query, array $selected){
                    $query->whereIn('supplier_id', $selected);
                }),
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
            Column::make("Comprobante", "voucher_type")
                ->sortable(),
            Column::make("Serie", "serie")
                ->sortable(),
            Column::make("Correlativo", "correlative")
                ->sortable(),
            // Column::make("Orden de compra", "purchase_order_id")
            //     ->sortable(),
            Column::make("Tipo doc", "supplier.identity.name")
                ->sortable(),
            Column::make("Proveedor", "supplier.name")
                ->sortable(),
            // Column::make("Almacén", "warehouse_id")
            //     ->sortable(),
            Column::make("Total", "total")
                ->sortable(),
            // Column::make("Observation", "observation")
            //     ->sortable(),
            // Column::make("Created at", "created_at")
            //     ->sortable(),
            // Column::make("Updated at", "updated_at")
            //     ->sortable(),
            Column::make("Acciones")
                ->label(function($row){
                    return view('admin.purchases.actions', [
                        'purchase' => $row
                    ]);
                })
        ];
    }

    // evita N+1
    public function builder(): Builder
    {
        return Purchase::query()->with(['supplier']);
    }

    public function openModal(Purchase $purchase)
    {
        $this->form['open'] = true;
        $this->form['document'] = 'Compra '. $purchase->serie . '-' . $purchase->correlative;
        $this->form['proveedor'] = $purchase->supplier->name . ' - ' . $purchase->supplier->document_number;
        $this->form['email'] = $purchase->supplier->email;
        $this->form['model'] = $purchase;
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
        $purchases = count($selected)
            ? Purchase::whereIn('id', $selected)->get()
            : Purchase::all();

        return Excel::download(new PurchasesExport($purchases), 'compras.xlsx');
    }
}
