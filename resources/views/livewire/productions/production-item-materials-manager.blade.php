<div>
    <div class="flex justify-end items-center py-5 sm:pb-3">
        <x-jet-button type="button" class="ml-2" wire:click="manageConsumedMaterial" wire:loading.attr="disabled">
            <x-heroicon-o-plus class="h-4 w-4" />
        </x-jet-button>
        <x-jet-button type="button" class="ml-2" wire:click="$set('updatingConsumedMaterial', true)" wire:loading.attr="disabled">
            <x-heroicon-o-pencil class="h-4 w-4" />
        </x-jet-button>
    </div>

{{--    <livewire:productions.production-item-materials-table :production-item="$productionItem" />--}}


    <!-- Order Item Form Modal -->
    <x-jet-dialog-modal wire:model="managingConsumedMaterial">
        <x-slot name="title">
            {{ __('Добавление израсходованного материала') }}
        </x-slot>

        <x-slot name="content">
            @if($managedConsumedMaterial)
                <form wire:submit="saveConsumedMaterial">
                    <div class="grid grid-cols-6 gap-6">
                        <div class="col-span-6 sm:col-span-4">
                            <x-jet-label for="material_id" value="{{ __('Продукция') }}" />
                            <select class="form-input rounded-md shadow-sm block w-full" wire:model="managedConsumedMaterial.material_id">
                                <option value="">{{ __('') }}</option>
                                @foreach($this->items as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                            <x-jet-input-error for="managedConsumedMaterial.material_id" class="mt-2" />
                        </div>
                        <div class="col-span-6 sm:col-span-2">
                            <x-jet-label for="quantity" value="{{ __('Количество') }}" />
                            <div class="flex justify-content-between items-center mt-1">
                                <x-jet-input id="quantity" type="number" min="0" class="block w-full" wire:model="managedConsumedMaterial.value" />
                                @if($managedConsumedMaterial->material)
                                    <div class="ml-2">
                                        {{ $managedConsumedMaterial->material->unit->symbol }}
                                    </div>
                                @endif
                            </div>
                            <x-jet-input-error for="managedConsumedMaterial.value" class="mt-2" />
                        </div>
                    </div>
                </form>
            @endif
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$set('managingConsumedMaterial', false)" wire:loading.attr="disabled">
                {{ __('Nevermind') }}
            </x-jet-secondary-button>

            <x-jet-button type="button" class="ml-2" wire:click="saveConsumedMaterial" wire:loading.attr="disabled">
                {{ __('Save') }}
            </x-jet-button>
        </x-slot>
    </x-jet-dialog-modal>


    <x-jet-dialog-modal wire:model="updatingConsumedMaterial">
        <x-slot name="title">
            {{ __('Редактирование израсходованных материалов') }}
        </x-slot>

        <x-slot name="content">
            <livewire:productions.production-item-materials-table :production-item="$productionItem" />
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$set('updatingConsumedMaterial', false)" wire:loading.attr="disabled">
                {{ __('Nevermind') }}
            </x-jet-secondary-button>

        </x-slot>
    </x-jet-dialog-modal>
</div>
