<x-app-layout>
    <x-slot name="title">
        {{ $costItem->name }}
    </x-slot>

    <x-content>
        <livewire:cost-items.cost-item-form :cost-item="$costItem" />
    </x-content>
</x-app-layout>
