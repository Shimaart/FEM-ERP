<x-app-layout>
    <x-slot name="title">
        {{ __('Задача на производство №:number', ['number' => $production->id]) }}
    </x-slot>

    <x-content>
        <livewire:productions.production-form :production="$production" />
    </x-content>
</x-app-layout>
