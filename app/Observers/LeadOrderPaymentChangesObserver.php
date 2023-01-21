<?php

namespace App\Observers;

use App\Models\Lead;
use App\Models\Order;
use App\Models\Payment;

class LeadOrderPaymentChangesObserver
{
    public function created(Payment $payment): void
    {
        $order = $payment->paymentable;

        if (! $order instanceof Order || is_null($order->lead)) {
            return;
        }

        if ($payment->amount < $order->total_amount) {
            $order->lead->forceFill([
                'status' => Lead::STATUS_PREPAY
            ])->save();
        }
    }
}
