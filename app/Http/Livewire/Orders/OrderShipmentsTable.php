<?php

namespace App\Http\Livewire\Orders;

use App\Models\Order;
use App\Models\Shipment;
use Illuminate\Database\Eloquent\Builder;
use Karvaka\Wired\Table\Actions\Delete;
use Karvaka\Wired\Table\Columns\Column;
use Karvaka\Wired\Table\Columns\Date;
use Karvaka\Wired\Table\Columns\Enum;
use Karvaka\Wired\Table\Columns\Number;
use Karvaka\Wired\Table\Components\Table;
use Karvaka\Wired\Table\Links\Edit;

class OrderShipmentsTable extends Table
{
    public Order $order;

    protected $listeners = ['shipmentSaved' => '$refresh'];

    public bool $enablePagination = false;
    public ?string $noResultsText = 'Заказ не содержит отгрузок.';

    public function query(): Builder
    {
        return $this->order->shipments()->getQuery();
    }

    public function columns(): array
    {
        return [
            Date::make('desired_date', __('Дата')),
            Enum::make('type', __('Тип'))->values(Shipment::typeOptions()),
            Column::make('items', __('Продукция'))->component('wired-table.columns.shipment-items'),
            Column::make('address', __('Адрес')),
            Number::make('amount', __('Стоимость')),
//            Column::make('amount', __('Оплачено'))
//                ->format(function (Shipment $shipment) {
//                    return $shipment->paid_by_order ? __('Входит в стоимость заказа') : Format::asCurrency($shipment->getPaidSum());
//                })
//                ->withHeaderAttributes(['class' => 'text-right'])->withCellAttributes(['class' => 'text-right']),
        ];
    }

    public function links(): array
    {
        return [
            (new Edit)->emit('manageShipment')->preventDefault()
        ];
    }

    public function actions(): array
    {
        return [
            (new Delete)->canSee(function ($model) {
                return $model->status === Shipment::STATUS_CREATED;
            })->after(fn ($model) => $this->emit('shipmentDeleted', $model))
        ];
    }
}
