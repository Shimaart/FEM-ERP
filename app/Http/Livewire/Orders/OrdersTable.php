<?php

namespace App\Http\Livewire\Orders;

use App\Models\Customer;
use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Karvaka\Wired\Table\Actions\Delete;
use Karvaka\Wired\Table\Columns\Column;
use Karvaka\Wired\Table\Columns\DateTime;
use Karvaka\Wired\Table\Columns\Number;
use Karvaka\Wired\Table\Components\Table;
use Karvaka\Wired\Table\Filters\SelectFilter;
use Karvaka\Wired\Table\Links\Show;
use Karvaka\Wired\Table\Tabs\Tab;

class OrdersTable extends Table
{
    protected string $defaultSort = '-id';

    public function columns(): array
    {
        return [
            Column::make('id', __('Номер'))->sortable(),
            DateTime::make('created_at', __('Дата создания'))->sortable(),
            Column::make('customer.name', __('Покупатель'))->searchable(),
            Number::make('total_amount', __('Сумма'))->sortable(),
            Number::make('paid_amount', __('Оплачено'))->sortable(),
        ];
    }

    public function tabs(): array
    {
        return collect(Order::statusOptions())
            ->except(Order::STATUS_DRAFTED)
            ->map(function ($label, $status) {
                return Tab::make($status, $label)->filterUsing(fn (Builder $query) => $query->byStatus($status));
            })->toArray();
    }

    public function filters(): array
    {
        return [
            SelectFilter::make('manager_id', __('Менеджер'))
                ->options(User::query()->pluck('name', 'id')->toArray()),
            SelectFilter::make('customer_id', __('Покупатель'))
                ->options(Customer::query()->pluck('name', 'id')->toArray()),
        ];
    }

    public function links(): array
    {
        return [
            (new Show)->to(fn ($model) => route('orders.show', ['order' => $model->id]))
        ];
    }

    public function actions(): array
    {
        return [
            new Delete
        ];
    }
}
