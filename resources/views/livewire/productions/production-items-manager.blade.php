<div>
    <div class="flex justify-between items-center py-5 sm:pb-3">
        <h3 class="text-xl font-medium text-gray-900">{{ $category ? $category->name : __('Продукция') }}</h3>

        <x-jet-button type="button" class="ml-2" wire:click="manageProductionItem" wire:loading.attr="disabled">
            <x-heroicon-o-plus class="-ml-1 mr-2 h-4 w-4" />
            {{ __('Добавить продукцию') }}
        </x-jet-button>
    </div>

    <livewire:productions.production-items-table :production="$production" :category="$category" />

    <!-- Production Item Form Modal -->
    <x-jet-dialog-modal wire:model="managingProductionItem">
        <x-slot name="title">
            {{ __('Добавление продукции к заказу') }}
        </x-slot>

        <x-slot name="content">
            @if($managedProductionItem)
                <form wire:submit="saveProductionItem">
                    <div class="grid grid-cols-6 gap-6">
                        <div class="col-span-6 sm:col-span-4">
                            <x-jet-label for="item_id" value="{{ __('Продукция') }}" />
                            <select class="form-input rounded-md shadow-sm block w-full" wire:model="managedProductionItem.item_id">
                                <option value="">{{ __('') }}</option>
                                @foreach($this->items as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                            <x-jet-input-error for="managedProductionItem.item_id" class="mt-2" />
                        </div>
                        <div class="col-span-6 sm:col-span-3">
                            <x-jet-label for="need_quantity" value="{{ __('Количество') }}" />
                            <div class="flex justify-content-between items-center mt-1">
                                <x-jet-input id="need_quantity" type="number" min="0" class="block w-full" wire:model="managedProductionItem.need_quantity" />
                                @if($managedProductionItem->item)
                                    <div class="ml-2">
                                        {{ $managedProductionItem->item->unit->symbol }}
                                    </div>
                                @endif
                            </div>
                            <x-jet-input-error for="managedProductionItem.need_quantity" class="mt-2" />
                        </div>
                    </div>
                </form>
            @endif
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button type="button" wire:click="$set('managingProductionItem', false)" wire:loading.attr="disabled">
                {{ __('Nevermind') }}
            </x-jet-secondary-button>

            <x-jet-button type="button" class="ml-2" wire:click="saveProductionItem" wire:loading.attr="disabled">
                {{ __('Save') }}
            </x-jet-button>
        </x-slot>
    </x-jet-dialog-modal>
</div>
