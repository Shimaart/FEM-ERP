<?php

namespace App\Http\Controllers;

use App\Models\Production;
use Illuminate\Support\Facades\Auth;

final class ProductionController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Production::class);
    }

    public function index()
    {
        return view('productions.index');
    }

    public function create()
    {
        $production = Production::query()->firstOrCreate([
            'status' => Production::STATUS_DRAFTED,
            'creator_id' => Auth::id()
        ]);

//        return redirect()->route('productions.edit', ['production' => $production->id]);
        return view('productions.create', compact('production'));
    }

    public function show(Production $production)
    {
        return view('productions.show', compact('production'));
    }

    public function edit(Production $production)
    {
        return view('productions.edit', compact('production'));
    }
}
