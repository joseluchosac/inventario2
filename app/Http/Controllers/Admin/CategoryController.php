<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.categories.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|min:3|max:100|unique:categories,name',
            'description' => 'nullable|max:1000'
        ]);
        $category = Category::create($validated);

        session()->flash('swal', [
            'title' =>"Bien hecho!",
            'text' =>"Registro creado con éxito",
            'icon' =>"success"
        ]);

        return redirect()->route('admin.categories.edit', $category);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|min:3|max:100|unique:categories,name,' . $category->id,
            'description' => 'nullable|max:1000'
        ]);
        $category->update($validated);
        session()->flash('swal', [
            'title' =>"Bien hecho!",
            'text' =>"Registro actualizado con éxito",
            'icon' =>"success"
        ]);
        return redirect()->route('admin.categories.edit', $category);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        if($category->products()->exists()){
            session()->flash('swal', [
                'title' =>"Error!",
                'text' =>"No se puede eliminar esta categoría porque tiene productos asociados",
                'icon' =>"error"
            ]);
        }else{
            $category->delete();
            session()->flash('swal', [
                'title' =>"Bien hecho!",
                'text' =>"Registro eliminado con éxito",
                'icon' =>"success"
            ]);
        }
        return redirect()->route('admin.categories.index');
    }
}
