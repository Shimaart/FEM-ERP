<?php

namespace App\Http\Livewire\CostItems;

use App\Models\CostItem;
use Livewire\Component;

class CostItemForm extends Component
{
    public CostItem $costItem;

    public function mount(CostItem $costItem)
    {
        $this->costItem = $costItem;
    }

    public function rules(): array
    {
        return [
            'costItem.name' => ['required', 'string'],
            'costItem.type' => ['nullable', 'string']
        ];
    }

    public function submit(): void
    {
        $this->validate();

        $this->costItem->save();

        $this->redirectRoute('cost-items.index');
    }
}
