<?php

namespace App\Http\Livewire\Productions;

use App\Models\ItemCategory;
use App\Models\Production;
use App\Models\ProductionItem;
use Illuminate\Database\Eloquent\Builder;
use Karvaka\Wired\Table\Actions\Delete;
use Karvaka\Wired\Table\Columns\Column;
use Karvaka\Wired\Table\Components\Table;
use Karvaka\Wired\Table\Links\Edit;

class ProductionItemsTable extends Table
{
    public Production $production;
    public ?ItemCategory $category = null;

    protected $listeners = ['productionItemsUpdated' => '$refresh'];

    public bool $enablePagination = false;

    public function query(): Builder
    {
        return $this->production->productionItems()->getQuery();
    }

    public function columns(): array
    {
        return [
            Column::make('item.name', __('Наименование')),
            Column::make('need_quantity', __('Необходимое к-во'))
                //->component('columns.item-quantity')
        ];
    }

    public function links(): array
    {
        return [
            (new Edit)->emit('manageProductionItem')->preventDefault()
        ];
    }

    public function actions(): array
    {
        return [
            new Delete
        ];
    }

//    public function customActions(): array
//    {
//        return [
//            Action::make('actions.edit-production-item')
//        ];
//    }
//
//    public function noResultsText(): string
//    {
//        return __('Заказ не содержит продукции.');
//    }
}
