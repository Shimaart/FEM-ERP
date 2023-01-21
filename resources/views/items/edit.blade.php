<x-app-layout>
    <x-slot name="title">
        {{ $item->name }}
    </x-slot>

    <x-content>
        <livewire:items.item-edit-form :item="$item" />
    </x-content>
</x-app-layout>
