<x-livewire.comments.comments-manager>
    <x-slot name="title">
        {{ __('История работы с заказом') }}
    </x-slot>

    <x-slot name="table">
        <livewire:orders.order-comments-table :order="$order" />
    </x-slot>
</x-livewire.comments.comments-manager>
