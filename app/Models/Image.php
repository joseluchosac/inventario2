<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $fillable = [
        'path',
        'size',
        'imageable_type',
        'imageable_id',
    ];

    // Relación polimórfica
    public function imageable(){
        return $this->morphTo();
    }
}
