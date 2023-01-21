<x-app-layout>
    <x-slot name="title">
        {{ $itemCategory->name }}
    </x-slot>

    <x-content>
        <livewire:item-categories.item-category-form :item-category="$itemCategory" />
    </x-content>
</x-app-layout>
