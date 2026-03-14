<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Identity;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.customers.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $identities = Identity::all();
        return view('admin.customers.create', compact('identities'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'identity_id' => 'required|exists:identities,id',
            'document_number' => 'required|max:20|unique:customers,document_number',
            'name' => 'required|min:3|max:100',
            'address' => 'nullable|max:100',
            'email' => 'nullable|email|max:100|unique:customers,email',
            'phone' => 'nullable|max:20'
        ]);

        $customer = Customer::create($validated);

        session()->flash('swal', [
            'title' =>"Bien hecho!",
            'text' =>"Cliente creado con éxito",
            'icon' =>"success"
        ]);

        return redirect()->route('admin.customers.edit', $customer);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer)
    {
        $identities = Identity::all();
        return view('admin.customers.edit', compact('customer', 'identities'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Customer $customer)
    {
        $validated = $request->validate([
            'identity_id' => 'required|exists:identities,id',
            'document_number' => 'required|max:20|unique:customers,document_number,' . $customer->id,
            'name' => 'required|min:3|max:100',
            'address' => 'nullable|max:100',
            'email' => 'nullable|email|max:100|unique:customers,email,' . $customer->id,
            'phone' => 'nullable|max:20'
        ]);

        $customer->update($validated);

        session()->flash('swal', [
            'title' =>"Bien hecho!",
            'text' =>"Cliente actualizado con éxito",
            'icon' =>"success"
        ]);

        return redirect()->route('admin.customers.edit', $customer);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        if($customer->sales()->exists() || $customer->quotes()->exists()){
            session()->flash('swal', [
                'title' =>"Error!",
                'text' =>"No se puede eliminar este cliente",
                'icon' =>"error"
            ]);
            return redirect()->route('admin.customers.index');
        }

        $customer->delete();
        session()->flash('swal', [
            'title' =>"Bien hecho!",
            'text' =>"Cliente eliminado con éxito",
            'icon' =>"success"
        ]);
        return redirect()->route('admin.customers.index');
    }
}
