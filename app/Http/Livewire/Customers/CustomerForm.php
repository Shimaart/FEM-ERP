<?php

namespace App\Http\Livewire\Customers;

use App\Concerns\HasContacts;
use App\Http\Livewire\Contacts\ManagesContacts;
use App\Models\Customer;
use Livewire\Component;

class CustomerForm extends Component
{
    use ManagesContacts;

    public Customer $customer;

    public bool $inModal = false;

    protected $listeners = [
        'setCustomer' => 'setCustomer',
        'saveCustomer' => 'submit'
    ];

    public function mount(Customer $customer): void
    {
        $this->customer = $customer;
    }

    public function setCustomer($customerId): void
    {
        $this->customer = Customer::query()->findOrNew($customerId);
        $this->setContacts();
    }

    public function rules(): array
    {
        return array_merge([
            'customer.name' => ['required', 'string'],
            'customer.address' => ['nullable', 'string'],
        ], $this->contactsRules());
    }

    public function submit(): void
    {
        $this->validate();

        $this->customer->save();

        $this->saveContacts();

        $this->emit('customerSaved', $this->customer->id);
    }

    /**
     * @return HasContacts
     */
    protected function contactable()
    {
        return $this->customer;
    }
}
