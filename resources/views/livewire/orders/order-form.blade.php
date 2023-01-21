<div>
    <form wire:submit.prevent="submit">
        <div class="shadow overflow-hidden sm:rounded-md">
            <div class="px-4 py-5 bg-white sm:p-6">
                <div class="grid grid-cols-6 gap-6">
                    <!-- Customer -->
                    <div class="col-span-6 sm:col-span-2">
                        <x-jet-label for="customer_id" value="{{ __('Контрагент') }}" />
                        <div class="flex justify-content-between items-center">
                            <livewire:customers.customer-select :value="$order->customer_id" :placeholder="__('Новый контрагент')" />
                            <button type="button" wire:click="$set('managingCustomer', true)" class="cursor-pointer ml-2">
                                <x-heroicon-o-pencil class="w-5 h-5" />
                            </button>
                        </div>
                        <x-jet-input-error for="order.customer_id" class="mt-2" />
                    </div>
                    <!-- Status -->
                    <div class="col-span-6 sm:col-span-2">
                        <x-jet-label for="status" value="{{ __('Статус') }}" />
                        <select class="form-input rounded-md shadow-sm block w-full" wire:model.defer="order.status">
                            @foreach(\App\Models\Order::statusOptions() as $status => $label)
                                <?php if($status === \App\Models\Order::STATUS_DRAFTED && $order->status !== \App\Models\Order::STATUS_DRAFTED) { continue; } ?>
                                <option value="{{ $status }}">{{ $label }}</option>
                            @endforeach
                        </select>
                        <x-jet-input-error for="order.status" class="mt-2" />
                    </div>
                    <!-- Tax -->
                    <div class="col-span-6 sm:col-span-2">
                        <x-jet-label for="tax" value="{{ __('Налог') }}" />
                        @if($order->status === \App\Models\Order::STATUS_DRAFTED)
                            <select id="tax" wire:change="setDefaultTaxPercent" class="form-input rounded-md shadow-sm block w-full" wire:model.defer="order.tax">
                                @foreach(\App\Models\Order::taxOptions() as $tax => $label)
                                    <option value="{{ $tax }}">{{ $label }}</option>
                                @endforeach
                            </select>
                            <x-jet-input-error for="order.tax" class="mt-2" />
                        @else
                            <div class="py-3 whitespace-nowrap text-sm font-medium">{{ \App\Models\Order::taxLabel($order->tax) }}</div>
                        @endif
                    </div>
                    <!-- Tax percent -->
                    <?php if ($order->tax !== \App\Models\Order::TAX_CASH): ?>
                    <div class="col-span-6 sm:col-span-2">
                        <x-jet-label for="tax_percent" value="{{ __('Процент') }}" />
                        <x-jet-input id="tax_percent" type="number" max="100" class="mt-1 block w-full" wire:model.defer="order.tax_percent" />
                        <x-jet-input-error for="order.tax_percent" class="mt-2" />
                    </div>
                    <?php endif; ?>
                    <!-- Note -->
                    <div class="col-span-6">
                        <x-jet-label for="note" value="{{ __('Примечание') }}" />
                        <x-textarea id="note" rows="3" class="block w-full" wire:model="order.note"></x-textarea>
                        <x-jet-input-error for="order.note" class="mt-2" />
                    </div>
                </div>
            </div>
            <div class="flex items-center justify-end px-4 py-3 bg-gray-50 text-right sm:px-6">
                <x-jet-action-message class="mr-3" on="orderSaved">
                    {{ __('Saved.') }}
                </x-jet-action-message>

                <x-jet-button>
                    {{ __('Save') }}
                </x-jet-button>
            </div>
        </div>
    </form>

    <x-jet-dialog-modal wire:model="managingCustomer">
        <x-slot name="title">
            {{ __('Информация о покупателе') }}
        </x-slot>

        <x-slot name="content">
            <livewire:customers.customer-form :customer="$order->customer" :in-modal="true" />
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$set('managingCustomer', false)" wire:loading.attr="disabled">
                {{ __('Nevermind') }}
            </x-jet-secondary-button>

            <x-jet-button class="ml-2" wire:click="$emit('saveCustomer')" wire:loading.attr="disabled">
                {{ __('Save') }}
            </x-jet-button>
        </x-slot>
    </x-jet-dialog-modal>
</div>
