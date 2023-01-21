<?php

namespace App\Http\Livewire\Orders;

use App\Models\Order;
use Illuminate\Database\Eloquent\Builder;
use Karvaka\Wired\Table\Actions\Delete;
use Karvaka\Wired\Table\Columns\Column;
use Karvaka\Wired\Table\Columns\DateTime;
use Karvaka\Wired\Table\Columns\Number;
use Karvaka\Wired\Table\Components\Table;
use Karvaka\Wired\Table\Links\Edit;

class OrderRefundsTable extends Table
{
    public Order $order;

    public bool $enablePagination = false;
    public ?string $noResultsText = 'Возвратов еще небыло.';

    protected $listeners = ['refundSaved' => '$refresh'];

    public function query(): Builder
    {
        return $this->order->refunds()->getQuery()->latest();
    }

    public function columns(): array
    {
        return [
            DateTime::make('created_at', __('Дата')),
            Column::make('item_id', __('Продукция'))->component('wired-table.columns.order-refund-items'),
            Number::make('amount', __('Сумма')),
        ];
    }

    public function links(): array
    {
        return [
//            (new Edit)->emit('manageRefund')->preventDefault()
        ];
    }

    public function actions(): array
    {
        return [
//            (new Delete)->after(fn ($model) => $this->emit('refundDeleted', $model))
        ];
    }
}
