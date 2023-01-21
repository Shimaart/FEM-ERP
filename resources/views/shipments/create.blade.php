<x-app-layout>
    <x-slot name="title">
        {{ __('Новая отгрузка') }}
    </x-slot>

    <x-content>
        <livewire:shipments.shipment-form />
    </x-content>
</x-app-layout>
