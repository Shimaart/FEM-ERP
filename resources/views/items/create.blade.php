<x-app-layout>
    <x-slot name="title">
        {{ __('Новый продукт') }}
    </x-slot>

    <x-content>
        <livewire:items.item-create-form />
    </x-content>
</x-app-layout>
