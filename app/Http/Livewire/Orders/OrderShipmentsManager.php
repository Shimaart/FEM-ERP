<?php

namespace App\Http\Livewire\Orders;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Shipment;
use App\Models\Transport;
use Illuminate\Validation\Rule;
use Livewire\Component;

class OrderShipmentsManager extends Component
{
    public Order $order;

    public bool $managingShipment = false;
    public ?Shipment $shipment = null;

    public array $quantities = [];

    protected $listeners = [
        'manageShipment'
    ];

    public function rules(): array
    {
        return [
            'shipment.type' => ['required', Rule::in(Shipment::types())],
            'shipment.transport_id' => [
                Rule::requiredIf(fn () => $this->shipment && $this->shipment->type === Shipment::TYPE_DELIVERY),
                'exists:transports,id'
            ],
            'shipment.address' => ['nullable', 'string'],
            'shipment.desired_date' => ['nullable', 'date:Y-m-d'],
            'shipment.distance' => ['nullable', 'numeric'],
            'shipment.kilometer_price' => ['nullable', 'numeric', 'min:0'],
            'shipment.amount' => ['numeric', 'min:0'],
            'shipment.profit_percent' => ['nullable', 'numeric', 'min:0'],
            'shipment.paid_by_order' => ['required', 'boolean'],

            'quantities.*' => ['numeric', 'min:0'], // TODO max
        ];
    }

    public function manageShipment(Shipment $shipment): void
    {
        $this->clearValidation();

        $shipment->order()->associate($this->order);

        $this->shipment = $shipment;

        $this->quantities = $this->order->orderItems->mapWithKeys(function (OrderItem $orderItem) {
            if ($exists = $this->shipment->shipmentItems->firstWhere('item_id', '=', $orderItem->id)) {
                return [$orderItem->id => $exists->quantity];
            }

            return [$orderItem->id => 0];
        })->toArray();

        $this->managingShipment = true;
    }

    public function setDefaultProfitPercent()
    {
        if ($this->shipment->type !== Shipment::TYPE_DELIVERY) {
            $this->shipment->profit_percent = 10;
        }
    }

    public function getTotalWeightProperty(): float
    {
        return $this->order->orderItems->reduce(function ($total, OrderItem $orderItem) {
            if (! isset($this->quantities[$orderItem->id]) || $this->quantities[$orderItem->id] === '') {
                return $total;
            }
            return ($this->quantities[$orderItem->id] * $orderItem->item->weight) + $total;
        }, 0);
    }

    public function saveShipment(): void
    {
        if (!$this->shipment) {
            return;
        }

        $this->validate();

        $kilometer_price = (!$this->shipment->kilometer_price || $this->shipment->kilometer_price === '') ? 0 : $this->shipment->kilometer_price;
        $distance = (!$this->shipment->distance || $this->shipment->distance === '') ? 0 : $this->shipment->distance;

        $this->shipment->forceFill([
            'amount' =>  $kilometer_price * $distance
        ]);

        $this->order->shipments()->save($this->shipment);

        $this->shipment->shipmentItems()->saveMany(
            collect($this->quantities)->map(function ($quantity, $orderItemId) {
                $quantity = $quantity ? $quantity : 0;
                if ($shipmentItem = $this->shipment->shipmentItems->firstWhere('item_id', '=', $orderItemId)) {
                    $shipmentItem->forceFill([
                        'quantity' => $quantity
                    ]);
                } else {
                    $shipmentItem = $this->shipment->shipmentItems()->make([
                        'item_id' => $orderItemId,
                        'quantity' => $quantity
                    ]);
                }

                return $shipmentItem;
            })
        );

        $this->emit('shipmentSaved');

        $this->managingShipment = false;
        $this->shipment = null;
    }

    public function updatedShipmentTransportId($transportId): void
    {
        if ($transport = Transport::query()->find($transportId)) {
            $this->shipment->transport()->associate($transport);

            // set transport default kilometer price
            if (!$this->shipment->kilometer_price) {
                $this->shipment->kilometer_price = $transport->kilometer_price;
            }
        }
    }

    public function getTransportsProperty()
    {
        return Transport::all();
    }
}
