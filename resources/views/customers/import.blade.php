<x-app-layout>
    <x-slot name="title">
        {{ __('Импорт контрагентов') }}
    </x-slot>

    <x-content>
        <livewire:customers.import-form />
    </x-content>
</x-app-layout>
