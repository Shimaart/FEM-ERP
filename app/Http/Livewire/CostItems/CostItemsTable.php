<?php

namespace App\Http\Livewire\CostItems;

use Karvaka\Wired\Table\Actions\Delete;
use Karvaka\Wired\Table\Columns\Column;
use Karvaka\Wired\Table\Components\Table;
use Karvaka\Wired\Table\Links\Show;

class CostItemsTable extends Table
{
    public string $defaultSort = 'name';

    public function columns(): array
    {
        return [
            Column::make('name', __('Название'))->sortable()
        ];
    }

    public function tabs(): array
    {
        return [];
    }

    public function filters(): array
    {
        return [];
    }

    public function links(): array
    {
        return [
            (new Show)->to(fn ($model) => route('cost-items.show', ['cost_item' => $model->id]))
        ];
    }

    public function actions(): array
    {
        return [
            new Delete
        ];
    }
}
