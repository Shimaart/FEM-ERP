<x-app-layout>
    <x-slot name="title">
        {{ __('Новая задача') }}
    </x-slot>

    <x-content>
        <livewire:productions.create-production-form :production="$production" />
    </x-content>
</x-app-layout>
