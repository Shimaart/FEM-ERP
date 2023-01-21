<?php

namespace App\Http\Livewire\ItemTypes;

use App\Models\AttributeGroup;
use App\Models\Item;
use App\Models\ItemType;
use App\Models\ItemTypeGroup;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Validation\Rule;
use Livewire\Component;

class ItemTypeGroupsManager extends Component
{
    public ItemType $itemType;

    public bool $managingItemTypeGroup = false;
    public ?ItemTypeGroup $managedItemTypeGroup = null;

    protected $listeners = [
        'manageItemTypeGroup'
    ];

    public function rules(): array
    {
        return [
            'managedItemTypeGroup.is_main' => ['nullable', 'boolean'],
            'managedItemTypeGroup.sort' => ['nullable', 'numeric'],

//            'managedItemTypeGroup.group_id' => ['required', 'exists:attribute_groups,id'],

            'managedItemTypeGroup.group_id' =>  [
                'required',
                'exists:attribute_groups,id',
//                Rule::unique('item_type_groups')
//                    //->ignore($this->managedItemTypeGroup->group_id)
//                    ->where('item_type_id', $this->itemType->id)
            ]
        ];
    }

    public function getValidationItemTypeGroups(): array
    {
        return [
            'managedItemTypeGroup.name' => 'Вариация'
        ];
    }

    public function manageItemTypeGroup(ItemTypeGroup $itemTypeGroup): void
    {
        $this->clearValidation();

        $this->managedItemTypeGroup = $itemTypeGroup;
//        dd($this->managedItemTypeGroup->group_id);

        $this->managingItemTypeGroup = true;
    }

    public function saveItemTypeGroup(): void
    {
        if (!$this->managedItemTypeGroup) {
            return;
        }

//        dd($this->managedItemTypeGroup);
//        dd($this->validate());

        $this->validate();
        try {
            $this->itemType->itemTypeGroups()->save($this->managedItemTypeGroup);
            $this->emit('itemTypeGroupsUpdated');

            $this->managingItemTypeGroup = false;
            $this->managedItemTypeGroup = null;
        } catch (\Exception $e) {
            $this->addError('managedItemTypeGroup.group_id', 'Дублирующаяся запись');
        }
    }

    public function getGroupsProperty(): Collection
    {
//        dd($this->managedItemTypeGroup->group_id);
        return AttributeGroup::query()
            //->whereNotIn('id',$this->itemType->itemTypeGroups->pluck('group_id'))
            //->orWhere('id','=', $this->managedItemTypeGroup->group_id)
            ->get();
    }
}
