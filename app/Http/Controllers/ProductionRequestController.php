<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Database\Eloquent\Builder;

class ProductionRequestController extends Controller
{
    public function index()
    {
        return view('production-requests.index');
    }
}
