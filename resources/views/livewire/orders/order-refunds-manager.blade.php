<div>
    <div class="flex justify-between items-center py-5 sm:pb-3">
        <h3 class="text-xl font-medium text-gray-900">{{ __('Возвраты') }}</h3>

        <x-jet-button class="ml-2" wire:click="manageRefund" wire:loading.attr="disabled">
            <x-heroicon-o-plus class="-ml-1 mr-2 h-4 w-4" />
            {{ __('Добавить возврат') }}
        </x-jet-button>
    </div>

    <livewire:orders.order-refunds-table :order="$order" />

    <!-- Order Comment Form Modal -->
    <x-jet-dialog-modal wire:model="managingRefund">
        <x-slot name="title">
            {{ __('Добавление возврата') }}
        </x-slot>

        <x-slot name="content">
            <form wire:submit="saveRefund">
                @if($refund)
                    <div class="grid grid-cols-6 gap-6">
                        <!-- Order Item -->
                        <div class="col-span-6 sm:col-span-3">
                            <x-jet-label value="{{ __('Возвращаемая продукция') }}" />
                            <select class="mt-1 form-input rounded-md shadow-sm block w-full" wire:model="refundProduct.item_id">
                                <option value=""></option>
                                @foreach($this->orderItems->groupBy('item.category_id') as $orderItems)
                                    <optgroup label="{{ $orderItems->first()->item->itemCategory->name }}">
                                        @foreach($orderItems as $orderItem)
                                            <option value="{{ $orderItem->id }}">{{ $orderItem->item->name }}</option>
                                        @endforeach
                                    </optgroup>
                                @endforeach
                            </select>
                            <x-jet-input-error for="refundProduct.item_id" class="mt-2" />
                        </div>
                        <!-- Quantity -->
                        <div class="col-span-6 sm:col-span-2">
                            <x-jet-label value="{{ __('Количество') }}" />
                            <x-jet-input type="number" class="mt-1 block w-full" wire:model="refundProduct.quantity" step="0.01" min="0" />
                            <x-jet-input-error for="refundProduct.quantity" class="mt-2" />
                        </div>
                        @if($this->refundProduct
            && $this->refundProduct->orderItem
            && $this->refundProduct->orderItem->item
            && $this->refundProduct->orderItem->item->itemCategory
            && $this->refundProduct->orderItem->item->itemCategory->slug === 'pallets'
        )
                            <!-- Return Price -->
                                <div class="col-span-6">
                                    <x-jet-label value="{{ __('Цена возврата') }}" />
                                    <x-jet-input type="number" class="mt-1 block w-full" wire:model="refundProduct.return_price" placeholder="{{$this->refundProduct->orderItem->item->return_price}}" step="0.01" min="0" />
                                    <x-jet-input-error for="refundProduct.return_price" class="mt-2" />
                                </div>
                        @endif

                        <!-- Comment -->
                        <div class="col-span-6">
                            <x-jet-label value="{{ __('Комментарий') }}" />
                            <x-textarea class="mt-1 block w-full" wire:model.defer="refund.comment" rows="2" />
                            <x-jet-input-error for="refund.comment" class="mt-2" />
                        </div>
                    </div>
                @endif
            </form>
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$set('managingRefund', false)" wire:loading.attr="disabled">
                {{ __('Nevermind') }}
            </x-jet-secondary-button>

            <x-jet-button class="ml-2" wire:click="saveRefund" wire:loading.attr="disabled">
                {{ __('Save') }}
            </x-jet-button>
        </x-slot>
    </x-jet-dialog-modal>
</div>
