<?php

namespace App\Http\Livewire\Orders;

use App\Models\Order;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Gate;
use Karvaka\Wired\Table\Actions\Delete;
use Karvaka\Wired\Table\Columns\Column;
use Karvaka\Wired\Table\Columns\DateTime;
use Karvaka\Wired\Table\Components\Table;
use Karvaka\Wired\Table\Links\Edit;

class OrderCommentsTable extends Table
{
    public Order $order;

    public ?string $noResultsText = 'Список действий пуст.';

    protected $listeners = [
        'orderSaved' => '$refresh',
        'orderItemSaved' => '$refresh',
        'orderItemDeleted' => '$refresh',
        'shipmentSaved' => '$refresh',
        'shipmentDeleted' => '$refresh',
        'paymentSaved' => '$refresh',
        'paymentDeleted' => '$refresh',
        'commentUpdated' => '$refresh',
        'commentDeleted' => '$refresh',
        'refundSaved' => '$refresh',
        'refundDeleted' => '$refresh',
        'commentSaved' => '$refresh'
    ];

    public bool $enablePagination = false;

    public function query(): Builder
    {
        return $this->order->comments()->getQuery()->latest();
    }

    public function columns(): array
    {
        return [
            DateTime::make('created_at', __('Дата')),
            Column::make('author.name', __('Пользователь')),
            Column::make('comment', __('Действие')),
        ];
    }

    public function links(): array
    {
        return [
            (new Edit)
                ->emit('manageComment')
                ->preventDefault()
                ->canSee(fn ($model) => Gate::allows('update', $model))
        ];
    }

    public function actions(): array
    {
        return [
            (new Delete)
                ->canSee(fn ($model) => Gate::allows('delete', $model))
                ->after(fn ($model) => $this->emit('commentDeleted', $model))
        ];
    }
}
