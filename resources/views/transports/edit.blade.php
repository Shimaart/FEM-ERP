<x-app-layout>
    <x-slot name="title">
        {{ $transport->name }}
    </x-slot>

    <x-content>
        <livewire:transports.transport-form :transport="$transport" />
    </x-content>
</x-app-layout>
