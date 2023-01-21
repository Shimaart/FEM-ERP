<?php

namespace App\Http\Livewire\Transports;

use Karvaka\Wired\Table\Actions\Delete;
use Karvaka\Wired\Table\Columns\Column;
use Karvaka\Wired\Table\Columns\Number;
use Karvaka\Wired\Table\Components\Table;
use Karvaka\Wired\Table\Links\Edit;

class TransportsTable extends Table
{
    public function columns(): array
    {
        return [
            Column::make('name', __('Название'))->sortable()->searchable(),
            Number::make('kilometer_price', __('Стоимость грн/км'))->sortable()->searchable(),
        ];
    }

    public function links(): array
    {
        return [
            (new Edit)->to(fn ($model) => route('transports.edit', ['transport' => $model->id]))
        ];
    }

    public function actions(): array
    {
        return [
            new Delete
        ];
    }
}
