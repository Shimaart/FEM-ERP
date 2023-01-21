<?php

namespace App\Http\Controllers;

use App\Models\Transport;

final class TransportController extends Controller
{
    public function index()
    {
        return view('transports.index');
    }

    public function create()
    {
        return view('transports.create');
    }

    public function edit(Transport $transport)
    {
        return view('transports.edit', compact('transport'));
    }
}
