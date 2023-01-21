<?php

namespace App\Http\Livewire\Payments;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\ItemCategory;
use App\Models\Shipment;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Livewire\Component;

class PaymentsStatistics extends Component
{
    public ?string $periodFrom = null;
    public ?string $periodTo = null;
    public bool $withOrdersInProcess = true;

    public function mount(): void
    {
        $this->periodFrom = now()->firstOfMonth()->format('Y-m-d');
        $this->periodTo = now()->lastOfMonth()->format('Y-m-d');
    }

    public function rules(): array
    {
        return [
            'periodFrom' => ['nullable', 'date:Y-m-d'],
            'periodTo' => ['nullable', 'date:Y-m-d'],
        ];
    }

    public function getCategories()
    {
        return ItemCategory::query()
            ->where('display_in_orders', true)
            ->get();
    }

    public function getIncomeItemsProperty(): Collection
    {
        $categories = $this->getCategoriesIncomeItems()->add($this->getShipmentsIncomeItem());

        return $categories
            ->add($this->withOrdersInProcess ? $this->getTotalsForOrdersInProcess() : $this->getTotalsForIncomeItems($categories));
    }

    private function getCategoriesIncomeItems(): Collection
    {
        return $this->getCategories()->map(function (ItemCategory $category) {
            $query = OrderItem::query()
                ->whereHas('item', function (Builder $query) use ($category) {
                    $query->where('category_id', $category->id);
                })
                ->whereHas('order', function (Builder $query) {
                    $query->where('status', '!=', Order::STATUS_DRAFTED);
                    $query->whereBetween('created_at', [
                        $this->periodFrom, $this->periodTo
                    ]);
                });

            if ($this->withOrdersInProcess) {
                // a kak shitat' ya hz
                $query->whereRaw('1=0');
            }

            $orderItems = $query->get();

            return (object)[
                'category' => $category->name,
                'amountWithTax' => $orderItems->filter(fn (OrderItem $orderItem) => $orderItem->order->has_tax)->sum('total_amount'),
                'amountWithoutTax' => $orderItems->filter(fn (OrderItem $orderItem) => ! $orderItem->order->has_tax)->sum('total_amount'),
                'totalAmount' => $orderItems->sum('total_amount'),
            ];
        });
    }

    private function getShipmentsIncomeItem(): object
    {
        $shipments = Shipment::query()
            ->where('status', Shipment::STATUS_DELIVERED)
            ->whereBetween('created_at', [
                $this->periodFrom, $this->periodTo
            ])->get();

        return (object)[
            'category' => 'Доставка',
            'amountWithTax' => $shipments->filter(fn (Shipment $shipment) => $shipment->order->has_tax)->sum('amount'),
            'amountWithoutTax' => $shipments->filter(fn (Shipment $shipment) => ! $shipment->order->has_tax)->sum('amount'),
            'totalAmount' => $shipments->sum('amount'),
        ];
    }

    private function getTotalsForIncomeItems($categories): object
    {
        return (object)[
            'category' => __('Общая'),
            'amountWithTax' => $categories->sum('amountWithoutTax'),
            'amountWithoutTax' => $categories->sum('amountWithoutTax'),
            'totalAmount' => $categories->sum('totalAmount'),
        ];
    }

    private function getTotalsForOrdersInProcess(): object
    {
        $orders = Order::query()
            ->where('status', '!=', Order::STATUS_DRAFTED)
            ->whereBetween('created_at', [
                $this->periodFrom, $this->periodTo
            ])->get();

        return (object)[
            'category' => __('Общая'),
            'amountWithTax' => $orders->filter(fn(Order $order) => $order->has_tax)->sum('paid_amount'),
            'amountWithoutTax' => $orders->filter(fn(Order $order) => ! $order->has_tax)->sum('paid_amount'),
            'totalAmount' => $orders->sum('paid_amount'),
        ];
    }
}
