<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;

final class OrderController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Order::class);
    }

    public function index()
    {
        return view('orders.index');
    }

    public function create()
    {
        $order = Order::query()->firstOrCreate([
            'status' => Order::STATUS_DRAFTED,
            'manager_id' => Auth::id()
        ]);

        return redirect()->route('orders.show', ['order' => $order->id]);
    }

    public function show(Order $order)
    {
        return view('orders.show', compact('order'));
    }
}
