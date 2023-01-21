<x-app-layout>
    <x-slot name="title">
        {{ __('Необходимо произвести') }}
    </x-slot>

    <x-content>
        <livewire:production-requests.production-requests-table />
    </x-content>
</x-app-layout>
