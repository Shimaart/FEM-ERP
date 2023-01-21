<?php

namespace App\Http\Livewire\Orders;

use App\Models\Order;
use App\Models\ItemCategory;
use Illuminate\Database\Eloquent\Builder;
use Karvaka\Wired\Table\Actions\Delete;
use Karvaka\Wired\Table\Columns\Column;
use Karvaka\Wired\Table\Columns\Number;
use Karvaka\Wired\Table\Components\Table;
use Karvaka\Wired\Table\Links\Edit;

class OrderItemsTable extends Table
{
    public Order $order;
    public ?ItemCategory $category = null;

    public ?string $noResultsText = 'Заказ не содержит продукции.';

    protected $listeners = [
        'orderSaved' => '$refresh',
        'orderItemSaved' => '$refresh',
    ];

    public bool $enablePagination = false;

    public function query(): Builder
    {
        return $this->category ?
            $this->order->orderItems()->whereHas('item', function ($query) {
                $query->where('category_id', $this->category->id);
            })->getQuery() :
            $this->order->orderItems()->getQuery();
    }

    public function columns(): array
    {
        return [
            Column::make('item.name', __('Наименование')),
            Column::make('quantity', __('Количество'))->component('wired-table.columns.order-item-quantity'),
            Number::make('price', __('Цена за единицу')),
            Number::make('discount', __('Скидка')),
            Number::make('total_amount_without_tax', __('Сумма без налога')),
            Number::make('total_amount', __('Сумма')),
        ];
    }

    public function links(): array
    {
        return [
            (new Edit)->emit('manageOrderItem')->preventDefault()
        ];
    }

    public function actions(): array
    {
        return [
            (new Delete)->after(fn ($model) => $this->emit('orderItemDeleted', $model))
        ];
    }
}
