<x-app-layout>
    <x-slot name="title">
        {{ __('Статьи затрат') }}
    </x-slot>

    <x-slot name="tools">
        <x-create-link href="{{ route('cost-items.create') }}" />
    </x-slot>

    <x-content>
        <livewire:cost-items.cost-items-table />
    </x-content>
</x-app-layout>
