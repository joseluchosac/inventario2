<?php

namespace App\Livewire\Admin\Datatables;

use App\Exports\SalesExport;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Purchase;
use App\Models\Sale;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use Rappasoft\LaravelLivewireTables\Views\Filters\DateRangeFilter;

class SaleTable extends DataTableComponent
{
    public $form = [
        'open' => false,
        'document' => '',
        'client' => '',
        'email' => '',
        'model' => null,
        'view_pdf_path' => 'admin.sales.pdf',
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
            Column::make("Tipo compr", "voucher_type")
                ->sortable(),
            Column::make("Serie", "serie")
                ->sortable(),
            Column::make("Correlativo", "correlative")
                ->sortable(),
            // Column::make("Cotización", "quote_id")
            //     ->sortable(),
            Column::make("Tipo doc", "customer.identity.name")
                ->sortable(),
            Column::make("Cliente", "customer.name")
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
                    return view('admin.sales.actions', [
                        'sale' => $row
                    ]);
                })
        ];
    }

    // evita N+1
    public function builder(): Builder
    {
        return Sale::query()->with(['customer']);
    }

    public function openModal(Sale $sale)
    {
        $this->form['open'] = true;
        $this->form['document'] = 'Venta '. $sale->serie . '-' . $sale->correlative;
        $this->form['client'] = $sale->customer->name . ' - ' . $sale->customer->document_number;
        $this->form['email'] = $sale->customer->email;
        $this->form['model'] = $sale;
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
        $sales = count($selected)
            ? Sale::whereIn('id', $selected)->get()
            : Sale::all();

        return Excel::download(new SalesExport($sales), 'ventas.xlsx');
    }
}
