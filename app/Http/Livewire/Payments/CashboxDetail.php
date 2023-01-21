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
use Livewire\WithPagination;

class CashboxDetail extends Component
{
    use WithPagination;

    public ?string $periodFrom = null;
    public ?string $periodTo = null;
    public ?string $type = 'income';

    public function mount(): void
    {
        if (!$this->periodFrom) {
            $this->periodFrom = now()->firstOfMonth()->format('Y-m-d');
        }

        if ($this->periodTo) {
            $this->periodTo = now()->lastOfMonth()->format('Y-m-d');
        }
    }

    public function rules(): array
    {
        return [
            'periodFrom' => ['nullable', 'date:Y-m-d'],
            'periodTo' => ['nullable', 'date:Y-m-d'],
        ];
    }

    public function render()
    {
        $dateTo = new Carbon($this->periodTo);
        $dateTo->modify('+1 day');

        $query = Payment::query()
            ->where('status', '=', Payment::STATUS_PAID)
            ->where('payment_type', '=', Payment::PAYMENT_TYPE_CASHLESS)
            ->whereBetween('paid_at', [
                $this->periodFrom, $dateTo->format('Y-m-d')
            ]);

        if ($this->type === 'outgoing') {
            $query->where('amount', '<', 0);
        } else {
            $query->where('amount', '>=', 0);
        }

        return view('livewire.payments.cashbox-detail', [
            'payments' => $query->paginate(10)
        ]);
    }
}
