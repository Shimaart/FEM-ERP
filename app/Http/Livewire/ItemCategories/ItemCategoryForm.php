<?php

namespace App\Http\Livewire\ItemCategories;

use App\Models\ItemCategory;
use Livewire\Component;

class ItemCategoryForm extends Component
{
    public ItemCategory $itemCategory;

    public function mount(ItemCategory $itemCategory)
    {
        $this->itemCategory = $itemCategory;
    }

    public function rules(): array
    {
        return [
            'itemCategory.name' => ['required', 'string'],
            'itemCategory.slug' => ['required', 'string'],
            'itemCategory.display_in_items' => ['nullable', 'boolean'],
            'itemCategory.display_in_orders' => ['nullable', 'boolean'],
            'itemCategory.sort' => ['required', 'integer'],
        ];
    }

    public function submit(): void
    {
        $this->validate();

        $this->itemCategory->save();

        $this->emit('saved');

        $this->redirect('/item-categories');
    }
}
