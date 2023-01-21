<?php

namespace App\Observers;

use App\Models\Lead;
use App\Models\Order;

class LeadOrderChangesObserver
{
    public function updated(Order $order)
    {
        if ($order->wasChanged('paid_amount') && $order->paid_amount === $order->total_amount) {
            $order->makeConsumptions();
        }

        if (is_null($order->lead)) {
            return;
        }

        if ($order->wasChanged('status')) {
            if ($order->status === Order::STATUS_CANCELED) {
                $order->lead->update([
                    'status' => Lead::STATUS_DECLINED
                ]);
            } else if ($order->status === Order::STATUS_CLOSED) {
                $order->lead->update([
                    'status' => Lead::STATUS_SUCCESS
                ]);
            }
        }
    }
}
