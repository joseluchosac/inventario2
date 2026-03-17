<?php

use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/suppliers', function(Request $request){
    return Supplier::select('id', 'name')
        ->when($request->search, function($query, $search){
            $query->where('name', 'like', '%' . $search . '%')
                ->orWhere('document_number', 'like', '%' . $search . '%');
        })
        ->when($request->exists('selected'),
        fn ($query) => $query->whereIn('id', $request->array('selected')),
        fn ($query) => $query->limit(10)
       )->get();
})->name('api.suppliers.index');

Route::post('/products', function(Request $request){
    return Product::select('id', 'name')
        ->when($request->search,
            fn($query, $search) => $query->where('name', 'like', '%' . $search . '%')
                ->orWhere('sku', 'like', '%' . $search . '%')
        )
        ->when($request->exists('selected'),
            fn ($query) => $query->shereIn('id', $request->array('selected')),
            fn ($query) => $query->limit(10)
       )->get();
})->name('api.products.index');



