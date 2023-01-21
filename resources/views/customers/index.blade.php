<x-app-layout>
    <x-slot name="title">
        {{ __('Контрагенты') }}
    </x-slot>

    <x-slot name="tools">
        <x-create-link href="{{ route('customers.create') }}" />
    </x-slot>

    <x-content>
        <livewire:customers.customers-table />
    </x-content>
</x-app-layout>
