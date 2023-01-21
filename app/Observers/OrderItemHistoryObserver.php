<?php

namespace App\Observers;

use App\Format;
use App\Models\OrderItem;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;

class OrderItemHistoryObserver
{
    public function created(OrderItem $orderItem)
    {
        $orderItem->order->comments()->create([
            'author_id' => Auth::id(),
            'comment' => __('Добавлена продукция :name', [
                'name' => $orderItem->item->name
            ])
        ]);

        $this->checkWarehouseSkipped($orderItem);
    }

    public function updated(OrderItem $orderItem)
    {
        $orderItem->order->comments()->create([
            'author_id' => Auth::id(),
            'comment' => __('Изменена продукция :name', [
                'name' => $orderItem->item->name
            ])
        ]);

        //TODO проверить чтоб не удалялись счета для услуг
        if ($orderItem->wasChanged('warehouse_skipped')
            || $orderItem->wasChanged('purchase_price')
            || $orderItem->wasChanged('quantity')
        ) {
            $orderItem->payments()->delete();

            $this->checkWarehouseSkipped($orderItem);
        }
    }

    public function deleted(OrderItem $orderItem)
    {
        $orderItem->order->comments()->create([
            'author_id' => Auth::id(),
            'comment' => __('Удалена продукция :name', [
                'name' => $orderItem->item->name
            ])
        ]);

        $orderItem->payments()->delete();
    }

    public function restored(OrderItem $orderItem)
    {
        //
    }

    public function forceDeleted(OrderItem $orderItem)
    {
        //
    }

    protected function checkWarehouseSkipped(OrderItem $orderItem): void
    {
        if ($orderItem->warehouse_skipped) {
            $consumption = $orderItem->quantity * $orderItem->purchase_price;

            $orderItem->payments()->create([
                'amount' => -$consumption,
                'payment_type' => $orderItem->order->payment_type,
                'currency' => 'UAH',
                'status' => Payment::STATUS_CREATED
            ]);
        }
    }
}
