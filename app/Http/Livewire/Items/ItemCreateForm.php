<?php

namespace App\Http\Livewire\Items;

use App\Models\Attribute;
use App\Models\AttributeGroup;
use App\Models\Item;
use App\Models\ItemCategory;
use App\Models\ItemType;
use App\Models\ItemTypeGroup;
use App\Models\Unit;
use Illuminate\Support\Collection;
use Livewire\Component;

class ItemCreateForm extends Component
{
    public Item $item;
    public ?Collection $groups = null;
    public ?Collection $selectedAttributes = null;

    public function mount(Item $item)
    {
        if (!$item->category_id) {
            $category = ItemCategory::query()->where('slug',request()->query('type'))->first();
            if (! $category) {
                $category = ItemCategory::query()->first();
            }
            $item->category_id = $category ? $category->id : null;
        }
        $this->item = $item;

        $this->populateAttributesWithGroups();
    }

    public function rules(): array
    {
        return [
            'item.category_id' => ['required', 'exists:item_categories,id'],
            'item.item_type_id' => ['required', 'exists:item_types,id'],
            'item.unit_id' => ['required', 'exists:units,id'],
            'item.name' => ['required', 'string'],
            'item.vendor_code' => ['nullable', 'string'],
            'item.weight' => ['sometimes', 'numeric'],
            'item.quantity' => ['sometimes', 'numeric'],

            'item.purchase_price' => ['nullable', 'numeric'],
            'item.return_price' => ['nullable', 'numeric'],
            'item.cost_price' => ['nullable', 'numeric'],

            'item.price' => ['sometimes', 'numeric'],
            'item.is_preferential' => ['sometimes', 'boolean'],

            'selectedAttributes' => ['array'],
            'selectedAttributes.*' => ['required', 'integer', 'exists:attributes,id'],
        ];
    }

    public function getItemTypesProperty()
    {
        return ItemType::all();
    }

    public function getUnitsProperty()
    {
        return Unit::all();
    }

    public function updatedItemPrice($value)
    {

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
    }

    public function updatedSelectedAttributes(): void
    {
        $itemName = '';
        if ($this->item->itemType->in_title) {
            $itemName .= $this->item->itemType->name .' ';
        }

        $itemName .= Attribute::query()
            ->whereIn('id', $this->selectedAttributes)
            ->get()
            ->implode('name', ' ');

        $this->item->name = $itemName;
    }

    public function submit(): void
    {
        $this->validate();

        $this->item->save();

        foreach ($this->selectedAttributes as $key => $value) {
            $this->item->attributes()->create([
                'group_id' => $key,
                'attribute_id' => $value
            ]);
        }

        $this->emit('saved');
        $this->redirect('/items/' . $this->item->id . '/edit');
    }
}
