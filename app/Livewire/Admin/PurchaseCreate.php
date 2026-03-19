<?php

namespace App\Livewire\Admin;

use App\Facades\Kardex;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\PurchaseOrder;
use Livewire\Component;

class PurchaseCreate extends Component
{
    public $voucher_type = 1;
    public $serie;
    public $correlative;
    public $date;
    public $purchase_order_id;
    public $supplier_id;
    public $warehouse_id;
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



    public function updated($property, $value) // Cuando se actualiza una propiedad en la vista deve estar con .live
    {
        if($property == 'purchase_order_id'){
            $purchaseOrder = PurchaseOrder::find($value);
            if($purchaseOrder){
                $this->voucher_type = $purchaseOrder->voucher_type;
                $this->supplier_id = $purchaseOrder->supplier_id;
                $this->products = $purchaseOrder->products->map(function($product){
                    return [
                        'id' => $product->id,
                        'name' => $product->name,
                        'quantity' => $product->pivot->quantity,
                        'price' => $product->pivot->price,
                        'subtotal' => $product->pivot->subtotal,
                    ];
                })->toArray();
            }else{
                $this->reset('products', 'voucher_type', 'supplier_id');
            }
        }
    }

    public function addProduct()
    {
        $this->validate([
            'product_id' => 'required|exists:products,id',
            'warehouse_id' => 'required|exists:warehouses,id'
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
        $lastRecord = Kardex::getLastRecord($product->id, $this->warehouse_id);

        $this->products[] = [
            'id' => $product->id,
            'name' => $product->name,
            'quantity' => 1,
            'price' => $lastRecord['cost'],
            'subtotal' => $lastRecord['cost']
        ];

        $this->total += $product->price;
        $this->reset('product_id'); //tambien: $this->product_id = null;

    }

    public function save()
    {
        $this->validate([
            'voucher_type' => 'required|in:1,2',
            'serie' => 'required|string|max:10',
            'correlative' => 'required|string|max:10',
            'date' => 'nullable|date',
            'purchase_order_id' => 'nullable|exists:purchase_orders,id',
            'supplier_id' => 'required|exists:suppliers,id',
            'warehouse_id' => 'required|exists:warehouses,id',
            'total' => 'required|numeric|min:0',
            'observation' => 'nullable',
            'products' => 'required|array|min:1',
            'products.*.id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|numeric|min:1',
            'products.*.price' => 'required|numeric|min:0',
        ],[],[
            'voucher_type' => 'tipo de comprobante',
            'correlative' => 'correlativo',
            'purchase_order_id' => 'orden de compra',
            'supplier_id' => 'proveedor',
            'warehouse_id' => 'almacen',
            'observation' => 'observación',
            'products' => 'productos',
            'products.*.id' => 'producto',
            'products.*.quantity' => 'cantidad',
            'products.*.price' => 'precio',
        ]);

        $purchase = Purchase::create([
            'voucher_type' => $this->voucher_type,
            'serie' => $this->serie,
            'correlative' => $this->correlative,
            'date' => $this->date ?? now(),
            'purchase_order_id' => $this->purchase_order_id,
            'supplier_id' => $this->supplier_id,
            'warehouse_id' => $this->warehouse_id,
            'total' => $this->total,
            'observation' => $this->observation,
        ]);

        foreach ($this->products as $product) {
            $purchase->products()->attach($product['id'],[
                'quantity' => $product['quantity'],
                'price' => $product['price'],
                'subtotal' => $product['quantity'] * $product['price'],
            ]);

            // Actualizar kardex
            Kardex::registerEntry($purchase, $product, $this->warehouse_id, 'Compra');
            
        }

        session()->flash('swal', [
            'icon' =>"success",
            'title' =>"Bien hecho!",
            'text' =>"Compra creada exitosamente",
        ]);

        return redirect()->route('admin.purchases.index');
    }

    public function render()
    {
        return view('livewire.admin.purchase-create');
    }
}
