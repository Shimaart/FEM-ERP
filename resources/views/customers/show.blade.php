<x-app-layout>
    <x-slot name="title">
        {{ $customer->name }}
    </x-slot>

    <x-content>
        <livewire:customers.customer-form :customer="$customer" />

        <div class="mt-6">
            <div class="py-5 sm:pb-3">
                <h3 class="text-xl font-medium text-gray-900">{{ __('Сделки') }}</h3>
            </div>
            <livewire:customers.customer-leads-table :customer="$customer" />
        </div>
    </x-content>
</x-app-layout>
