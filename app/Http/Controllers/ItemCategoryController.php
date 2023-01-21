<?php

namespace App\Http\Controllers;

use App\Models\ItemCategory;

final class ItemCategoryController extends Controller
{
    public function index()
    {
        return view('item-categories.index');
    }

    public function create()
    {
        return view('item-categories.create');
    }

    public function edit(ItemCategory $itemCategory)
    {
        return view('item-categories.edit', compact('itemCategory'));
    }
}
