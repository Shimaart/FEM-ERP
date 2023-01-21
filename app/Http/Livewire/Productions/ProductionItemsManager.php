<?php

namespace App\Http\Livewire\Productions;

use App\Models\Item;
use App\Models\ItemCategory;
use App\Models\Production;
use App\Models\ProductionItem;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class ProductionItemsManager extends Component
{
    public Production $production;
    public ?ItemCategory $category = null;

    public bool $managingProductionItem = false;
    public ?ProductionItem $managedProductionItem = null;

    protected $listeners = [
        // emits update action from table
        'manageProductionItem' => 'manageProductionItem'
    ];

    public function rules(): array
    {
        return [
            'managedProductionItem.item_id' => ['required', 'exists:items,id'],
            'managedProductionItem.need_quantity' => ['required', 'numeric', 'min:0']
        ];
    }

    public function getValidationAttributes(): array
    {
        return [
            'managedProductionItem.item_id' => 'Продукция',
            'managedProductionItem.need_quantity' => 'Необходимое к-во'
        ];
    }

    public function manageProductionItem(ProductionItem $productionItem): void
    {
        $this->clearValidation();

        $this->managedProductionItem = $productionItem;

        $this->managingProductionItem = true;
    }

    public function saveProductionItem(): void
    {
        if (!$this->managedProductionItem) {
            return;
        }

        $this->validate();

        $this->production->productionItems()->save($this->managedProductionItem);

        $this->emit('productionItemsUpdated');

        $this->managingProductionItem = false;
        $this->managedProductionItem = null;
    }

    public function updatedManagedProductionItem($value, $key): void
    {
        $key = (string)$key;

        if ($key === 'item_id' && $this->managedProductionItem && $item = Item::query()->find($value)) {
            $this->managedProductionItem->item()->associate($item);
        }
    }

    public function getItemsProperty(): Collection
    {
        return Item::query()->whereHas('itemCategory', function (Builder $query){
        $query->where('name','Собственная');
    })->get();
    }
}
