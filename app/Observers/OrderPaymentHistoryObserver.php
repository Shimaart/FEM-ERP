<?php

namespace App\Observers;

use App\Format;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;

class OrderPaymentHistoryObserver
{
    public function created(Payment $payment)
    {
        if (!($payment->paymentable instanceof Order)) {
            return;
        }

        $payment->paymentable->comments()->create([
            'author_id' => Auth::id(),
            'comment' => __('Добавлен платеж №:number на сумму :amount', [
                'number' => $payment->number,
                'amount' => Format::asCurrency($payment->amount)
            ])
        ]);
    }

    public function updated(Payment $payment)
    {
        // TODO
    }

    public function deleted(Payment $payment)
    {
        if (!($payment->paymentable instanceof Order)) {
            return;
        }

        $payment->paymentable->comments()->create([
            'author_id' => Auth::id(),
            'comment' => __('Удален платеж №:number на сумму :amount', [
                'number' => $payment->number,
                'amount' => Format::asCurrency($payment->amount)
            ])
        ]);
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
