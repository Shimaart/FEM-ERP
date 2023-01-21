<?php

namespace App\Http\Livewire\ItemTypes;

use Karvaka\Wired\Table\Actions\Delete;
use Karvaka\Wired\Table\Columns\Column;
use Karvaka\Wired\Table\Components\Table;
use Karvaka\Wired\Table\Links\Edit;

class ItemTypesTable extends Table
{
    public function columns(): array
    {
        return [
            Column::make('name')->sortable()->searchable()
        ];
    }

    public function links(): array
    {
        return [
            (new Edit)->to(fn ($model) => route('item-types.edit', ['item_type' => $model->id]))
        ];
    }

    public function actions(): array
    {
        return [
            Delete::make(),
        ];
    }
}
