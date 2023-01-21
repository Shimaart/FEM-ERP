<form wire:submit.prevent="submit">
    <div class="shadow overflow-hidden sm:rounded-md">
        <div class="px-4 py-5 bg-white sm:p-6">
            <div class="grid grid-cols-6 gap-6">
                <div class="col-span-6 sm:col-span-2">
                    <!-- Name -->
                    <x-jet-label for="name" value="{{ __('Название') }}" />
                    <x-jet-input id="name" type="text" class="mt-1 block w-full" wire:model.defer="item.name" />
                    <x-jet-input-error for="item.name" class="mt-2" />
                    <p class="text-sm text-gray-500">{{ __('Формируется на основании выбранных атрибутов.') }}</p>
                </div>
            </div>
        </div>

        <div class="px-4 py-5 bg-white sm:p-6">
            <div class="grid grid-cols-6 gap-6">
                <!-- Customer -->
                <div class="col-span-6 sm:col-span-2">
                    <x-jet-label for="item_type_id" value="{{ __('Тип продукции') }}" />
                    <select class="form-input rounded-md shadow-sm block w-full" wire:model="item.item_type_id">
                        <option value="">{{ __('') }}</option>
                        @foreach($this->itemTypes as $itemType)
                            <option value="{{ $itemType->id }}">{{ $itemType->name }}</option>
                        @endforeach
                    </select>
                    <x-jet-input-error for="item.item_type_id" class="mt-2" />
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



        @if ($similarItems)
            <hr>
            <div class="flex justify-between pl-3 items-center py-5 sm:pb-3">
                <h3 class="text-xl font-medium text-gray-900">{{ __('Аналоги') }}</h3>
            </div>
            <div class="mt-6">
                <livewire:items.item-similar-manager :item="$item" />
            </div>

            <x-livewire.items.similar-items :similar-items="$similarItems" :groups="$groups" />
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
