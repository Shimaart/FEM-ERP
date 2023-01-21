<?php

namespace App\Http\Livewire\AttributeGroups;

use Karvaka\Wired\Table\Actions\Delete;
use Karvaka\Wired\Table\Columns\Column;
use Karvaka\Wired\Table\Components\Table;
use Karvaka\Wired\Table\Links\Edit;

class AttributeGroupsTable extends Table
{
    public function columns(): array
    {
        return [
            Column::make('name', __('Наименование'))->searchable()->sortable()
        ];
    }

    public function links(): array
    {
        return [
            (new Edit)->to(fn ($model) => route('attribute-groups.edit', ['attribute_group' => $model->id]))
        ];
    }

    public function actions(): array
    {
        return [
            Delete::make()
        ];
    }
}
