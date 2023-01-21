<?php

namespace App\Observers;

use App\Format;
use App\Models\Customer;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class OrderHistoryObserver
{
    public function created(Order $order)
    {
        //
    }

    public function updated(Order $order)
    {
        if ($order->wasChanged('status')) {
            $order->comments()->create([
                'author_id' => Auth::id(),
                'status' => Order::STATUS_CREATED,
                'comment' => __('Изменен статус с :old на :new', [
                    'old' => Format::asEnum($order->getOriginal('status'), Order::statusOptions()),
                    'new' => Format::asEnum($order->status, Order::statusOptions())
                ])
            ]);
        }

        if ($order->wasChanged('customer_id') && $customer = Customer::query()->find($order->customer_id)) {
            $order->comments()->create([
                'author_id' => Auth::id(),
                'comment' => __('Изменен контрагент на :name', [
                    'name' => $customer->name
                ]),
            ]);
        }

        if ($order->wasChanged('tax')) {
            $order->comments()->create([
                'author_id' => Auth::id(),
                'comment' => __('Изменен налог с :old на :new', [
                    'old' => Order::taxLabel($order->getOriginal('tax')),
                    'new' => Order::taxLabel($order->tax)
                ])
            ]);
        }

        if ($order->wasChanged('total_amount')) {
            $order->comments()->create([
                'author_id' => Auth::id(),
                'comment' => __('Сумма заказа изменена с :old на :new', [
                    'old' => Format::asCurrency($order->getOriginal('total_amount')),
                    'new' => Format::asCurrency($order->total_amount)
                ])
            ]);
        }

        if ($order->wasChanged('paid_amount')) {
            $order->comments()->create([
                'author_id' => Auth::id(),
                'comment' => __('Общая оплаченная сумма изменена с :old на :new', [
                    'old' => Format::asCurrency($order->getOriginal('paid_amount')),
                    'new' => Format::asCurrency($order->paid_amount)
                ])
            ]);
        }

        if ($order->wasChanged('discount_amount')) {
            $order->comments()->create([
                'author_id' => Auth::id(),
                'comment' => __('Сумма скидки изменена с :old на :new', [
                    'old' => Format::asCurrency($order->getOriginal('discount_amount')),
                    'new' => Format::asCurrency($order->discount_amount)
                ])
            ]);
        }
    }

    public function deleted(Order $order)
    {
        //
    }

    public function restored(Order $order)
    {
        //
    }

    public function forceDeleted(Order $order)
    {
        //
    }
}
