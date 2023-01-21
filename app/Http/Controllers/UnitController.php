<?php

namespace App\Http\Controllers;

use App\Models\Unit;

final class UnitController extends Controller
{
    public function index()
    {
        return view('units.index');
    }

    public function create()
    {
        return view('units.create');
    }

    public function edit(Unit $unit)
    {
        return view('units.edit', compact('unit'));
    }
}
