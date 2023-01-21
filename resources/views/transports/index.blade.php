<x-app-layout>
    <x-slot name="title">
        {{ __('Транспорт') }}
    </x-slot>

    <x-slot name="tools">
        <x-create-link href="{{ route('transports.create') }}" />
    </x-slot>

    <x-content>
        <livewire:transports.transports-table />
    </x-content>
</x-app-layout>
