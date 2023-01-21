<x-app-layout>
    <x-slot name="title">
        {{ $order->status === \App\Models\Order::STATUS_DRAFTED ? __('Новый заказ') : __('Заказ №:number', ['number' => $order->number]) }}
    </x-slot>

    <x-content>

        <div class="flex items-center justify-end space-x-2">
            <livewire:orders.order-documents-contract :order="$order" />

            <x-jet-button type="button" onclick="window.print()">
                <x-heroicon-o-printer class="-ml-1 mr-2 h-4 w-4" />
                {{ __('Печать') }}
            </x-jet-button>
        </div>


        <div class="py-5 pb-1">
            <h3 class="text-xl font-medium text-gray-900">{{ __('Данные заказа') }}</h3>
        </div>

        <livewire:orders.order-form :order="$order" />

        @if($order->lead)
            <div class="mt-6">
                <livewire:media.collection :model="$order->lead" collection="attachments" />
            </div>
        @endif

        @foreach(\App\Models\ItemCategory::query()->where('display_in_orders', true)->get() as $category)
            <div class="mt-6">
                <livewire:orders.order-items-manager :order="$order" :category="$category" :key="$category->id" />
            </div>
        @endforeach

        <div class="mt-6">
            <livewire:orders.order-shipments-manager :order="$order" />
        </div>

        <div class="mt-6">
            <livewire:orders.order-refunds-manager :order="$order" />
        </div>

        <div class="mt-6">
            <livewire:orders.order-payments-manager :order="$order" />
        </div>

        <div class="mt-6">
            <livewire:orders.order-comments-manager :order="$order" />
        </div>

    </x-content>
</x-app-layout>
