<?php

namespace App\Http\Livewire\Units;

use App\Models\Unit;
use Livewire\Component;

class UnitForm extends Component
{
    public Unit $unit;

    public function mount(Unit $unit)
    {
        $this->unit = $unit;
    }

    public function rules(): array
    {
        return [
            'unit.symbol' => ['required', 'string'],
            'unit.label' => ['required', 'string'],
        ];
    }

    public function submit(): void
    {
        $this->validate();

        $this->unit->save();

        $this->emit('unitSaved');
    }
}
