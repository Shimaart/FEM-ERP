<x-app-layout>
    <x-slot name="title">
        {{ __('Поставщики') }}
    </x-slot>

    <x-slot name="tools">
        <x-create-link href="{{ route('suppliers.create') }}" />
    </x-slot>

    <x-content>
        <livewire:suppliers.suppliers-table />
    </x-content>
</x-app-layout>
