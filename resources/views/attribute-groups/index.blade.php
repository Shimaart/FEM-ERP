<x-app-layout>
    <x-slot name="title">
        {{ __('Группы атрибутов') }}
    </x-slot>

    <x-slot name="tools">
        <x-create-link href="{{ route('attribute-groups.create') }}" />
    </x-slot>

    <x-content>
        <livewire:attribute-groups.attribute-groups-table />
    </x-content>
</x-app-layout>
