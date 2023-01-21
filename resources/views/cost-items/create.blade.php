<x-app-layout>
    <x-slot name="title">
        {{ __('Новая статья затрат') }}
    </x-slot>

    <x-content>
        <livewire:cost-items.cost-item-form />
    </x-content>
</x-app-layout>
