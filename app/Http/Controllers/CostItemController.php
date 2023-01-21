<?php

namespace App\Http\Controllers;

use App\Models\CostItem;

final class CostItemController extends Controller
{
    public function index()
    {
        return view('cost-items.index');
    }

    public function create()
    {
        return view('cost-items.create');
    }

    public function show(CostItem $costItem)
    {
        return view('cost-items.show', compact('costItem'));
    }
}
