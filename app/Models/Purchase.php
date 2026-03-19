<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    protected $fillable = [
        'voucher_type', 
        'serie', 
        'correlative', 
        'date', 
        'purchase_order_id', 
        'supplier_id',
        'warehouse_id', 
        'total', 
        'observation'
    ];

    protected $casts = [
        'date' => 'datetime',
    ];

    // Relación muchos a muchos polimórfica
    public function products(){
        return $this->morphToMany(Product::class, 'productable')
            ->withPivot('quantity', 'price', 'subtotal') // Ademas trae los siguientes campos de la tabla pivot
            ->withTimestamps();
    }

    // Relación uno a muchos inversa
    public function supplier(){
        return $this->belongsTo(Supplier::class);
    }

    // Relación uno a uno inversa
    public function purchaseOrder(){
        return $this->belongsTo(PurchaseOrder::class);
    }

    // Relación uno a muchos polimórfica
    public function inventories()
    {
        return $this->morphMany(Inventory::class, 'inventoryable');
    }
}
