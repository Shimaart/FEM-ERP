<x-app-layout>
    <x-slot name="title">
        {{ __('Производство') }}
    </x-slot>

    <x-slot name="tools">
        <x-create-link href="{{ route('productions.create') }}" />
    </x-slot>

    <x-content>
        <livewire:productions.productions-table />
    </x-content>
</x-app-layout>
