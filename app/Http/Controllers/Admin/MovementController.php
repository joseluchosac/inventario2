<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class MovementController extends Controller
{
    public function index()
    {
        return view('admin.movements.index');
    }

    public function create()
    {
        return view('admin.movements.create');    
    }
}
