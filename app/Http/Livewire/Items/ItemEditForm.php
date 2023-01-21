<?php

namespace App\Http\Livewire\Items;

use App\Models\Attribute;
use App\Models\AttributeGroup;
use App\Models\Item;
use App\Models\ItemAttribute;
use App\Models\ItemCategory;
use App\Models\ItemType;
use App\Models\ItemTypeGroup;
use App\Models\Unit;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Validation\Rule;
use Livewire\Component;

class ItemEditForm extends Component
{
    public Item $item;
    public ItemType $currentItemType;
    public ?Collection $groups = null;
    public $optionalGroup = null;
    public ?Collection $selectedAttributes = null;
    public ?Collection $similarItems = null;
    public ?string $type = null;
    public string $colspanValue = 'sm:col-span-2';

    protected $listeners = [
        'itemSimilarUpdated' => 'getSimilarItems'
    ];

    public function mount(Item $item)
    {
        if (!$item->category_id) {
            $category = ItemCategory::query()->where('slug',request()->query('type'))->first();
            $item->category_id = $category ? $category->id : null;
        }

        if ($item->category_id === 1 || $item->category_id === 3) {
            $this->colspanValue = 'md:col-span-1';
        }

        $this->item = $item;

//        $this->groups = $this->item->groups ?? collect();

        $this->selectedAttributes = $this->selectedAttributes ??
            $this->item->attributes->mapWithKeys(function (ItemAttribute $pivot) {
                return [$pivot->group_id => (string) $pivot->attribute_id];
            });

//        $this->getAvailableOptionalAttributes();

        if ($this->item->exists) {
            $this->currentItemType = $item->itemType;
            $this->getSimilarItems();
        }
        $this->populateAttributesWithGroups();
    }

    public function rules(): array
    {

        return [
            'item.category_id' => ['required', 'exists:item_categories,id'],
            'item.item_type_id' => ['required', 'exists:item_types,id'],
            'item.unit_id' => ['required', 'exists:units,id'],

            'selectedAttributes' => ['array'],
            'selectedAttributes.*' => ['required', 'integer', 'exists:attributes,id'],

            'item.name' => ['required', 'string'],
            'item.vendor_code' => ['nullable', 'string'],

            'item.weight' => ['sometimes', 'numeric'],
            'item.quantity' => ['sometimes', 'numeric'],

            'item.purchase_price' => ['nullable', 'numeric'],
            'item.return_price' => ['nullable', 'numeric'],
            'item.cost_price' => ['nullable', 'numeric'],

            'item.price' => ['sometimes', 'numeric'],
            'item.is_preferential' => ['sometimes', 'boolean'],

//            'similarItems.*.id' => ['nullable', 'exists:items,id'],
            'similarItems.*.name' => ['required', 'string'],
            'similarItems.*.vendor_code' => ['nullable', 'string'],
            'similarItems.*.purchase_price' => ['nullable', 'numeric'],
            'similarItems.*.cost_price' => ['nullable', 'numeric'],
            'similarItems.*.price' => ['required', 'numeric'],
            'similarItems.*.quantity' => ['sometimes', 'numeric'],

//            'similarItems.*.attributes' => ['array'],
//            'similarItems.*.attributes.*.id' => ['required', 'integer', 'exists:attributes,id'],

//            'similarItems.*.optionalAttribute' => ['required', 'integer', 'exists:attributes,id'],
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

        $this->currentItemType = ItemType::query()->where('id', $this->item->item_type_id)->first();

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
                $query->where('is_main', false);
            })->first();
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

    public function getSimilarItems()
    {
        $item = $this->item;
        $countMainGroups = $this->item->itemType->itemTypeGroups()->where('is_main', true)->count();
        $countMainGroups = $countMainGroups !== 0 ? $countMainGroups : 1;

        $this->similarItems = Item::query()
            ->where('category_id', $item->category_id)
            ->whereHas('attributes', function (Builder $query) use ($item) {
                $query->whereHas('group', function (Builder $query) {
                    $query->whereHas('itemTypeGroups', function (Builder $query) {
                        $query->where('is_main', true);
                    });
                });
                $query->whereIn('attribute_id', $item->attributes->pluck('attribute_id'));
            },'>=',$countMainGroups)
            ->where('id', '!=', $this->item->id)
            ->get();
    }




    public function getAvailableOptionalAttributes()
    {
        $countMainGroups = $this->item->itemType->itemTypeGroups()->whereNotNull('is_main')->count();
        $countMainGroups = $countMainGroups !== 0 ? $countMainGroups : 1;

        $ItemTypeGroups = ItemTypeGroup::query()
            ->where('item_type_id', $this->item->item_type_id)
            ->get();

//        ItemAttribute::query()->where();

        $data = $ItemTypeGroups->map(function (ItemTypeGroup $group){
            if (is_null($group->is_main)) { //Получаем Группу Цвет
                $availableAttributes = $group->group->attributes()->whereNotIn('id',[10,9])->get();
                //dd($group->group->attributes); //Получаем список всех атрибутов - нужно исключить существующие
            } else {
                $availableAttributes = [];
            }
            return [
                'group' => $group->group,
                'available_attributes' => $availableAttributes
            ];
        });

        foreach ($data as $datum) {

        }

        dd($data);

        $item = $this->item;

        $this->similarItems = Item::query()
            ->whereHas('attributes', function (Builder $query) use ($item) {
                $query->whereHas('group', function (Builder $query) {
                    $query->whereHas('itemTypeGroups', function (Builder $query) {
                        $query->whereNotNull('is_main');
                    });
                });
                $query->whereIn('attribute_id', $item->attributes->pluck('attribute_id'));
            },'>=',$countMainGroups)
            ->where('id', '!=', $this->item->id)
            ->get();


        $itemIds = $this->similarItems->pluck('id')->push($this->item->id);
        dd($itemIds);
        dd($this->similarItems->pluck('attributes'));

        foreach ($this->similarItems as $product) {
            var_dump($product->attributes()->count());
        }
        //dd('finish');
    }

    public function submit(): void
    {
        $this->validate();

        $this->item->save();

        if ($this->item->wasRecentlyCreated) {
            $this->item->attributes()->delete();
            foreach ($this->selectedAttributes as $key => $value) {
                $this->item->attributes()->create([
                    'group_id' => $key,
                    'attribute_id' => $value
                ]);
            }

            $this->emit('saved');
            $this->redirect('/items/' . $this->item->id . '/edit');
        } else {
            foreach ($this->similarItems as $similarItem) {
                $similarItem->save();
            }

            $this->emit('saved');
        }
    }
}
