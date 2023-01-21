<?php

namespace App\Observers;

use App\Models\Order;
use App\Models\Payment;

class OrderPaymentPaidAmountObserver
{
    public function created(Payment $payment)
    {
        if ($payment->paymentable instanceof Order) {
            $payment->paymentable->refreshPaidAmount()->save();
        }
    }

    public function updated(Payment $payment)
    {
        if ($payment->paymentable instanceof Order) {
            $payment->paymentable->refreshPaidAmount()->save();
        }
    }

    public function deleted(Payment $payment)
    {
        if ($payment->paymentable instanceof Order) {
            $payment->paymentable->refreshPaidAmount()->save();
        }
    }

    public function restored(Payment $payment)
    {
        //
    }

    public function forceDeleted(Payment $payment)
    {
        //
    }
}
