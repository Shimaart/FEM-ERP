<?php

namespace App\Http\Livewire\Items;

use App\Models\ItemCategory;
use Illuminate\Database\Eloquent\Builder;
use Karvaka\Wired\Table\Actions\Delete;
use Karvaka\Wired\Table\Links\Edit;
use Karvaka\Wired\Table\Tabs\Tab;
use Karvaka\Wired\Table\Columns\Column;
use Karvaka\Wired\Table\Components\Table;

class ItemsTable extends Table
{
    public function columns(): array
    {
        return [
            Column::make('name', __('Наименование'))->sortable()->searchable(),
            Column::make('quantity', __('Наличие'))->component('wired-table.columns.item-quantity')->sortable(),
        ];
    }

    public function tabs(): array
    {
        return ItemCategory::query()->where('display_in_items','=',true)
            ->get()
            ->map(function (ItemCategory $category) {
                return Tab::make($category->slug, $category->name)
                    ->filterUsing(fn (Builder $query) => $query->byCategorySlug($category->slug));
            })
            ->toArray();
    }

    public function links(): array
    {
        return [
            (new Edit)->to(fn ($model) => route('items.edit', ['item' => $model->id]))
        ];
    }

    public function actions(): array
    {
        return [
            Delete::make()
        ];
    }

    public function tabSwitched(): void
    {
        parent::tabSwitched();

        $this->emit('typeChanged', $this->tab);
    }
}
