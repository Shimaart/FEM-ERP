<?php

namespace App\Http\Livewire\Suppliers;

use App\Concerns\HasContacts;
use App\Models\Supplier;
use App\Http\Livewire\Contacts\ManagesContacts;
use Livewire\Component;

class SupplierForm extends Component
{
    use ManagesContacts;

    public Supplier $supplier;

    public function mount(Supplier $supplier)
    {
        $this->supplier = $supplier;
    }

    public function rules(): array
    {
        return array_merge([
            'supplier.name' => ['required', 'string'],
            'supplier.contact_name' => ['nullable', 'string'],
            'supplier.address' => ['nullable', 'string'],
            'supplier.identifier' => ['nullable', 'string', 'size:8'],
        ], $this->contactsRules());
    }

    public function messages(): array
    {
        return [
            'supplier.identifier.size' => 'Идентификационные коды ЕГРПОУ содержат 8 знаков.'
        ];
    }

    public function submit(): void
    {
        $this->validate();

        $this->supplier->save();

        $this->saveContacts();

        $this->emit('saved');
    }

    /**
     * @return HasContacts
     */
    protected function contactable()
    {
        return $this->supplier;
    }
}
