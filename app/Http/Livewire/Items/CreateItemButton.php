<?php

namespace App\Http\Livewire\Items;

use Livewire\Component;

class CreateItemButton extends Component
{
    protected $listeners = ['typeChanged'];

    public ?string $type = null;

    public function mount()
    {
        $this->type = request()->query('tab');
    }

    public function typeChanged($type): void
    {
        $this->type = $type;
    }
}
