<x-app-layout>
    <x-slot name="title">
        {{ __('Касса безналичная') }}
    </x-slot>

    <x-content>
        <livewire:payments.payments-cashless-statistics />
    </x-content>
</x-app-layout>
