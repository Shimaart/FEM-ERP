<?php

namespace App\Http\Controllers;

use App\Models\AttributeGroup;

final class AttributeGroupController extends Controller
{
    public function index()
    {
        return view('attribute-groups.index');
    }

    public function create()
    {
        return view('attribute-groups.create');
    }

    public function edit(AttributeGroup $attributeGroup)
    {
        return view('attribute-groups.edit', compact('attributeGroup'));
    }
}
