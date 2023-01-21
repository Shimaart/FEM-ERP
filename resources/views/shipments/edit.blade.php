<x-app-layout>
    <x-slot name="title">
        {{ __('Отгрузка №:number', ['number' => $shipment->id]) }}
    </x-slot>

    <x-content>
        <livewire:shipments.shipment-form :shipment="$shipment" />

        <!-- Payments -->
{{--        <livewire:shipments.payments-manager :payable="$shipment" />--}}
    </x-content>
</x-app-layout>
