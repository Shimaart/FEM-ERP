<?php

namespace App\Http\Controllers;

final class InvoiceController extends Controller
{
    public function index()
    {
        return view('invoices.index');
    }
}
