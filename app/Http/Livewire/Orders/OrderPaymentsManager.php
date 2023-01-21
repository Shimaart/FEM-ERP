<?php

namespace App\Http\Livewire\Orders;

use App\Format;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Validation\Rule;
use Livewire\Component;

class OrderPaymentsManager extends Component
{
    public Order $order;

    public bool $creatingNewPayment = false;
    public bool $updatingOrderDiscount = false;

    public array $newPaymentForm = [
        //'with_nds' => true,
//        'payment_type' => Payment::PAYMENT_TYPE_CASH,
        'amount' => '0.0'
    ];

    public array $updateOrderDiscountForm = [
        'discount_amount' => '0.0'
    ];

    protected $listeners = [
        'orderSaved' => '$refresh',
        'orderItemSaved' => '$refresh',
        'orderItemDeleted' => '$refresh',
        'shipmentSaved' => '$refresh',
        'shipmentDeleted' => '$refresh',
        'refundSaved' => '$refresh',
        'refundDeleted' => '$refresh',
        'paymentSaved' => '$refresh',
        'paymentDeleted' => '$refresh'
    ];

    public function rules(): array
    {
        return [
            //'order.tax' => ['required', Rule::in(Order::taxes())],
        ];
    }

    public function createPayment(): void
    {
        $this->validate([
            //'newPaymentForm.with_nds' => ['required', 'boolean'],
            //'newPaymentForm.payment_type' => ['required', Rule::in(Payment::paymentTypes())],
            'newPaymentForm.amount' => [
                'required', 'numeric', 'min:1',
                function ($attribute, $value, $fail) {
                    $amount = (float)$value;

                    if (($this->order->paid_amount + $amount) > $this->order->total_amount) {
                        $fail(__('Сумма всех платежей не может превышать общую стоимость заказа. Переплата: :overpayment.', [
                            'overpayment' => Format::asCurrency(
                                ($this->order->paid_amount + $amount) - $this->order->total_amount
                            )
                        ]));
                    }
                }
            ],
        ], [
            'newPaymentForm.amount.min' => __('Укажите сумму платежа.')
        ]);

        $this->order->payments()->create([
            'amount' => $this->newPaymentForm['amount'],
            'payment_type' => $this->order->payment_type,
            'currency' => 'UAH',
            'paid_at' => now(),
            'status' => Payment::STATUS_PAID
        ]);

        $this->order->load('payments');

        $this->reset('newPaymentForm');
        $this->emit('paymentSaved');
        $this->creatingNewPayment = false;
    }

    public function updatingUpdatingOrderDiscount(): void
    {
        $this->updateOrderDiscountForm = [
            'discount_amount' => $this->order->discount_amount
        ];
    }

    public function updateOrderDiscount(): void
    {
        $this->validate([
            'updateOrderDiscountForm.discount_amount' => ['nullable', 'numeric', 'min:0']
        ]);

        if (!$this->updateOrderDiscountForm['discount_amount']) {
            $this->updateOrderDiscountForm['discount_amount'] = 0;
        }

        $this->order->forceFill($this->updateOrderDiscountForm)->refreshTotalAmount()->save();

        $this->reset('updateOrderDiscountForm');
        $this->emit('orderSaved');
        $this->updatingOrderDiscount = false;
    }

    public function updatedOrderTax($tax): void
    {
        $this->validateOnly('order.tax');

        $this->order->forceFill([
            'tax' => $tax
        ])->refreshTotalAmount()->save();

        $this->emit('orderSaved');
    }
}
