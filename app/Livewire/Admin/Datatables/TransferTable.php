<?php

namespace App\Livewire\Admin\Datatables;

use App\Exports\TransfersExport;
use App\Models\Movement;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Quote;
use App\Models\Transfer;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use Rappasoft\LaravelLivewireTables\Views\Filters\DateRangeFilter;

class TransferTable extends DataTableComponent
{
    public $form = [
        'open' => false,
        'document' => '',
        'client' => '',
        'email' => '',
        'model' => null,
        'view_pdf_path' => 'admin.transfers.pdf',
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
            Column::make("Serie", "serie")
                ->sortable(),
            Column::make("Correlativo", "correlative")
                ->sortable(),
            Column::make("Origen", "originWarehouse.name")
                ->sortable(),
            Column::make("Destino", "destinationWarehouse.name")
                ->sortable(),
            Column::make("Total", "total")
                ->sortable()
                ->format(fn($value) => 'S/ ' . number_format($value, 2, '.', ',')),
            Column::make("Acciones")
                ->label(function($row){
                    return view('admin.transfers.actions', [
                        'transfer' => $row
                    ]);
                })
        ];
    }

    // evita N+1
    public function builder(): Builder
    {
        return Transfer::query()->with(['originWarehouse', 'destinationWarehouse']);
    }

    public function openModal(Transfer $transfer)
    {
        $this->form['open'] = true;
        $this->form['document'] = 'Transferencia '. $transfer->serie . '-' . $transfer->correlative;
        $this->form['client'] = $transfer->originWarehouse->name . ' -> ' . $transfer->destinationWarehouse->name;
        // $this->form['almacen_destino'] = $transfer->destinationWarehouse->name;
        $this->form['email'] = '';
        $this->form['model'] = $transfer;
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
        $transfers = count($selected)
            ? Transfer::whereIn('id', $selected)->get()
            : Transfer::all();

        return Excel::download(new TransfersExport($transfers), 'transferencias.xlsx');
    }
}
