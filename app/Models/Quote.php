<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quote extends Model
{
    protected $fillable = [
        'bourcher_type', 
        'serie', 
        'correlative', 
        'date', 
        'customer_id', 
        'total', 
        'observation'
    ];

    // Relación muchos a muchos polimórfica
    public function products(){
        return $this->morphToMany(Product::class, 'productable')
            ->withPivot('quantity', 'price', 'subtotal') // Ademas trae los siguientes campos de la tabla pivot
            ->withTimestamps();
    }

    // Relación uno a muchos inversa
    public function customer(){
        return $this->belongsTo(Customer::class);
    }
}
