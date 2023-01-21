<x-app-layout>
    <x-slot name="title">
        {{ $itemType->name }}
    </x-slot>

    <x-content>
        <livewire:item-types.item-type-form :item-type="$itemType" />

        <div class="mt-6">
            <livewire:item-types.item-type-groups-manager :item-type="$itemType" />
        </div>
    </x-content>
</x-app-layout>
