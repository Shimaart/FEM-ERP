<div>
    <div class="flex justify-between items-center py-5 sm:pb-3">
        @can('create', \App\Models\Item::class)

        @endcan

        <x-jet-button class="ml-2" wire:click="manageSimilarItem" wire:loading.attr="disabled">
            <x-heroicon-o-plus class="-ml-1 mr-2 h-4 w-4" />
            {{ __('Добавить аналог') }}
        </x-jet-button>
    </div>


    <!-- Order Comment Form Modal -->
    <x-jet-dialog-modal wire:model="managingSimilarItem">
        <x-slot name="title">
            {{ __('Добавление аналога') }}
        </x-slot>

        <x-slot name="content">
            <form wire:submit="manageSimilarItem">
                @if ($groups->count())
                    <hr>
                    {{--            <div class="px-4 py-5 bg-grey sm:p-6">--}}
                    {{--                <div class="bg-grey uppercase">Атрибуты</div>--}}
                    {{--            </div>--}}

                    <div class="py-5">
                        <div class="grid grid-cols-6 gap-6">
                            @foreach($groups as $index => $group)
                                <div class="col-span-6 sm:col-span-2">
                                    <x-jet-label for="unit_id" value="{{ $group->name }}" />
                                    <select class="form-input rounded-md shadow-sm block w-full" wire:model="selectedAttributes.{{ $group->id }}">
                                        <option value="">{{ __('') }}</option>
                                        @foreach($group->attributes as $attribute)
                                            <option value="{{ $attribute->id }}">{{ $attribute->name }}</option>
                                        @endforeach
                                    </select>
                                    <x-jet-input-error for="selectedAttributes.{{ $group->id }}" class="mt-2" />
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <hr>
                @endif
                <div class="grid grid-cols-6 gap-6">
                    <!-- Unit -->
                    <div class="col-span-6 sm:col-span-2">
                        <!-- Name -->
                        <x-jet-label for="similar-price" value="{{ __('Цена') }}" />
                        <x-jet-input id="similar-price" type="text" class="mt-1 block w-full" wire:model.defer="similarItem.price" />
                        <x-jet-input-error for="similarItem.price" class="mt-2" />
                    </div>
                    <div class="col-span-6 sm:col-span-2">
                        <!-- Name -->
                        <x-jet-label for="similar-quantity" value="{{ __('Количество') }}" />
                        <x-jet-input id="similar-quantity" type="text" class="mt-1 block w-full" wire:model.defer="similarItem.quantity" />
                        <x-jet-input-error for="similarItem.quantity" class="mt-2" />
                    </div>
                    <div class="col-span-6 sm:col-span-2">
                        <!-- Name -->
                        <x-jet-label for="similar-vendor_code" value="{{ __('Артикул') }}" />
                        <x-jet-input id="similar-vendor_code" type="text" class="mt-1 block w-full" wire:model.defer="similarItem.vendor_code" />
                        <x-jet-input-error for="similarItem.vendor_code" class="mt-2" />
                    </div>
                    @if( $item->category_id === 1)
                        <div class="col-span-6 sm:col-span-2">
                            <!-- Name -->
                            <x-jet-label for="cost_price" value="{{ __('Себестоимость') }}" />
                            <x-jet-input id="cost_price" type="text" class="mt-1 block w-full" wire:model.defer="similarItem.cost_price" />
                            <x-jet-input-error for="similarItem.cost_price" class="mt-2" />
                        </div>
                    @endif
                    @if( $item->category_id === 3)
                        <div class="col-span-6 sm:col-span-2">
                            <!-- Name -->
                            <x-jet-label for="purchase_price" value="{{ __('Стоимость закупки') }}" />
                            <x-jet-input id="purchase_price" type="text" class="mt-1 block w-full" wire:model.defer="similarItem.purchase_price" />
                            <x-jet-input-error for="similarItem.purchase_price" class="mt-2" />
                        </div>
                    @endif
                </div>
            </form>
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$set('managingSimilarItem', false)" wire:loading.attr="disabled">
                {{ __('Nevermind') }}
            </x-jet-secondary-button>

            <x-jet-button class="ml-2" wire:click="saveSimilarItem" wire:loading.attr="disabled">
                {{ __('Save') }}
            </x-jet-button>
        </x-slot>
    </x-jet-dialog-modal>
</div>
