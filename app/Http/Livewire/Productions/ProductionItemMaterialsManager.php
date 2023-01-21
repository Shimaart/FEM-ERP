<?php

namespace App\Http\Livewire\Productions;

use App\Models\ConsumedMaterial;
use App\Models\Production;
use App\Models\Item;
use App\Models\ItemCategory;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\ProductionItem;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;
use Illuminate\Database\Eloquent\Builder;

class ProductionItemMaterialsManager extends Component
{
    public ProductionItem $productionItem;
//    public ?ItemCategory $category = null; xz - категория Сырье

    public bool $managingConsumedMaterial = false;
    public bool $updatingConsumedMaterial = false;
    public ?ConsumedMaterial $managedConsumedMaterial = null;

    protected $listeners = [
        // emits update action from table
        'manageConsumedMaterial' => 'manageConsumedMaterial'
    ];

    public function rules(): array
    {
        return [
            'managedConsumedMaterial.production_item_id' => ['required', 'exists:items,id'],
            'managedConsumedMaterial.material_id' => ['required', 'exists:items,id'],
            'managedConsumedMaterial.value' => ['required', 'numeric', 'min:0'],
        ];
    }

    public function getValidationAttributes(): array
    {
        return [
            'managedConsumedMaterial.production_item_id' => 'Продукция',
            'managedConsumedMaterial.material_id' => 'Материал',
            'managedConsumedMaterial.value' => 'Количество',
        ];
    }

    public function manageConsumedMaterial(ConsumedMaterial $consumedMaterial): void
    {
        $this->clearValidation();

        $this->managedConsumedMaterial = $consumedMaterial;

        $this->managingConsumedMaterial = true;
    }

    public function saveConsumedMaterial(): void
    {
        if (!$this->managedConsumedMaterial) {
            return;
        }
        $this->managedConsumedMaterial->production_item_id = $this->productionItem->id;

        $this->validate();

        $this->productionItem->materials()->save($this->managedConsumedMaterial);

        $this->emit('consumedMaterialsUpdated');

        $this->managingConsumedMaterial = false;
        $this->managedConsumedMaterial = null;
    }

    public function updatedManagedConsumedMaterial($value, $key): void
    {
        $key = (string)$key;

        if ($key === 'material_id' && $this->managedConsumedMaterial && $item = Item::query()->find($value)) {
            $this->managedConsumedMaterial->material()->associate($item);
        }
    }

    public function getItemsProperty(): Collection
    {
//        return Item::query()->where('category_id', 3)->get();
        return Item::query()->whereHas('itemCategory', function (Builder $query){
            $query->where('name','Сырье');
        })->get();
    }
}
