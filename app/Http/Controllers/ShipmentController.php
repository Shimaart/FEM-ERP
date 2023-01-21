<?php

namespace App\Http\Controllers;

use App\Models\Shipment;

final class ShipmentController extends Controller
{
    public function index()
    {
        return view('shipments.index');
    }

    public function create()
    {
        return view('shipments.create');
    }

    public function edit(Shipment $shipment)
    {
        return view('shipments.edit', compact('shipment'));
    }
}
