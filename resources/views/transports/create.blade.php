<x-app-layout>
    <x-slot name="title">
        {{ __('Новый транспорт') }}
    </x-slot>

    <x-content>
        <livewire:transports.transport-form />
    </x-content>
</x-app-layout>
