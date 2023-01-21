<?php

namespace App\Http\Livewire\ItemTypes;

use App\Models\ItemType;
use Livewire\Component;

class ItemTypeForm extends Component
{
    public ItemType $itemType;

    public function mount(ItemType $itemType)
    {
        $this->itemType = $itemType;
    }

    public function rules(): array
    {
        return [
            'itemType.name' => ['required', 'string'],
            'itemType.in_title' => ['nullable', 'boolean'],
        ];
    }

    public function submit(): void
    {
        $this->validate();

        $this->itemType->save();

        if ($this->itemType->wasRecentlyCreated) {
            $this->redirectRoute('item-types.edit', ['item_type' => $this->itemType->id]);
        }

        $this->emit('itemTypeSaved');
    }
}
