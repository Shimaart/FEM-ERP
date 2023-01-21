<?php

namespace App\Observers;

use App\Models\OrderItem;

class OrderItemTotalAmountObserver
{
    public function created(OrderItem $orderItem)
    {
        $orderItem->order->refreshTotalAmount()->save();
    }

    public function updated(OrderItem $orderItem)
    {
        $orderItem->order->refreshTotalAmount()->save();
    }

    public function deleted(OrderItem $orderItem)
    {
        $orderItem->order->refreshTotalAmount()->save();
    }

    public function restored(OrderItem $orderItem)
    {
        //
    }

    public function forceDeleted(OrderItem $orderItem)
    {
        //
    }
}
