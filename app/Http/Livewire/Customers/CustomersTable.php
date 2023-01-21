<?php

namespace App\Http\Livewire\Customers;

use Karvaka\Wired\Table\Actions\Delete;
use Karvaka\Wired\Table\Columns\Column;
use Karvaka\Wired\Table\Components\Table;
use Karvaka\Wired\Table\Links\Show;

class CustomersTable extends Table
{
    public function columns(): array
    {
        return [
            Column::make('name')->searchable()->sortable()
        ];
    }

    public function links(): array
    {
        return [
            (new Show)->to(fn ($model) => route('customers.show', ['customer' => $model->id]))
        ];
    }

    public function actions(): array
    {
        return [
            new Delete
        ];
    }
}
