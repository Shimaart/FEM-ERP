<?php

namespace App\Http\Livewire\Orders;

use App\Models\Customer;
use App\Models\Order;
use Illuminate\Validation\Rule;
use Livewire\Component;

class OrderForm extends Component
{
    public Order $order;

    public bool $managingCustomer = false;

    protected $listeners = [
        'customerSelected' => 'customerSelected',
        'customerSaved' => 'customerSaved'
    ];

    public function mount(Order $order): void
    {
        $this->order = $order;
        $this->setCustomer($order->customer ?? new Customer);
        if ($this->order->status === Order::STATUS_DRAFTED && !$this->order->tax_percent) {
            $this->order->tax_percent = Order::defaultTaxPercent($this->order->tax);
        }
    }

    public function customerSelected($customerId): void
    {
        $this->setCustomer(Customer::query()->findOrNew($customerId));
    }

    public function setDefaultTaxPercent(): void
    {
        if ($this->order->status === Order::STATUS_DRAFTED) {
            $this->order->tax_percent = Order::defaultTaxPercent($this->order->tax);
        }
    }

    public function customerSaved(Customer $customer): void
    {
        $this->setCustomer($customer);

        $this->managingCustomer = false;
    }

    private function setCustomer(Customer $customer)
    {
        $this->order->customer_id = $customer->id;
        $this->order->customer()->associate($customer);

        $this->emit('setCustomer', $customer->id);
    }

    public function rules(): array
    {
        $rules = [
            'order.customer_id' => ['nullable', 'exists:customers,id'],
            'order.status' => ['required', Rule::in(Order::statuses())],
            'order.note' => ['nullable', 'string'],
        ];

        if ($this->order->status === Order::STATUS_DRAFTED) {
            $rules['order.tax'] =  ['required', 'string'];
            $rules['order.tax_percent'] =  ['required', 'numeric'];
        } else {
            $rules['order.tax_percent'] =  ['nullable', 'numeric'];
        }

        return $rules;
    }

    public function submit(): void
    {
        $this->validate();

        $this->order->save();
        $this->order->refreshTotalAmount()->save();

        $this->order->refresh();

        $this->emit('orderSaved');
    }
}
