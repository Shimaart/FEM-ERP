<?php

namespace App\Http\Livewire\ItemTypes;

use App\Models\ItemType;
use Illuminate\Database\Eloquent\Builder;
use Karvaka\Wired\Table\Actions\Delete;
use Karvaka\Wired\Table\Columns\Boolean;
use Karvaka\Wired\Table\Columns\Column;
use Karvaka\Wired\Table\Components\Table;
use Karvaka\Wired\Table\Links\Edit;

class ItemTypeGroupsTable extends Table
{
    public ItemType $itemType;

    protected $listeners = [
        'itemTypeGroupsUpdated' => '$refresh'
    ];

    public bool $enablePagination = false;

    public function query(): Builder
    {
        return $this->itemType->itemTypeGroups()->getQuery();
    }

    public function columns(): array
    {
        return [
            Column::make('group.name', __('Группа')),
            Boolean::make('is_main', __('Тип'))->trueValue(__('Основной'))->falseValue(__('Опциональный')),
            Column::make('sort', __('Порядок')),
        ];
    }

    public function links(): array
    {
        return [
            (new Edit)->emit('manageItemTypeGroup')->preventDefault()
        ];
    }

    public function actions(): array
    {
        return [
            new Delete
        ];
    }
}
