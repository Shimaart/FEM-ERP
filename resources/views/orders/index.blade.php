<x-app-layout>
    <x-slot name="title">
        {{ __('Заказы') }}
    </x-slot>

    <x-slot name="tools">
        <x-create-link href="{{ route('orders.create') }}" />
    </x-slot>

    <x-content>
        <livewire:orders.orders-table />
    </x-content>
</x-app-layout>
