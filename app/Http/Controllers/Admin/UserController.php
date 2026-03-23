<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.users.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:100|unique:users,email',
            'password' => 'required|string|min:8|confirmed'
        ], [], [
            'name' => 'nombre',
            'password' => 'contraseña'
        ]);

        $password = bcrypt($data['password']);
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $password
        ]);

        session()->flash('swal', [
            'icon' => "success",
            'title' => "Bien hecho!",
            'text' => "Usuario registrado con éxito",
        ]);

        return redirect()->route('admin.users.edit', $user);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:100|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed'
        ], [], [
            'name' => 'nombre',
            'password' => 'contraseña'
        ]);

        if (!empty($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        } else {
            unset($data['password']);
        }

        $user->update($data);

        session()->flash('swal', [
            'icon' => "success",
            'title' => "Bien hecho!",
            'text' => "Usuario actualizado con éxito",
        ]);

        return redirect()->route('admin.users.edit', $user);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        // if ($user->sales()->exists() || $user->quotes()->exists()) {
        //     session()->flash('swal', [
        //         'title' => "Error!",
        //         'text' => "No se puede eliminar este cliente",
        //         'icon' => "error"
        //     ]);
        //     return redirect()->route('admin.customers.index');
        // }

        $user->delete();
        session()->flash('swal', [
            'title' => "Bien hecho!",
            'text' => "Usuario eliminado con éxito",
            'icon' => "success"
        ]);
        return redirect()->route('admin.users.index');
    }
}
