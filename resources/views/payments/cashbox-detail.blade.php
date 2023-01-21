<x-app-layout>
    <x-slot name="title">
        {{ __('Касса подробно') }}
    </x-slot>

    <x-content>
        <livewire:payments.cashbox-detail :type="$type" :periodFrom="$periodFrom" :periodTo="$periodTo" />
    </x-content>
</x-app-layout>
