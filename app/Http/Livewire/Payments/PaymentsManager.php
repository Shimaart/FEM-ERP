<?php

namespace App\Http\Livewire\Payments;

use App\Models\CostItem;
use App\Models\PaymentMaterial;
use App\Models\Item;
use App\Models\Payment;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Validation\Rule;
use Livewire\Component;

class PaymentsManager extends Component
{
    public int $material_id;
    public bool $hasMaterials = false;
    public bool $managingPayment = false;
    public ?Payment $payment = null;
    public ?Item $item = null;
    public ?PaymentMaterial $paymentMaterial = null;

    protected $listeners = ['managePayment'];

    public function rules(): array
    {
        $rules = [
            'payment.payment_type' => ['required', Rule::in(Payment::paymentTypes())],
            'payment.status' => ['nullable', Rule::in(Payment::statuses())],
            'payment.amount' => ['required', 'numeric', 'min:1'],
            'payment.paymentable_id' => ['required', 'exists:cost_items,id'],
        ];

        $optionalType = 'nullable';
        if ($this->getPropertyValue('payment.paymentable_id')) {
            $costItem = CostItem::query()->where('id', '=',$this->getPropertyValue('payment.paymentable_id'))->first();
            if ($costItem && $costItem->type === CostItem::TYPE_PRODUCTION) {
                $optionalType = 'required';
            }
        }

        $rules['paymentMaterial.item_id'] = [$optionalType, 'exists:items,id'];
        $rules['paymentMaterial.quantity'] = [$optionalType, 'numeric'];
        $rules['paymentMaterial.purchase_price'] = [$optionalType, 'numeric'];

        return $rules;
    }

    public function validationAttributes(): array
    {
        return [
            'paymentable_id' => __('Статья затрат')
        ];
    }

    public function getCostItemsProperty()
    {
        return CostItem::query()->oldest('name')->get();
    }

    public function getMaterialsProperty()
    {
        $materials = Item::query()
            ->whereHas('itemCategory', function (Builder $query) {
                $query->where('name', '=', 'Сырье');
            })
            ->get();

        return $materials;
    }

    public function paymentSelected(): void
    {
        $this->item = null;
        $this->paymentMaterial = null;
        $this->hasMaterials = false;
        $this->payment->paymentable_type = 'cost_item';

        if ($this->payment->paymentable && $this->payment->paymentable->type === 'production') {
            $this->hasMaterials = true;
            $this->paymentMaterial = new PaymentMaterial();
        }
    }

    public function itemSelected(): void
    {
        $item = Item::query()->where('id', '=', $this->paymentMaterial->item_id)->first();
        $this->item = $item;
        $this->paymentMaterial->purchase_price = $item ? $item->purchase_price : 0;
    }

    public function managePayment(Payment $payment): void
    {
        $this->payment = $payment;
        $this->payment->forceFill([
            'amount' => abs($this->payment->amount),
            'payment_type' => $this->payment->payment_type ?? Payment::PAYMENT_TYPE_CASH,
            'status' => $this->payment->status ?? Payment::STATUS_CREATED,
        ]);
        $this->managingPayment = true;
    }

    public function savePayment(): void
    {
        $this->validate();

        $this->payment->forceFill([
            'paymentable_type' => (new CostItem())->getMorphClass(),
            'amount' => -1 * abs($this->payment->amount),
            'currency' => 'UAH',
            'paid_at' => now(),
            'status' => $this->payment->status
        ])->save();

        if ($this->paymentMaterial) {
            $this->paymentMaterial->forceFill([
                'payment_id' => $this->payment->id
            ])->save();

            if ($this->item->purchase_price !== $this->paymentMaterial->purchase_price) {
                $this->item->update([
                    'purchase_price' => $this->paymentMaterial->purchase_price
                ]);
            }
        }

        $this->paymentMaterial = null;
        $this->managingPayment = false;

        $this->emit('paymentSaved');
    }
}
