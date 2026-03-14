<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Identity;
use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.suppliers.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $identities = Identity::all();
        return view('admin.suppliers.create', compact('identities'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'identity_id' => 'required|exists:identities,id',
            'document_number' => 'required|max:20|unique:suppliers,document_number',
            'name' => 'required|min:3|max:100',
            'address' => 'nullable|max:100',
            'email' => 'nullable|email|max:100|unique:suppliers,email',
            'phone' => 'nullable|max:20'
        ]);

        $supplier = Supplier::create($validated);

        session()->flash('swal', [
            'title' =>"Bien hecho!",
            'text' =>"Proveedor creado con éxito",
            'icon' =>"success"
        ]);

        return redirect()->route('admin.suppliers.edit', $supplier);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Supplier $supplier)
    {
        $identities = Identity::all();
        return view('admin.suppliers.edit', compact('supplier', 'identities'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Supplier $supplier)
    {
        $validated = $request->validate([
            'identity_id' => 'required|exists:identities,id',
            'document_number' => 'required|max:20|unique:suppliers,document_number,' . $supplier->id,
            'name' => 'required|min:3|max:100',
            'address' => 'nullable|max:100',
            'email' => 'nullable|email|max:100|unique:suppliers,email,' . $supplier->id,
            'phone' => 'nullable|max:20'
        ]);

        $supplier->update($validated);

        session()->flash('swal', [
            'title' =>"Bien hecho!",
            'text' =>"Proveedor actualizado con éxito",
            'icon' =>"success"
        ]);

        return redirect()->route('admin.suppliers.edit', $supplier);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Supplier $supplier)
    {
        if($supplier->purchases()->exists() || $supplier->purchaseOrders()->exists()){
            session()->flash('swal', [
                'title' =>"Error!",
                'text' =>"No se puede eliminar este proveedor",
                'icon' =>"error"
            ]);
            return redirect()->route('admin.suppliers.index');
        }

        $supplier->delete();
        session()->flash('swal', [
            'title' =>"Bien hecho!",
            'text' =>"Proveedor eliminado con éxito",
            'icon' =>"success"
        ]);
        return redirect()->route('admin.suppliers.index');
    }
}
