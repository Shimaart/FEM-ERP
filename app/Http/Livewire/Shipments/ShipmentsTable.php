<?php

namespace App\Http\Livewire\Shipments;

use App\Models\Shipment;
use Karvaka\Wired\Table\Actions\Delete;
use Karvaka\Wired\Table\Columns\Column;
use Karvaka\Wired\Table\Columns\Date;
use Karvaka\Wired\Table\Columns\Enum;
use Karvaka\Wired\Table\Columns\Number;
use Karvaka\Wired\Table\Components\Table;
use Karvaka\Wired\Table\Filters\DateFilter;
use Karvaka\Wired\Table\Links\Edit;
use Karvaka\Wired\Table\Tabs\Tab;

class ShipmentsTable extends Table
{
    protected string $defaultSort = '-desired_date';

    public function columns(): array
    {
        return [
            Date::make('desired_date', __('Дата'))->sortable(),
            Column::make('order_id', __('Заказ'))->sortable(),
            Enum::make('type', __('Тип'))->values(Shipment::typeOptions())->sortable(),
            // TODO Продукция
            Column::make('address', __('Адрес'))->sortable()->searchable(),
            Number::make('amount', __('Стоимость'))->sortable(),
        ];
    }

    public function tabs(): array
    {
        return collect(Shipment::statusOptions())
            ->map(function ($label, $status) {
                return Tab::make($status, $label)->filterUsing(fn ($query) => $query->byStatus($status));
            })->toArray();
    }

    public function filters(): array
    {
        return [
            DateFilter::make('desired_date', __('Дата доставки'))
        ];
    }

    public function links(): array
    {
        return [
            (new Edit)->to(fn (Shipment $model) => route('shipments.edit', ['shipment' => $model->id])),
        ];
    }

//    public function actions(): array
//    {
//        return [
//            new Delete
//        ];
//    }
}
