<x-app-layout>
    <x-slot name="title">
        {{ __('Касса наличная') }}
    </x-slot>

    <x-content>
        <livewire:payments.payments-cash-statistics />
    </x-content>
</x-app-layout>
