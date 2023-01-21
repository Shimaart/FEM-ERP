<?php

namespace App\Http\Livewire\Units;

use App\Models\Unit;
use Karvaka\Wired\Table\Links\Edit;
use Karvaka\Wired\Table\Actions\Delete;
use Karvaka\Wired\Table\Columns\Column;
use Karvaka\Wired\Table\Components\Table;

class UnitsTable extends Table
{
    public function columns(): array
    {
        return [
            Column::make('label', __('Название'))->sortable()->searchable(),
            Column::make('symbol', __('Символ'))->sortable(),
        ];
    }

    public function links(): array
    {
        return [
            (new Edit)->to(fn (Unit $model) => route('units.edit', ['unit' => $model->id])),
        ];
    }

    public function actions(): array
    {
        return [
            new Delete
        ];
    }
}
