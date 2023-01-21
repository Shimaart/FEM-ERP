<?php

namespace App\Http\Livewire\AttributeGroups;

use App\Models\AttributeGroup;
use Illuminate\Database\Eloquent\Builder;
use Karvaka\Wired\Table\Actions\Delete;
use Karvaka\Wired\Table\Columns\Column;
use Karvaka\Wired\Table\Components\Table;
use Karvaka\Wired\Table\Links\Edit;

class AttributesTable extends Table
{
    public AttributeGroup $attributeGroup;

    protected $listeners = [
        'attributeSaved' => '$refresh'
    ];

    public bool $enablePagination = false;

    public ?string $noResultsText = 'Атрибутов не найдено.';

    public function query(): Builder
    {
        return $this->attributeGroup->attributes()->getQuery();
    }

    public function columns(): array
    {
        return [
            Column::make('name', __('Наименование'))->sortable()
        ];
    }

    public function links(): array
    {
        return [
            (new Edit)->emit('manageAttribute')->preventDefault()
        ];
    }

    public function actions(): array
    {
        return [
            new Delete
        ];
    }
}
