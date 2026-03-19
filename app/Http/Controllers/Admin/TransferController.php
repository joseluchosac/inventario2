<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class TransferController extends Controller
{
    public function index()
    {
        return view('admin.transfers.index');
    }

    public function create()
    {
        return view('admin.transfers.create');    
    }
}
