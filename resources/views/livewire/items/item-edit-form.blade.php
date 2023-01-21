<form wire:submit.prevent="submit">
    <div class="shadow overflow-hidden sm:rounded-md">
        <div class="px-4 py-5 bg-white sm:p-6">
            <div class="grid grid-cols-6 gap-6">
                <div class="col-span-6 sm:col-span-2">
                    <!-- Name -->
                    <x-jet-label for="name" value="{{ __('Название') }}" />
                    <p class="pt-4">{{$item->name}}</p>
                </div>
                <div class="col-span-6 sm:col-span-2">
                    <!-- Name -->
                    <x-jet-label for="vendor_code" value="{{ __('Артикул') }}" />
                    <x-jet-input id="vendor_code" type="text" class="mt-1 block w-full" wire:model.defer="item.vendor_code" />
                    <x-jet-input-error for="item.vendor_code" class="mt-2" />
                </div>
            </div>
        </div>

        <div class="px-4 py-5 bg-white sm:p-6">
            <div class="grid grid-cols-6 gap-6">
                <!-- Customer -->
                <div class="col-span-6 sm:col-span-2">
                    <x-jet-label for="item_type_id" value="{{ __('Тип продукции') }}" />
                    <p class="pt-4">{{$item->itemType->name}}</p>
                </div>

                <!-- Unit -->
                <div class="col-span-6 sm:col-span-2">
                    <x-jet-label for="unit_id" value="{{ __('Ед. изм.') }}" />
                    <select class="form-input rounded-md shadow-sm block w-full" wire:model.defer="item.unit_id">
                        <option value="">{{ __('') }}</option>
                        @foreach($this->units as $unit)
                            <option value="{{ $unit->id }}">{{ $unit->symbol }}</option>
                        @endforeach
                    </select>
                    <x-jet-input-error for="item.unit_id" class="mt-2" />
                </div>
                @if( $item->category_id === 1)
                    <div class="col-span-6 sm:col-span-2">
                        <!-- Name -->
                        <x-jet-label for="cost_price" value="{{ __('Себестоимость') }}" />
                        <x-jet-input id="cost_price" type="text" class="mt-1 block w-full" wire:model.defer="item.cost_price" />
                        <x-jet-input-error for="item.cost_price" class="mt-2" />
                    </div>
                @endif
                @if( $item->category_id === 3)
                    <div class="col-span-6 sm:col-span-2">
                        <!-- Name -->
                        <x-jet-label for="purchase_price" value="{{ __('Стоимость закупки') }}" />
                        <x-jet-input id="purchase_price" type="text" class="mt-1 block w-full" wire:model.defer="item.purchase_price" />
                        <x-jet-input-error for="item.purchase_price" class="mt-2" />
                    </div>
                @endif
                @if( $item->category_id === 5)
                    <div class="col-span-6 sm:col-span-2">
                        <!-- Name -->
                        <x-jet-label for="return_price" value="{{ __('Стоимость возврата') }}" />
                        <x-jet-input id="return_price" type="text" class="mt-1 block w-full" wire:model.defer="item.return_price" />
                        <x-jet-input-error for="item.return_price" class="mt-2" />
                    </div>
                @endif
            </div>
        </div>



        @if ($groups && $groups->count())
            <hr>
            {{--            <div class="px-4 py-5 bg-grey sm:p-6">--}}
            {{--                <div class="bg-grey uppercase">Атрибуты</div>--}}
            {{--            </div>--}}

            <div class="px-4 py-5 bg-white sm:p-6">
                <div class="grid grid-cols-6 gap-6">
                    @foreach($groups as $index => $group)
                        <div class="col-span-6 sm:col-span-2">
                            <x-jet-label for="unit_id" value="{{ $group->name }}" />
                                @foreach($group->attributes as $attribute)
                                    @if($selectedAttributes[$group->id] == $attribute->id)
                                        <p class="pt-4">{{$attribute->name}}</p>
                                    @endif
                                @endforeach
                        </div>
                    @endforeach
                </div>
            </div>
            <hr>
        @endif

        <div class="px-4 py-5 bg-white sm:p-6">
            <div class="grid grid-cols-6 gap-6">
                <!-- Unit -->
                <div class="col-span-6 sm:col-span-2">
                    <!-- Name -->
                    <x-jet-label for="price" value="{{ __('Цена') }}" />
                    <x-jet-input id="price" type="text" class="mt-1 block w-full" wire:model.defer="item.price" />
                    <x-jet-input-error for="item.price" class="mt-2" />
                </div>
                <div class="col-span-6 sm:col-span-2">
                    <!-- Name -->
                    <x-jet-label for="quantity" value="{{ __('Количество') }}" />
                    <x-jet-input id="quantity" type="text" class="mt-1 block w-full" wire:model.defer="item.quantity" />
                    <x-jet-input-error for="item.quantity" class="mt-2" />
                </div>
                <div class="col-span-6 sm:col-span-2">
                    <!-- Name -->
                    <x-jet-label for="weight" value="{{ __('Вес') }}" />
                    <x-jet-input id="weight" type="text" class="mt-1 block w-full" wire:model.defer="item.weight" />
                    <x-jet-input-error for="item.weight" class="mt-2" />
                </div>
            </div>
        </div>

        @if ($similarItems && $groups && $groups->count())
            <hr>
            <div class="flex justify-between pl-3 items-center py-5 sm:pb-3">
                <h3 class="text-xl font-medium text-gray-900">{{ __('Аналоги') }}</h3>
            </div>
            <div class="mt-6">
                <livewire:items.item-similar-manager :item="$item" />
            </div>

            <x-livewire.items.similar-items :similar-items="$similarItems" :groups="$groups" :colspan-value="$colspanValue" />
            {{--            <x-livewire.items.similar-items :similar-items="$similarItems" :optional-group="$optionalGroup" />--}}

            <hr>
        @endif

        <div class="flex items-center justify-end px-4 py-3 bg-gray-50 text-right sm:px-6">
            <x-jet-action-message class="mr-3" on="saved">
                {{ __('Saved.') }}
            </x-jet-action-message>

            <x-jet-button>
                {{ __('Save') }}
            </x-jet-button>
        </div>
    </div>
</form>
