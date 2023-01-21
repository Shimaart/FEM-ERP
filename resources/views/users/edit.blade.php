<x-app-layout>
    <x-slot name="title">
        {{ $user->name }}
    </x-slot>

    <x-slot name="tools">
        <a href="{{ route('users.index', ['page' => request()->query('page')]) }}"
           class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            <x-heroicon-o-chevron-left class="-ml-1 mr-2 h-5 w-5 text-gray-500" />
            {{ __('К списку') }}
        </a>
    </x-slot>

    <x-content>
        <livewire:users.user-form :user="$user" />
    </x-content>
</x-app-layout>
