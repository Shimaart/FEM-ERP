<x-app-layout>
    <x-slot name="title">
        {{ __('Лиды') }}
    </x-slot>

    <x-slot name="tools">
        <x-create-link href="{{ route('leads.create') }}" />
    </x-slot>

    <x-content>
        <livewire:leads.leads-table />
    </x-content>
</x-app-layout>
