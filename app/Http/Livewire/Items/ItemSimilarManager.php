<?php

namespace App\Http\Livewire\Items;

use App\Models\Attribute;
use App\Models\AttributeGroup;
use App\Models\Item;
use App\Models\ItemAttribute;
use App\Models\ItemType;
use App\Models\ItemTypeGroup;
use App\Models\Order;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ItemSimilarManager extends Component
{
    use AuthorizesRequests;

    public Item $item;
    public bool $managingSimilarItem = false;
    public ?Item $similarItem = null;
    public ?Collection $selectedAttributes = null;

    public ?Collection $groups = null;


    protected $listeners = ['manageSimilarItem'];

    public function mount(Item $item)
    {
        $this->item = $item;


//        foreach ($this->item->attributes as $attribute) {
//
//            dd($attribute->group->itemTypes()->whereHas());
//        }
//        dd($this->item->selectedAttributes);
//
        $this->selectedAttributes = $this->selectedAttributes ??
            $this->item->attributes->mapWithKeys(function (ItemAttribute $pivot) {
                return [$pivot->group_id => (string) $pivot->attribute_id];
            });

//        dd($this->selectedAttributes);
//
        $this->populateAttributesWithGroups();

    }

    public function rules(): array
    {
        return [
//            'similarItem.name' => ['required', 'string'],
            'similarItem.cost_price' => ['sometimes', 'numeric'],
            'similarItem.price' => ['required', 'numeric'],
            'similarItem.quantity' => ['required', 'numeric'],
            'similarItem.vendor_code' => ['nullable', 'string'],

            'selectedAttributes' => ['array'],
            'selectedAttributes.*' => ['required', 'integer', 'exists:attributes,id'],
        ];
    }

    public function manageSimilarItem(Item $similarItem): void
    {
        $this->clearValidation();
        $this->similarItem = $similarItem;
        $this->similarItem->category_id = $this->item->category_id;
       // $this->authorizeModel($this->similarItem);

        $this->managingSimilarItem = true;
    }

    public function saveSimilarItem(): void
    {
        if (is_null($this->similarItem)) {
            return;
        }

        $item = $this->item;

        $this->updatedSelectedAttributes();
        $this->similarItem->category_id = $item->category_id;
        $this->similarItem->unit_id = $item->unit_id;
        $this->similarItem->item_type_id = $item->item_type_id;
//        $this->similarItem->price = $item->price;
        $this->similarItem->is_preferential = $item->is_preferential;
        $this->similarItem->weight = $item->weight;
//        dd($this->similarItem);

//        dd($this->validate());
//        $this->authorizeModel($this->similarItem);
        $this->validate();

        if ($this->checkIsset()) {
            $this->addError('similarItem.quantity', 'Такой товар уже существует');

        } else {
            $this->similarItem->save();

            foreach ($this->selectedAttributes as $key => $value) {
                $this->similarItem->attributes()->create([
                    'group_id' => $key,
                    'attribute_id' => $value
                ]);
            }

            $this->emit('itemSimilarUpdated');
            $this->managingSimilarItem = false;
        }
    }

    protected function authorizeModel(Item $similarItem): void
    {
        $similarItem->exists ?
            $this->authorize('update', $similarItem) :
            $this->authorize('create', Item::class);
    }

    protected function checkIsset()
    {
        return Item::query()->whereHas('attributes', function (Builder $query) {
           $query->whereIn('attribute_id', $this->selectedAttributes);
        }, $this->selectedAttributes->count())->count();
    }








    public function updatedItemItemTypeId()
    {
        $this->populateAttributesWithGroups();
        $this->selectedAttributes = collect();
        $this->updatedSelectedAttributes();
    }

    protected function populateAttributesWithGroups()
    {
        if (is_null($this->item->item_type_id)) {
            return;
        }

        $types = ItemTypeGroup::query()
            ->where('item_type_id', $this->item->item_type_id)
            ->pluck('group_id');

        $this->groups = AttributeGroup::query()
            ->with('attributes')
            ->whereIn('id', $types)
            ->get();

        $this->optionalGroup = AttributeGroup::query()
            ->with('attributes')
            ->whereIn('id', $types)->whereHas('itemTypeGroups', function (Builder $query){
                $query->whereNull('is_main');
            })->first();
    }

    public function updatedSelectedAttributes(): void
    {
        $itemName = '';
        if ($this->item->ItemType->in_title) {
            $itemName .= $this->item->ItemType->name .' ';
        }

        $itemName .= Attribute::query()
            ->whereIn('id', $this->selectedAttributes)
            ->get()
            ->implode('name', ' ');

        $this->similarItem->name = $itemName;
    }
}
