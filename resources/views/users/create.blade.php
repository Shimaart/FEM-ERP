<x-app-layout>
    <x-slot name="title">
        {{ __('Новый пользователь') }}
    </x-slot>

    <x-content>
        <livewire:users.user-form />
    </x-content>
</x-app-layout>
