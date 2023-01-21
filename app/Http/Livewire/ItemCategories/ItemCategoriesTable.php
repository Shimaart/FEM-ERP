<?php

namespace App\Http\Livewire\ItemCategories;

use Karvaka\Wired\Table\Actions\Delete;
use Karvaka\Wired\Table\Columns\Column;
use Karvaka\Wired\Table\Components\Table;
use Karvaka\Wired\Table\Links\Edit;

class ItemCategoriesTable extends Table
{
    public function columns(): array
    {
        return [
            Column::make('name')->sortable()
        ];
    }

    public function links(): array
    {
        return [
            (new Edit)->to(fn ($model) => route('item-categories.edit', ['item_category' => $model->id]))
        ];
    }

    public function actions(): array
    {
        return [
            new Delete
        ];
    }
}
