<?php

namespace App\Http\Controllers;

use App\Models\Customer;

final class CustomerController extends Controller
{
    public function index()
    {
        return view('customers.index');
    }

    public function import()
    {
        return view('customers.import');
    }

    public function create()
    {
        return view('customers.create');
    }

    public function show(Customer $customer)
    {
        return view('customers.show', compact('customer'));
    }
}
