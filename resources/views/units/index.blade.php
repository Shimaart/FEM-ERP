<x-app-layout>
    <x-slot name="title">
        {{ __('Еденицы измерения') }}
    </x-slot>

    <x-slot name="tools">
        <x-create-link href="{{ route('units.create') }}" />
    </x-slot>

    <x-content>
        <livewire:units.units-table />
    </x-content>
</x-app-layout>
