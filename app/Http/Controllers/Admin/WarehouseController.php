<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Warehouse;
use Illuminate\Http\Request;

class WarehouseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.warehouses.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.warehouses.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|min:3|max:100|unique:warehouses,name',
            'location' => 'nullable|max:100'
        ]);

        $warehouse = Warehouse::create($validated);

        session()->flash('swal', [
            'title' =>"Bien hecho!",
            'text' =>"Registro creado con éxito",
            'icon' =>"success"
        ]);

        return redirect()->route('admin.warehouses.edit', $warehouse);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Warehouse $warehouse)
    {
        return view('admin.warehouses.edit', compact('warehouse'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Warehouse $warehouse)
    {
        $validated = $request->validate([
            'name' => 'required|min:3|max:100|unique:warehouses,name,' . $warehouse->id,
            'location' => 'nullable|max:100'
        ]);
        $warehouse->update($validated);
        session()->flash('swal', [
            'title' =>"Bien hecho!",
            'text' =>"Registro actualizado con éxito",
            'icon' =>"success"
        ]);
        return redirect()->route('admin.warehouses.edit', $warehouse);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Warehouse $warehouse)
    {
        if($warehouse->inventories()->exists()){
            session()->flash('swal', [
                'title' =>"Error!",
                'text' =>"No se puede eliminar este almacén por que tiene inventarios asociados",
                'icon' =>"error"
            ]);
            return redirect()->route('admin.warehouses.index');
        }
        $warehouse->delete();
        session()->flash('swal', [
            'title' =>"Bien hecho!",
            'text' =>"Registro eliminado con éxito",
            'icon' =>"success"
        ]);
        return redirect()->route('admin.warehouses.index');

    }
}
