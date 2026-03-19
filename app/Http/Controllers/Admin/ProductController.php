<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.products.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|min:3|max:100|unique:products,name',
            'description' => 'nullable|max:1000',
            'sku' => 'nullable|max:100',
            'barcode' => 'nullable|max:100',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id'
        ]);
        $product = Product::create($validated);

        session()->flash('swal', [
            'title' =>"Bien hecho!",
            'text' =>"Producto creado con éxito",
            'icon' =>"success"
        ]);

        return redirect()->route('admin.products.edit', $product);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|min:3|max:100|unique:products,name,' . $product->id,
            'description' => 'nullable|max:1000',
            'sku' => 'nullable|max:100',
            'barcode' => 'nullable|max:100',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id'
        ]);

        $product->update($validated);

        session()->flash('swal', [
            'title' =>"Bien hecho!",
            'text' =>"Producto actualizado con éxito",
            'icon' =>"success"
        ]);

        return redirect()->route('admin.products.edit', $product);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        if($product->inventories()->exists() || $product->purchaseOrders()->exists() || $product->quotes()->exists()){
            session()->flash('swal', [
                'title' =>"Error!",
                'text' =>"No se puede eliminar este producto",
                'icon' =>"error"
            ]);
            return redirect()->route('admin.categories.index');
        }

        $product->delete();
        session()->flash('swal', [
            'title' =>"Bien hecho!",
            'text' =>"Producto eliminado con éxito",
            'icon' =>"success"
        ]);
        return redirect()->route('admin.products.index');
    }

    public function dropzone(Request $request, Product $product)
    {
        $path = Storage::put('/images', $request->file('file'));
        $image = $product->images()->create([
            'path' => $path,
            'size' => $request->file('file')->getSize(),
        ]);
        return response()->json([
            'id' => $image->id,
            'path' => $image->path,
        ]);
    }

    public function kardex(Product $product)
    {
        return view('admin.products.kardex', compact('product'));
    }
}
