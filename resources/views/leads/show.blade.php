<x-app-layout>
    <x-slot name="title">
        {{ __('Лид') }} {{ $lead->name }}
    </x-slot>

    <x-content>
        <livewire:leads.lead-form :lead="$lead" />

        <div class="mt-6">
            <livewire:media.uploader :model="$lead" collection="attachments" />
        </div>

        <div class="mt-6">
            <livewire:media.collection :model="$lead" collection="attachments" />
        </div>

        <div class="mt-6">
            <livewire:leads.lead-comments-manager :lead="$lead" />
        </div>
    </x-content>
</x-app-layout>
