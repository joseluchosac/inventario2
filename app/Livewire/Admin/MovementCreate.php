<?php

namespace App\Livewire\Admin;

use App\Facades\Kardex;
use App\Models\Inventory;
use App\Models\Movement;
use App\Models\Product;
use App\Services\KardexService;
use Livewire\Component;

class MovementCreate extends Component
{
    public $type = 1;
    public $date;
    public $serie = "M001";
    public $correlative;
    public $warehouse_id;
    public $reason_id;
    public $total = 0;
    public $observation;

    public $product_id;
    public $products = [];

    public function boot() // Cuando se renderize
    {
        // Verificando otros errores de validación
        $this->withValidator(function($validator){
            if($validator->fails()){
                $errors = $validator->errors()->toArray();
                $html = "<ul class='text-left'>";
                foreach($errors as $error){
                    $html .= "<li>" . $error[0] . "</li>";
                }
                $html .= "</ul>";
                $this->dispatch('swal', [
                    'icon' =>"error",
                    'title' =>"Error de validación",
                    'html' =>$html,
                ]);
                return false;
            }
        });
    }

    public function mount() // Cuando se monta
    {
        $this->correlative = Movement::max('correlative') + 1;
    }

    public function updated($property, $value){
        if($property == 'type'){
            $this->reset('reason_id');
        }
    }

    public function addProduct()
    {
        $this->validate([
            'product_id' => 'required|exists:products,id',
            'warehouse_id' => 'required|exists:warehouses,id',
        ],[],[
            'product_id' => 'producto',
            'warehouse_id' => 'almacen'
        ]);

        $existing = collect($this->products)
            ->where('id', $this->product_id)
            ->first();

        if($existing){
            // emitir evento livewire
            $this->dispatch('swal', [
                'title' =>"Producto ya agregado",
                'text' =>"El producto ya se encuentra en la lista",
                'icon' =>"warning"
            ]);
            return;
        }
    
        $product = Product::find($this->product_id);

        $lastRecord = Inventory::where('product_id', $product->id)
                ->where('warehouse_id', $this->warehouse_id)
                ->latest('id')
                ->first();

        $costBalance = $lastRecord?->cost_balance ?? 0;

        $this->products[] = [
            'id' => $product->id,
            'name' => $product->name,
            'quantity' => 1,
            'price' => $costBalance,
            'subtotal' => $costBalance,
        ];

        $this->total += $product->price;
        $this->reset('product_id'); //tambien: $this->product_id = null;

    }

    public function save()
    {
        $this->validate([
            'type' => 'required|in:1,2',
            'serie' => 'required|string|max:10',
            'correlative' => 'required|numeric|min:1',
            'date' => 'nullable|date',
            'warehouse_id' => 'required|exists:warehouses,id',
            'reason_id' => 'required|exists:reasons,id',
            'total' => 'required|numeric|min:0',
            'observation' => 'nullable',
            'products' => 'required|array|min:1',
            'products.*.id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|numeric|min:1',
            'products.*.price' => 'required|numeric|min:0',
        ],[],[
            'type' => 'tipo de comprobante',
            'correlative' => 'correlativo',
            'warehouse_id' => 'almacén',
            'reason_id' => 'motivo',
            'observation' => 'observación',
            'products' => 'productos',
            'products.*.id' => 'producto',
            'products.*.quantity' => 'cantidad',
            'products.*.price' => 'precio',
        ]);

        $movement = Movement::create([
            'type' => $this->type,
            'serie' => $this->serie,
            'correlative' => $this->correlative,
            'date' => $this->date ?? now(),
            'warehouse_id' => $this->warehouse_id,
            'reason_id' => $this->reason_id,
            'total' => $this->total,
            'observation' => $this->observation,
        ]);

        foreach ($this->products as $product) {
            $movement->products()->attach($product['id'],[
                'quantity' => $product['quantity'],
                'price' => $product['price'],
                'subtotal' => $product['quantity'] * $product['price'],
            ]);

            // Actualizar kardex
            if($this->type == 1){ // Ingreso
                Kardex::registerEntry($movement, $product, $this->warehouse_id, 'Ingreso');
            }elseif ($this->type == 2) { // Salida
                Kardex::registerExit($movement, $product, $this->warehouse_id, 'Salida');
            }
        }

        session()->flash('swal', [
            'icon' =>"success",
            'title' =>"Bien hecho!",
            'text' =>"Movimiento creada exitosamente",
        ]);

        return redirect()->route('admin.movements.index');
    }

    public function render()
    {
        return view('livewire.admin.movement-create');
    }
}
