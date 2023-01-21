<x-app-layout>
    <x-slot name="title">
        {{ __('Типы продукции') }}
    </x-slot>

    <x-slot name="tools">
        <x-create-link href="{{ route('item-types.create') }}" />
    </x-slot>

    <x-content>
        <livewire:item-types.item-types-table />
    </x-content>
</x-app-layout>
