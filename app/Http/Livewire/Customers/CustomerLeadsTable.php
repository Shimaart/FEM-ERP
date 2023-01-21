<?php

namespace App\Http\Livewire\Customers;

use App\Models\Customer;
use App\Models\Lead;
use Illuminate\Database\Eloquent\Builder;
use Karvaka\Wired\Table\Actions\Delete;
use Karvaka\Wired\Table\Columns\Column;
use Karvaka\Wired\Table\Columns\DateTime;
use Karvaka\Wired\Table\Columns\Enum;
use Karvaka\Wired\Table\Components\Table;
use Karvaka\Wired\Table\Links\Show;

class CustomerLeadsTable extends Table
{
    public Customer $customer;

    public string $defaultSort = '-created_at';

    public function query(): Builder
    {
        return $this->customer->leads()->getQuery();
    }

    public function columns(): array
    {
        return [
            Column::make('id')->sortable(),
            Column::make('manager.name', __('Менеджер')),
            Enum::make('status')->sortable()->values(Lead::statusOptions()),
            DateTime::make('created_at')->sortable()
        ];
    }

    public function links(): array
    {
        return [
            (new Show)->to(fn ($model) => route('leads.show', ['lead' => $model->id]))
        ];
    }

    public function actions(): array
    {
        return [
            new Delete
        ];
    }
}
