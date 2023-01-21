<div>
    <div class="flex justify-between items-center py-5 sm:pb-3">
        <h3 class="text-xl font-medium text-gray-900">{{ __('Группы атрибутов') }}</h3>

        <x-jet-button type="button" class="ml-2" wire:click="manageItemTypeGroup" wire:loading.attr="disabled">
            <x-heroicon-o-plus class="-ml-1 mr-2 h-4 w-4" />
            {{ __('Добавить') }}
        </x-jet-button>
    </div>

    <livewire:item-types.item-type-groups-table :item-type="$itemType" />

    <!-- Order Comment Form Modal -->
    <x-jet-dialog-modal wire:model="managingItemTypeGroup">
        <x-slot name="title">
            {{ __('Добавление группы атрибутов') }}
        </x-slot>

        <x-slot name="content">
            <form wire:submit="saveItemTypeGroup">
                <div class="grid grid-cols-6 gap-6">
                    <div class="col-span-6 sm:col-span-4">
                        <x-jet-label for="group_id" value="{{ __('Группа') }}" />
                        <select class="form-input rounded-md shadow-sm block w-full" wire:model="managedItemTypeGroup.group_id">
                            <option value="">{{ __('') }}</option>
                            @foreach($this->groups as $group)
                                <option value="{{ $group->id }}">{{ $group->name }}</option>
                            @endforeach
                        </select>
                        <x-jet-input-error for="managedItemTypeGroup.group_id" class="mt-2" />
                    </div>

                    <div class="col-span-6 sm:col-span-4">
                        <label class="inline-flex items-center">
                            <input type="checkbox" class="form-checkbox h-5 w-5 text-gray-600" wire:model="managedItemTypeGroup.is_main">
                            <span class="ml-2 text-gray-700">{{ __('Основной')}}</span>
                        </label>
                        <x-jet-input-error for="managedItemTypeGroup.is_main" class="mt-2" />
                    </div>
                </div>
            </form>
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button type="button" wire:click="$set('managingItemTypeGroup', false)" wire:loading.attr="disabled">
                {{ __('Nevermind') }}
            </x-jet-secondary-button>

            <x-jet-button  type="button" class="ml-2" wire:click="saveItemTypeGroup" wire:loading.attr="disabled">
                {{ __('Save') }}
            </x-jet-button>
        </x-slot>
    </x-jet-dialog-modal>
</div>
