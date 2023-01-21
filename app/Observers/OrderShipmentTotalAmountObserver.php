<?php

namespace App\Observers;

use App\Models\Order;
use App\Models\Shipment;

class OrderShipmentTotalAmountObserver
{
    public function created(Shipment $shipment)
    {
        if ($shipment->order instanceof Order) {
            $shipment->order->refreshTotalAmount()->save();
        }
    }

    public function updated(Shipment $shipment)
    {
        if ($shipment->order instanceof Order) {
            $shipment->order->refreshTotalAmount()->save();
        }
    }

    public function deleted(Shipment $shipment)
    {
        if ($shipment->order instanceof Order) {
            $shipment->order->refreshTotalAmount()->save();
        }
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
