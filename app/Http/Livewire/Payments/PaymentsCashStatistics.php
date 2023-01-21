<?php

namespace App\Http\Livewire\Payments;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\ItemCategory;
use App\Models\Payment;
use App\Models\Shipment;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Livewire\Component;

class PaymentsCashStatistics extends Component
{
    public ?string $periodFrom = null;
    public ?string $periodTo = null;

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

    protected function getPayments()
    {
        $dateTo = new Carbon($this->periodTo);
        $dateTo->modify('+1 day');
        return Payment::query()
            ->where('status', '=', Payment::STATUS_PAID)
            ->where('payment_type', '=', Payment::PAYMENT_TYPE_CASH)
            ->whereBetween('paid_at', [
                $this->periodFrom, $dateTo->format('Y-m-d')
            ])
            ->get();
    }

    public function getTotalProperty()
    {
        return $this->getPayments()->sum('amount');
    }

    public function getOutgoingTotalProperty()
    {
        return $this->getPayments()
            ->where('amount', '<', 0)
            ->sum('amount');
    }

    public function getIncomeTotalProperty()
    {
        return $this->getPayments()
            ->where('amount', '>=', 0)
            ->sum('amount');
    }
}
