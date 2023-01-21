<?php

namespace App\Http\Livewire\Customers;

use App\Models\Customer;
use Karvaka\Wired\Select\Components\Select;

class CustomerSelect extends Select
{
    protected $listeners = [
        'customerSaved' => '$refresh',
        'setCustomer' => 'setCustomer',
    ];

    public function setCustomer($customerId): void
    {
        $this->value = $customerId;
    }

    public function options(?string $search = null): iterable
    {
        return Customer::query()
            ->where('name', 'like', '%' . $search . '%')
//            ->limit(30)
            ->get()
            ->pluck('name', 'id');
    }
}
