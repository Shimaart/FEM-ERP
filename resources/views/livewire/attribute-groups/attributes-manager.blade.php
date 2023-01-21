<div>
    <div class="flex justify-between items-center py-5 sm:pb-3">
        <h3 class="text-xl font-medium text-gray-900">{{ __('Атрибуты') }}</h3>

        <x-create-button wire:click="manageAttribute" wire:loading.attr="disabled" />
    </div>

    <livewire:attribute-groups.attributes-table :attribute-group="$attributeGroup" />

    <x-jet-dialog-modal wire:model="managingAttribute">
        <x-slot name="title">
            {{ __('Добавление атрибута') }}
        </x-slot>

        <x-slot name="content">
            @if($managedAttribute)
                <form wire:submit="saveAttribute">
                    <div class="grid grid-cols-6 gap-6">
                        <div class="col-span-6 sm:col-span-3">
                            <x-jet-label for="attribute-name" value="{{ __('Название') }}" />
                            <div class="flex justify-content-between items-center mt-1">
                                <x-jet-input id="attribute-name" type="text" min="0" class="block w-full" wire:model="managedAttribute.name" />
                            </div>
                            <x-jet-input-error for="managedAttribute.name" class="mt-2" />
                        </div>
                    </div>
                </form>
            @endif
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button type="button" wire:click="$set('managingAttribute', false)" wire:loading.attr="disabled">
                {{ __('Nevermind') }}
            </x-jet-secondary-button>

            <x-jet-button type="button" class="ml-2" wire:click="saveAttribute" wire:loading.attr="disabled">
                {{ __('Save') }}
            </x-jet-button>
        </x-slot>
    </x-jet-dialog-modal>
</div>
