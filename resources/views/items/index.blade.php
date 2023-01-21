<x-app-layout>
    <x-slot name="title">
        {{ __('Склад') }}
    </x-slot>

    <x-slot name="tools">
        <livewire:items.create-item-button />
    </x-slot>

    <x-content>
        <livewire:items.items-table />
    </x-content>
</x-app-layout>
