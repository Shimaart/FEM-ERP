<x-app-layout>
    <x-slot name="title">
        {{ __('Типы продукции') }}
    </x-slot>

    <x-slot name="tools">
        <x-create-link href="{{ route('item-categories.create') }}" />
    </x-slot>

    <x-content>
        <livewire:item-categories.item-categories-table />
    </x-content>
</x-app-layout>
