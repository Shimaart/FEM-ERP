<x-app-layout>
    <x-slot name="title">
        {{ $supplier->name }}
    </x-slot>

    <x-content>
        <livewire:suppliers.supplier-form :supplier="$supplier" />
    </x-content>
</x-app-layout>
