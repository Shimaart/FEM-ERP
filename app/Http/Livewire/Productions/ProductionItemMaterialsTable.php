<?php

namespace App\Http\Livewire\Productions;

use App\Models\ConsumedMaterial;
use App\Models\ItemCategory;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\ProductionItem;
use Illuminate\Database\Eloquent\Builder;
use Karvaka\Wired\Table\Actions\Delete;
use Karvaka\Wired\Table\Columns\Column;
use Karvaka\Wired\Table\Components\Table;
use Karvaka\Wired\Table\Links\Edit;

class ProductionItemMaterialsTable extends Table
{
    public ProductionItem $productionItem;

    protected $listeners = ['consumedMaterialsUpdated' => '$refresh'];

    public bool $enablePagination = false;

    public function query(): Builder
    {
        return $this->productionItem->materials()->getQuery();
    }

    public function columns(): array
    {
        return [
            Column::make('material.name', __('Материал')),
            Column::make('value', __('Количество')) //->component('columns.item-quantity')
        ];
    }

    public function links(): array
    {
        return [
            (new Edit)->emit('manageConsumedMaterial')->preventDefault()
        ];
    }

    public function actions(): array
    {
        return [
            new Delete
        ];
    }
    public function noResultsText(): string
    {
        return __('Заказ не содержит продукции.');
    }
}
