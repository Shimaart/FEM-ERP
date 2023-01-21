<div>
    <div class="flex justify-between items-center py-5 sm:pb-3">
        <h3 class="text-xl font-medium text-gray-900">{{ $category ? $category->name : __('Продукция') }}</h3>

        <x-jet-button class="ml-2" wire:click="manageOrderItem" wire:loading.attr="disabled">
            <x-heroicon-o-plus class="-ml-1 mr-2 h-4 w-4" />
            {{ __('Добавить продукцию') }}
        </x-jet-button>
    </div>

    <livewire:orders.order-items-table :order="$order" :category="$category" />

    <!-- Order Item Form Modal -->
    <x-jet-dialog-modal wire:model="managingOrderItem">
        <x-slot name="title">
            {{ __('Добавление продукции к заказу') }}
        </x-slot>

        <x-slot name="content">
            @if($managedOrderItem)
                <form wire:submit="saveOrderItem">
                    <div class="grid grid-cols-6 gap-6">

                        <!-- Item Type -->
                        <div class="col-span-6 sm:col-span-4">
                            <x-jet-label for="item_id" value="{{ __('Продукция') }}" />
                            <x-select class="block w-full" wire:model="itemTypeId">
                                <option value="">{{ __('') }}</option>
                                @foreach($this->itemTypes as $type)
                                    <option value="{{ $type->id }}">{{ $type->name }}</option>
                                @endforeach
                            </x-select>
                            <x-jet-input-error for="itemTypeId" class="mt-2" />
                        </div>

                        @if($this->itemType)
                            @if($this->shouldUseAttributes)

                                <!-- Attributes -->
                                <div class="col-span-6">
                                    <div class="grid grid-cols-6 gap-6">
                                        @foreach($this->itemType->itemTypeGroups as $itemTypeGroup)
                                            <div class="sm:col-span-2">
                                                <x-jet-label value="{{ $itemTypeGroup->group->name }}" />
                                                <x-select class="block w-full" wire:model="attributes.{{ $itemTypeGroup->group->id }}">
                                                    <option value="">{{ __('') }}</option>
                                                    @foreach($itemTypeGroup->group->attributes as $attribute)
                                                        <option value="{{ $attribute->id }}">{{ $attribute->name }}</option>
                                                    @endforeach
                                                </x-select>
                                                <x-jet-input-error for="attributes.{{ $itemTypeGroup->id }}" class="mt-2" />
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                <!-- Item -->
                                <div class="col-span-6 sm:col-span-4">
                                    {{ $managedOrderItem->item ? $managedOrderItem->item->name : '' }}
                                    <x-jet-input-error for="managedOrderItem.item_id" class="mt-2" />
                                </div>
                            @else

                                <!-- Item -->
                                <div class="col-span-6 sm:col-span-4">
                                    <x-select class="block w-full" wire:model="managedOrderItem.item_id">
                                        <option value="">{{ __('') }}</option>
                                        @foreach($this->items as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </x-select>
                                    <x-jet-input-error for="managedOrderItem.item_id" class="mt-2" />
                                </div>
                            @endif
                        @endif

                        <!-- Quantity -->
                        <div class="col-span-6 sm:col-span-3">
                            <x-jet-label for="quantity" value="{{ __('Количество') }}" />
                            <div class="flex justify-content-between items-center mt-1">
                                <x-jet-input id="quantity" type="number" min="0" class="block w-full" wire:model="managedOrderItem.quantity" />
                                @if($managedOrderItem->item)
                                <div class="ml-2">
                                    {{ $managedOrderItem->item->unit->symbol }}
                                </div>
                                @endif
                            </div>
                            <x-jet-input-error for="managedOrderItem.quantity" class="mt-2" />
                        </div>

                        <!-- Price -->
                        <div class="col-span-6 sm:col-span-3">
                            <x-jet-label for="price" value="{{ __('Цена за единицу') }}" />
                            <x-jet-input id="price" type="number" min="0" class="mt-1 block w-full" wire:model="managedOrderItem.price" />
                            <x-jet-input-error for="managedOrderItem.price" class="mt-2" />
                        </div>
                        {{--@TODO normal validation--}}
                        @if((int)$itemTypeId === 2)
                            <div class="col-span-6">
                                <div class="grid grid-cols-6 gap-6">
                                    <!-- Warehouse skipped -->
                                    <div class="col-span-6 sm:col-span-3">
                                        <!-- Name -->
                                        <x-jet-label for="warehouse_skipped" value="{{ __('Минуя склад') }}" />
{{--                                        <div class="flex justify-content-between items-center mt-1">--}}
{{--                                        <x-jet-input id="purchase_price" type="checkbox" class="block w-full" wire:model="managedOrderItem.warehouse_skipped" />--}}
{{--                                        </div>--}}
                                        <label class="inline-flex items-center mt-3">
                                            <input type="checkbox" class="form-checkbox h-5 w-5 text-gray-600" wire:model="managedOrderItem.warehouse_skipped">
                                            <span class="ml-2 text-gray-700">Минуя склад</span>
                                        </label>
                                    </div>
                                    <!-- Purchase price -->
                                    @if($managedOrderItem->warehouse_skipped)
                                        <div class="col-span-6 sm:col-span-3">
                                            <x-jet-label for="purchase_price" value="{{ __('Цена закупки') }}" />
                                            <div class="flex justify-content-between items-center mt-1">
                                                <x-jet-input id="purchase_price" type="number" min="0" class="block w-full" wire:model="managedOrderItem.purchase_price" />
                                            </div>
                                            <x-jet-input-error for="managedOrderItem.purchase_price" class="mt-2" />
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endif
                        <!-- Discount -->
                        <div class="col-span-6 sm:col-span-2">
                            <x-jet-label for="discount" value="{{ __('Скидка') }}" />
                            <div class="flex justify-content-between items-center mt-1">
                                <x-jet-input id="discount" type="number" min="0" class="block w-full" wire:model="managedOrderItem.discount" />
                                <div class="ml-2">%</div>
                            </div>
                            <x-jet-input-error for="managedOrderItem.discount" class="mt-2" />
                        </div>

                        {{--@TODO normal validation--}}
                        @if((int)$itemTypeId === 4)
                            <!-- Profit percent -->
                            <div class="col-span-6 sm:col-span-2">
                                <x-jet-label for="profit_percent" value="{{ __('Процент заработка') }}" />
                                <div class="flex justify-content-between items-center mt-1">
                                    <x-jet-input id="profit_percent" type="number" min="0" class="block w-full" wire:model="managedOrderItem.profit_percent" />
                                    <div class="ml-2">%</div>
                                </div>
                                <x-jet-input-error for="managedOrderItem.profit_percent" class="mt-2" />
                            </div>
                        @endif

                        <!-- Amount / Tax / Total Amount -->
                        <div class="col-span-6">
                            <div>
                                <x-jet-label value="{{ __('Сумма') }}" />
                                {{ \App\Format::asCurrency($managedOrderItem->amount) }}
                            </div>
                            @if($managedOrderItem->item && $managedOrderItem->item->itemCategory->taxable && $order->has_tax)
                                <div>
                                    <x-jet-label value="{{ __('Налог') }}" />
                                    {{ $order->tax_label }} ({{ $order->tax_percent }}%)
                                </div>
                            @endif
                            <div>
                                <x-jet-label value="{{ __('Итоговая сумма') }}" />
                                {{ \App\Format::asCurrency($managedOrderItem->total_amount) }}
                            </div>
                        </div>
                    </div>
                </form>
            @endif
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$set('managingOrderItem', false)" wire:loading.attr="disabled">
                {{ __('Nevermind') }}
            </x-jet-secondary-button>

            <x-jet-button class="ml-2" wire:click="saveOrderItem" wire:loading.attr="disabled">
                {{ __('Save') }}
            </x-jet-button>
        </x-slot>
    </x-jet-dialog-modal>
</div>
