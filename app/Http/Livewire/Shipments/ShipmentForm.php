<?php

namespace App\Http\Livewire\Shipments;

use App\Models\Order;
use App\Models\Shipment;
use App\Models\ShipmentItem;
use App\Models\Transport;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Validation\Rule;
use Livewire\Component;

class ShipmentForm extends Component
{
    public bool $canUpdateOrder = true;

    public Shipment $shipment;
    public Collection $shipmentItems;

    public function mount(Shipment $shipment): void
    {
        $this->shipment = $shipment;

        $this->shipmentItems = $shipment->shipmentItems;
    }

    public function rules(): array
    {
        return [
            'shipment.order_id' => [Rule::requiredIf(fn () => $this->canUpdateOrder), 'exists:orders,id'],
            'shipment.type' => ['required', Rule::in(array_keys($this->types))],
            'shipment.transport_id' => [
                Rule::requiredIf(fn () => $this->shipment->type === Shipment::TYPE_DELIVERY),
                'exists:transports,id'
            ],
            'shipment.address' => ['nullable', 'string'],
            'shipment.desired_date' => ['nullable', 'date:Y-m-d'],
            'shipment.distance' => ['nullable', 'numeric'],
            'shipment.kilometer_price' => ['nullable', 'numeric', 'min:0'],
            'shipment.amount' => ['numeric', 'min:0'],

            'shipmentItems.*.quantity' => ['numeric', 'min:0'], // TODO max
        ];
    }

    public function updatedShipment($_, $key): void
    {
        $key = (string)$key;

        if ($key === 'order_id' && $order = Order::query()->find($this->shipment->order_id)) {
            $this->shipment->order()->associate($order);
        }

        if ($key === 'kilometer_price' || $key = 'distance') {
            $this->shipment->amount = $this->shipment->kilometer_price * $this->shipment->distance;
        }
    }

    public function submit(): void
    {
        $this->validate();

        $this->shipment->save();

        $this->shipment->shipmentItems()->saveMany($this->shipmentItems);

        $this->emit('saved');
        $this->emit('payableUpdated');
    }

    public function sendShipment(): void
    {
        $this->shipment->update([
            'status' => Shipment::STATUS_SHIPPED
        ]);

        foreach ($this->shipment->shipmentItems as $item) {
            $item->orderItem->item->update([
                'quantity' => $item->orderItem->item->quantity - $item->quantity
            ]);
        }
    }

    public function deliveredShipment(): void
    {
        $this->shipment->update([
            'status' => Shipment::STATUS_DELIVERED
        ]);
    }

    public function getTypesProperty(): array
    {
        return Shipment::typeOptions();
    }

    public function getOrdersProperty()
    {
        return Order::query()->latest()->get();
    }

    public function getTransportsProperty()
    {
        return Transport::all();
    }

    public function render()
    {
        return view('livewire.shipments.shipment-form', [
            'orderItems' => $this->shipment->order ?  $this->shipment->order->orderItems : collect(),
            'totalWeight' => $this->shipmentItems->reduce(function (float $total, ShipmentItem $shipmentItem) {
                return $total + ($shipmentItem->orderItem->item->weight * $shipmentItem->quantity);
            }, 0),
        ]);
    }
}
