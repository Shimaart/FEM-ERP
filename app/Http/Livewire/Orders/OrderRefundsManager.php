<?php

namespace App\Http\Livewire\Orders;

use App\Models\Order;
use App\Models\Payment;
use App\Models\Refund;
use App\Models\RefundProduct;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Livewire\Component;

class OrderRefundsManager extends Component
{
    public Order $order;
    public bool $managingRefund = false;
    public ?Refund $refund = null;
    public ?RefundProduct $refundProduct = null;

    protected $listeners = ['manageRefund'];

    public function rules(): array
    {
        return [
            'refund.comment' => ['nullable', 'string'],
            'refundProduct.return_price' => ['nullable', 'numeric'],
            'refundProduct.item_id' => [
                'required', Rule::exists('order_items', 'id')
//                'required', Rule::exists('order_items', 'id')->where('order_id', $this->order->id)
            ],
            'refundProduct.quantity' => [
                'required', 'numeric', 'min:0',
                function ($attribute, $quantity, $fail) {
                    if (! $this->refundProduct->orderItem) {
                        return;
                    }

                    if ($quantity > $this->refundProduct->orderItem->quantity) {
                        $fail(__('Количество не должно превышать :quantity', [
                            'quantity' => $this->refundProduct->orderItem->quantity
                        ]));
                    }
                }
            ]
        ];
    }

    public function manageRefund(Refund $refund): void
    {
        $this->clearValidation();

        $this->refund = $refund;
        $this->refundProduct = $refund->products()->first() ?: $refund->products()->make();

        $this->managingRefund = true;
    }

    public function saveRefund(): void
    {
        if (is_null($this->refund)) {
            return;
        }

        $this->validate();

        if (! $this->refund->exists) {
            $this->refund->forceFill([
                'order_id' => $this->order->id,
                'manager_id' => Auth::id()
            ]);
        }

        $returnPrice = $this->refundProduct->orderItem->item->price;
        if ($this->refundProduct->return_price) {
            $returnPrice = $this->refundProduct->return_price;
        } elseif ($this->refundProduct->orderItem->item->return_price) {
            $returnPrice = $this->refundProduct->orderItem->item->return_price;
        }

        $this->refund->forceFill([
            'amount' => $this->refundProduct->quantity * $returnPrice
        ])->save();

        $this->refundProduct->forceFill([
            'refund_id' => $this->refund->id
        ])->save();

        if ($this->refundProduct
            && $this->refundProduct->orderItem
            && $this->refundProduct->orderItem->item
            && $this->refundProduct->orderItem->item->itemCategory
            && $this->refundProduct->orderItem->item->itemCategory->slug === 'pallets'
        ) {
            $palletReturnPrice = $this->refundProduct->return_price ?? $this->refundProduct->orderItem->item->return_price;
            $consumption = $palletReturnPrice * $this->refundProduct->quantity;

            $this->refundProduct->payments()->create([
                'amount' => -$consumption,
                'payment_type' => $this->order->payment_type,
                'currency' => 'UAH',
                'status' => Payment::STATUS_CREATED
            ]);
        }

        $this->emit('refundSaved');

        $this->managingRefund = false;
    }

    public function getOrderItemsProperty()
    {
        return $this->order->orderItems()->get();
    }
}
