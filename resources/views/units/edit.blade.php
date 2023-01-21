<x-app-layout>
    <x-slot name="title">
        {{ $unit->label }}
    </x-slot>

    <x-content>
        <livewire:units.unit-form :unit="$unit" />
    </x-content>
</x-app-layout>
