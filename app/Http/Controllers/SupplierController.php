<?php

namespace App\Http\Controllers;

use App\Models\Supplier;

final class SupplierController extends Controller
{
    public function index()
    {
        return view('suppliers.index');
    }

    public function create()
    {
        return view('suppliers.create');
    }

    public function show(Supplier $supplier)
    {
        return view('suppliers.show', compact('supplier'));
    }
}
