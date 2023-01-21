<x-livewire.comments.comments-manager>
    <x-slot name="title">
        {{ __('История работы с лидом') }}
    </x-slot>

    <x-slot name="table">
        <livewire:leads.lead-comments-table :lead="$lead" />
    </x-slot>
</x-livewire.comments.comments-manager>
