<?php

namespace App\Livewire\Admin\Datatables;

use App\Exports\MovementsExport;
use App\Models\Movement;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Quote;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use Rappasoft\LaravelLivewireTables\Views\Filters\DateRangeFilter;

class MovementTable extends DataTableComponent
{
    public $form = [
        'open' => false,
        'document' => '',
        'client' => '',
        'email' => '',
        'model' => null,
        'view_pdf_path' => 'admin.movements.pdf',
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
            Column::make("Tipo", "type")
                ->sortable()
                ->format(fn($value) => $value == 1 ? 'Entrada' : 'Salida'),
            Column::make("Serie", "serie")
                ->sortable(),
            Column::make("Correlativo", "correlative")
                ->sortable(),
            Column::make("Almacén", "warehouse.name")
                ->sortable(),
            Column::make("Motivo", "reason.name")
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
                    return view('admin.movements.actions', [
                        'movement' => $row
                    ]);
                })
        ];
    }

    // evita N+1
    public function builder(): Builder
    {
        return Movement::query()->with(['warehouse', 'reason']);
    }

    public function openModal(Movement $movement)
    {
        $this->form['open'] = true;
        $this->form['document'] = 'Movimiento '. $movement->serie . '-' . $movement->correlative;
        $this->form['client'] = $movement->warehouse->name;
        $this->form['email'] = '';
        $this->form['model'] = $movement;
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
        $movements = count($selected)
            ? Movement::whereIn('id', $selected)->with(['warehouse', 'reason'])->get()
            : Movement::with(['warehouse', 'reason'])->get();

        return Excel::download(new MovementsExport($movements), 'movimientos.xlsx');
    }
}
