<?php

namespace App\Livewire\Admin\Datatables;

use App\Models\Inventory;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Rappasoft\LaravelLivewireTables\Views\Columns\ImageColumn;

class ProductTable extends DataTableComponent
{
    // protected $model = Product::class;

    public $openModal = false;
    public $inventories = [];

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setDefaultSort('id', 'desc');

        // Configurar área del modal
        $this->setConfigurableAreas([
            'after-wrapper' => [
                'admin.products.modal'
            ]
        ]);
    }

    public function columns(): array
    {
        return [
            Column::make("Id", "id")
                ->sortable(),
            ImageColumn::make('Imagen')
                ->location(
                    fn($row) => $row->image
                )->attributes(
                    fn($row) => [
                        'class' => 'size-20',
                        'style' => 'object-fit: contain;'
                    ]
                ),
            Column::make("Nombre", "name")
                ->format(fn($value, $row, Column $column) => 
                    '<div class="custom-name truncate">'. $value .'</div>'
                )->html()
                ->searchable()
                ->sortable(),
            // Column::make("Descripción", "description")
            //     ->format(function($value, $row, Column $column) {
            //         return '<div class="custom-description truncate">'. $value .'</div>';
            //     })->html()
            //     ->searchable()
            //     ->sortable(),
            // Column::make("Sku", "sku")
            //     ->searchable()
            //     ->sortable(),
            Column::make("Barcode", "barcode")
                ->searchable()
                ->sortable(),
            Column::make("Categoría", "category.name")
                ->searchable()
                ->sortable(),
            Column::make("Precio", "price")
                ->sortable(),
            Column::make("Stock", "stock")
                ->sortable()
                ->format(function($value, $row){
                    return view('admin.products.stock',[
                        'stock' => $value,
                        'product' => $row
                    ]);
                }),
            Column::make("Creado", "created_at")
                ->format(fn($value) => $value->format('d/m/Y h:i a'))
                ->sortable(),
            Column::make("Actualizado", "updated_at")
                ->format(function($value){
                    return $value->format('d/m/Y h:i a');
                })
                ->sortable(),
            Column::make("Acciones")
                ->label(function($row){
                    return view('admin.products.actions', ['product' => $row]);
                })

        ];
    }

    // evita N+1
    public function builder(): Builder
    {
        return Product::query()->with(['category', 'images']);
    }

    // Método para abrir un modal del stock del producto por almacén
    public function showStock($productId)
    {
        $this->openModal = true;

        $latestInventories = Inventory::where('product_id', $productId)
            ->select('warehouse_id', DB::raw('MAX(id) as id'))
            ->groupBy('warehouse_id')
            ->pluck('id'); // pluck: genera un array a partir de los ids
        
        $this->inventories = Inventory::whereIn('id', $latestInventories)
            ->with(['warehouse'])
            ->get();

        // dd($this->inventories->toArray());
    }
}
