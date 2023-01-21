<?php

namespace App\Http\Livewire\Transports;

use App\Models\Transport;
use Livewire\Component;

class TransportForm extends Component
{
    public Transport $transport;

    public function mount(Transport $transport)
    {
        $this->transport = $transport;
    }

    public function rules(): array
    {
        return [
            'transport.name' => ['required', 'string'],
            'transport.kilometer_price' => ['required', 'numeric'],
        ];
    }

    public function submit(): void
    {
        $this->validate();

        $this->transport->save();

        $this->emit('saved');
    }
}
