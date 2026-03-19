<?php

namespace App\Livewire\Admin\Datatables;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Purchase;
use Illuminate\Database\Eloquent\Builder;

class PurchaseTable extends DataTableComponent
{
    // protected $model = Purchase::class;

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
}
