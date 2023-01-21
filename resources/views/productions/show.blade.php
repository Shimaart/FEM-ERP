<x-app-layout>
    <x-slot name="title">
        {{ $production->status === \App\Models\Production::STATUS_DRAFTED ? __('Новая задача на производство ') : __('Задача на производство  №:number', ['number' => $production->id]) }}
    </x-slot>

    <x-content>
        <div class="py-5 pb-1">
            <h3 class="text-xl font-medium text-gray-900">{{ __('Данные задачи') }}</h3>
        </div>

        <div class="py-5 pb-1">
{{--            <livewire:production-requests-table/>--}}
        </div>

        <livewire:productions.production-form :production="$production" />
    </x-content>
</x-app-layout>
