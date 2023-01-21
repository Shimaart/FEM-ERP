<?php

namespace App\Http\Livewire\Payments;

use App\Models\Payment;
use Karvaka\Wired\Table\Actions\Delete;
use Karvaka\Wired\Table\Columns\Column;
use Karvaka\Wired\Table\Columns\DateTime;
use Karvaka\Wired\Table\Columns\Enum;
use Karvaka\Wired\Table\Columns\Number;
use Karvaka\Wired\Table\Components\Table;
use Karvaka\Wired\Table\Links\Edit;
use Karvaka\Wired\Table\Tabs\Tab;

class PaymentsTable extends Table
{
    protected string $defaultSort = '-created_at';

    protected $listeners = [
        'paymentSaved' => '$refresh',
    ];

    public function columns(): array
    {
        return [
            Column::make('id', __('Номер'))->sortable(),
            DateTime::make('created_at', __('Дата'))->sortable(),
            Column::make('paymentable.number', __('Номер заказа'))->visible($this->tab === 'income'),
            Column::make('paymentable.name', __('Статья затрат'))->visible($this->tab === 'expense'),
            Enum::make('payment_type', __('Рассчет'))
                ->values(Payment::paymentTypeOptions())
                ->sortable(),
            Enum::make('status', __('Статус'))
                ->values(Payment::statusOptions())
                ->sortable(),
            Number::make('abs_amount', __('Сумма'))->sortable()
        ];
    }

    public function tabs(): array
    {
        return [
            Tab::make('expense', __('Расходы'))->filterUsing(fn($query) => $query->expense()),
            Tab::make('income', __('Доходы'))->filterUsing(fn($query) => $query->income()),
        ];
    }

    public function filters(): array
    {
        return [];
    }

    public function links(): array
    {
        return [
            (new Edit)->emit('managePayment')->visible($this->tab === 'expense')
        ];
    }

    public function actions(): array
    {
        return [
            (new Delete)->visible($this->tab === 'expense')
        ];
    }

//    public function tabSwitched(): void
//    {
//        parent::tabSwitched();
//
//        $this->emitUp('tabSwitched');
//    }
}
