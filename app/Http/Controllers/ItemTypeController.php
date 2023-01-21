<?php

namespace App\Http\Controllers;

use App\Models\ItemType;

final class ItemTypeController extends Controller
{
    public function index()
    {
        return view('item-types.index');
    }

    public function create()
    {
        return view('item-types.create');
    }

    public function edit(ItemType $itemType)
    {
        return view('item-types.edit', compact('itemType'));
    }
}
