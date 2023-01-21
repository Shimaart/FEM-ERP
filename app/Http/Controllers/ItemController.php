<?php

namespace App\Http\Controllers;

use App\Models\Item;

final class ItemController extends Controller
{
    public function index()
    {
        return view('items.index');
    }

    public function create()
    {
        return view('items.create');
    }

    public function edit(Item $item)
    {
        //при изменении выбираем товары с одинаковыми ключевыми атрибутами
        return view('items.edit', compact('item'));
    }
}
