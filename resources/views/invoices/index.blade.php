<x-app-layout>
    <x-slot name="title">
        {{ __('Счета') }}
    </x-slot>

    <x-content>
        <livewire:invoices.invoices-table />
    </x-content>
</x-app-layout>
