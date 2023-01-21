<x-app-layout>
    <x-slot name="title">
        {{ __('Пользователи') }}
    </x-slot>

    <x-slot name="tools">
        <x-create-link href="{{ route('users.create') }}" />
    </x-slot>

    <x-content>
        <livewire:users.users-table />
    </x-content>
</x-app-layout>
