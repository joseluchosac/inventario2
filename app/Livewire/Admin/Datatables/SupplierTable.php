<?php

namespace App\Livewire\Admin\Datatables;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Supplier;
use Illuminate\Database\Eloquent\Builder;

class SupplierTable extends DataTableComponent
{
    // protected $model = Supplier::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setDefaultSort('id', 'desc');
    }

    public function columns(): array
    {
        return [
            Column::make("Id", "id")
                ->sortable(),
            Column::make("Tipo doc", "identity.name")
                ->sortable(),
            Column::make("Número doc", "document_number")
                ->searchable()
                ->sortable(),
            Column::make("Nombre", "name")
                ->searchable()
                ->sortable(),
            Column::make("Dirección", "address")
                ->sortable(),
            Column::make("Email", "email")
                ->searchable()
                ->sortable(),
            Column::make("Teléfono", "phone")
                ->sortable(),
            Column::make("Creado", "created_at")
                ->sortable(),
            Column::make("Actualizado", "updated_at")
                ->sortable(),
            Column::make("Acciones")
                ->label(function($row){
                    return view('admin.suppliers.actions', ['supplier' => $row]);
                })
        ];
    }

    // evita N+1
    public function builder(): Builder
    {
        return Supplier::query()->with(['identity']);
    }
}
