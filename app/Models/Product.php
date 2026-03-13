<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 
        'description', 
        'sku', 
        'barcode', 
        'price', 
        'category_id'
    ];

    // Accesores
    public function image(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->images->count() ? Storage::url($this->images->first()->path) : Storage::url('/images/no-image.jpg'),
        );
    }

    // Relación uno a muchos polimórfica
    public function images(){
        return $this->morphMany(Image::class, 'imageable');
    }

    // Relación uno a muchos inversa
    public function category(){
        return $this->belongsTo(Category::class);
    }


    // Relación muchos a muchos polimórfica
    public function purchaseOrders(){
        return $this->morphedByMany(PurchaseOrder::class, 'productable');
    }

    // Relación muchos a muchos polimórfica
    public function quotes(){
        return $this->morphedByMany(Quote::class, 'productable');
    }

    // Relación uno a muchos
    public function inventories(){
        return $this->hasMany(Inventory::class);
    }


}
