<?php

namespace App\Livewire\Admin;

use App\Models\Product;
use App\Models\Quote;
use Livewire\Component;

class QuoteCreate extends Component
{
    public $voucher_type = 1;
    public $serie = "CO01";
    public $correlative;
    public $date;
    public $customer_id;
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
        $this->correlative = Quote::max('correlative') + 1;
    }

    public function addProduct()
    {
        $this->validate([
            'product_id' => 'required|exists:products,id'
        ],[],[
            'product_id' => 'producto'
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

        $this->products[] = [
            'id' => $product->id,
            'name' => $product->name,
            'quantity' => 1,
            'price' => $product->price,
            'subtotal' => $product->price,
        ];

        $this->total += $product->price;
        $this->reset('product_id'); //tambien: $this->product_id = null;

    }

    public function save()
    {
        $this->validate([
            'voucher_type' => 'required|in:1,2',
            'date' => 'nullable|date',
            'customer_id' => 'required|exists:customers,id',
            'total' => 'required|numeric|min:0',
            'observation' => 'nullable',
            'products' => 'required|array|min:1',
            'products.*.id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|numeric|min:1',
            'products.*.price' => 'required|numeric|min:0',
        ],[],[
            'voucher_type' => 'tipo de comprobante',
            'customer_id' => 'cliente',
            'observation' => 'observación',
            'products' => 'productos',
            'products.*.id' => 'producto',
            'products.*.quantity' => 'cantidad',
            'products.*.price' => 'precio',
        ]);

        $quote = Quote::create([
            'voucher_type' => $this->voucher_type,
            'serie' => $this->serie,
            'correlative' => $this->correlative,
            'date' => $this->date ?? now(),
            'customer_id' => $this->customer_id,
            'total' => $this->total,
            'observation' => $this->observation,
        ]);

        foreach ($this->products as $product) {
            $quote->products()->attach($product['id'],[
                'quantity' => $product['quantity'],
                'price' => $product['price'],
                'subtotal' => $product['quantity'] * $product['price'],
            ]);
        }

        session()->flash('swal', [
            'icon' =>"success",
            'title' =>"Bien hecho!",
            'text' =>"Cotización creada exitosamente",
        ]);

        return redirect()->route('admin.quotes.index');
    }

    public function render()
    {
        return view('livewire.admin.quote-create');
    }
}
