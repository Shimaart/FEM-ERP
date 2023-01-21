<?php

namespace App\Http\Livewire;

use App\Models\Lead;
use App\Models\Order;
use App\Models\Production;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Laravel\Jetstream\Http\Livewire\NavigationMenu;

class Navigation extends NavigationMenu
{
    public function links(): array
    {
        return [
            NavigationLink::make(__('Пользователи'))->resource('users'),
            NavigationLink::make(__('Склад'))
                ->items([
                    NavigationLink::make(__('Продукция'))->resource('items'),
                    NavigationLink::make(__('Еденицы измерения'))->resource('units'),
                    NavigationLink::make(__('Категории продукции'))->resource('item-categories'),
                    NavigationLink::make(__('Типы продукции'))->resource('item-types'),
                    NavigationLink::make(__('Группы атрибутов'))->resource('attribute-groups'),
                ]),
            NavigationLink::make(__('Продажи'))
                ->items([
                    NavigationLink::make(__('Лиды'))
                        ->resource('leads')
                        ->badge($this->assignedLeadsCount())
                        ->visible(Gate::allows('viewAny', Lead::class)),
                    NavigationLink::make(__('Заказы'))
                        ->resource('orders')
                        ->visible(Gate::allows('viewAny', Order::class)),
                    // NavigationLink::make(__('Счета'))->resource('invoices'),
                    NavigationLink::make(__('Касса'))->url(route('payments.statistics')),
                    NavigationLink::make(__('Платежи'))->resource('payments'),
                    NavigationLink::make(__('Статьи затрат'))->resource('cost-items'),
                    NavigationLink::make(__('Возвраты'))->resource('refunds'),
                    NavigationLink::make(__('Контрагенты'))->resource('customers'),
                    NavigationLink::make(__('Поставщики'))->resource('suppliers'),
                ]),
            NavigationLink::make(__('Производство'))
                ->items([
                    NavigationLink::make(__('Необходимо произвести'))->resource('production-requests'),
                    NavigationLink::make(__('Задачи'))
                        ->resource('productions')
                        ->visible(Gate::allows('viewAny', Production::class)),
                ]),
            NavigationLink::make(__('Отгрузка'))
                ->items([
                    NavigationLink::make(__('Задачи'))->resource('shipments'),
                    NavigationLink::make(__('Транспорт'))->resource('transports'),
                ])
        ];
    }

    private function assignedLeadsCount()
    {
        return Lead::query()->highlightedFor(Auth::user())->count();
    }

    public function render()
    {
        return view('navigation')->with([
            'links' => $this->links()
        ]);
    }
}
