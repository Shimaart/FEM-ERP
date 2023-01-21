<?php

namespace App\Http\Controllers;

final class RefundController extends Controller
{
    public function index()
    {
        return view('refunds.index');
    }
}
