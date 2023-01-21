<x-app-layout>
    <x-slot name="title">
        {{ __('Группа атрибутов: :name', ['name' => $attributeGroup->name]) }}
    </x-slot>

    <x-content>
        <livewire:attribute-groups.attribute-group-form :attribute-group="$attributeGroup" />

        <div class="mt-6">
            <livewire:attribute-groups.attributes-manager :attribute-group="$attributeGroup" />
        </div>
    </x-content>
</x-app-layout>
