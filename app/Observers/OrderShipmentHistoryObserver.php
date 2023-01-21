<?php

namespace App\Observers;

use App\Models\Order;
use App\Models\Shipment;
use Illuminate\Support\Facades\Auth;

class OrderShipmentHistoryObserver
{
    public function created(Shipment $shipment)
    {
        if (! $shipment->order instanceof Order) {
            return;
        }

        $shipment->order->comments()->create([
            'author_id' => Auth::id(),
            'comment' => __('Добавлена задача на отгрузку №:number', [
                'number' => $shipment->number
            ])
        ]);
    }

    public function updated(Shipment $shipment)
    {
        if (! $shipment->order instanceof Order) {
            return;
        }

        $shipment->order->comments()->create([
            'author_id' => Auth::id(),
            'comment' => __('Изменена задача на отгрузку №:number', [
                'number' => $shipment->number
            ])
        ]);

        // TODO
    }

    public function deleted(Shipment $shipment)
    {
        if (! $shipment->order instanceof Order) {
            return;
        }

        $shipment->order->comments()->create([
            'author_id' => Auth::id(),
            'comment' => __('Удалена задача на отгрузку №:number', [
                'number' => $shipment->number
            ])
        ]);
    }

    public function restored(Shipment $shipment)
    {
        //
    }

    public function forceDeleted(Shipment $shipment)
    {
        //
    }
}
