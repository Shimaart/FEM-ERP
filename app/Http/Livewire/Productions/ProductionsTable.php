<?php

namespace App\Http\Livewire\Productions;

use App\Models\Production;
use Illuminate\Database\Eloquent\Builder;
use Karvaka\Wired\Table\Actions\Delete;
use Karvaka\Wired\Table\Columns\Column;
use Karvaka\Wired\Table\Columns\Date;
use Karvaka\Wired\Table\Columns\Enum;
use Karvaka\Wired\Table\Components\Table;
use Karvaka\Wired\Table\Links\Edit;

class ProductionsTable extends Table
{
    public string $defaultSort = '-date';

    public function columns(): array
    {
        return [
            Column::make('id', __('Номер'))
                ->sortable(),
            Column::make('creator.name', __('Менеджер')),
            Column::make('productionItems', __('Необходимо произвести'))->component('wired-table.columns.production-items'),
            Date::make('date', __('Дата'))
                ->sortable(),
            Enum::make('status', __('Статус'))
                ->values(Production::statusOptions())
                ->sortable(),
        ];
    }

    public function links(): array
    {
        return [
            (new Edit)->to(fn ($model) => route('productions.edit', ['production' => $model->id]))
        ];
    }

    public function actions(): array
    {
        return [
            new Delete
        ];
    }
}
