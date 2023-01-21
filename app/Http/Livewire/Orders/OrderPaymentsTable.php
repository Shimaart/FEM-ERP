<?php

namespace App\Http\Livewire\Orders;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Database\Eloquent\Builder;
use Karvaka\Wired\Table\Actions\Delete;
use Karvaka\Wired\Table\Columns\DateTime;
use Karvaka\Wired\Table\Columns\Enum;
use Karvaka\Wired\Table\Columns\Number;
use Karvaka\Wired\Table\Components\Table;

class OrderPaymentsTable extends Table
{
    public Order $order;

    public bool $enablePagination = false;

    protected $listeners = [
        'orderItemSaved' => '$refresh',
        'orderItemDeleted' => '$refresh',
        'shipmentSaved' => '$refresh',
        'shipmentDeleted' => '$refresh',
        'refundSaved' => '$refresh',
        'refundDeleted' => '$refresh',
        'paymentSaved' => '$refresh',
        'paymentDeleted' => '$refresh'
    ];

    public function query(): Builder
    {
        return $this->order->payments()->getQuery();
    }

    public function columns(): array
    {
        return [
            DateTime::make('created_at'),
            Enum::make('payment_type')->values(Payment::paymentTypeOptions()),
            Number::make('amount')
        ];
    }

    public function actions(): array
    {
        $actions = [];
        if ($this->order->paid_amount !== $this->order->total_amount) {
            $actions = [
                (new Delete)->after(fn ($model) => $this->emit('paymentDeleted', $model))
            ];
        }

        return $actions;
    }
}
