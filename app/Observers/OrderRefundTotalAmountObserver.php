<?php

namespace App\Observers;

use App\Models\Refund;

class OrderRefundTotalAmountObserver
{
    public function created(Refund $refund)
    {
        $refund->order->refreshTotalAmount()->save();
    }

    public function updated(Refund $refund)
    {
        $refund->order->refreshTotalAmount()->save();
    }

    public function deleted(Refund $refund)
    {
        $refund->order->refreshTotalAmount()->save();
    }

    public function restored(Refund $refund)
    {
        //
    }

    public function forceDeleted(Refund $refund)
    {
        //
    }
}
