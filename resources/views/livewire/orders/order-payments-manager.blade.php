<div>
    <div class="flex justify-between items-center py-5 sm:pb-3">
        <h3 class="text-xl font-medium text-gray-900">{{ __('Оплата') }}</h3>

        <x-jet-button class="ml-2" wire:click="$set('creatingNewPayment', true)" wire:loading.attr="disabled">
            <x-heroicon-o-plus class="-ml-1 mr-2 h-4 w-4" />
            {{ __('Добавить платеж') }}
        </x-jet-button>
    </div>
    <livewire:orders.order-payments-table :order="$order" />

    <div class="shadow overflow-hidden sm:rounded-md mt-4">
        <table class="min-w-full divide-y divide-gray-200">
            <colgroup>
                <col width="50%" />
                <col />
                <col />
            </colgroup>
            <tfoot class="bg-gray-50 divide-y divide-gray-200">
                @if($order->discount_amount)
                <tr>
                    <td></td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-right">{{ __('Общая стоимость без скидки') }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-right">
                        {{ \App\Format::asCurrency($order->total_amount + $order->discount_amount) }}
                    </td>
                </tr>
                @endif
                <tr>
                    <td></td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-right">{{ __('Скидка') }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-right">
                        <span>{{ \App\Format::asCurrency($order->discount_amount) }}</span>
                        <button type="button" wire:click="$set('updatingOrderDiscount', true)" class="cursor-pointer ml-2 inline-block">
                            <x-heroicon-o-pencil class="w-5 h-5" />
                        </button>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-right">{{ __('Налог') }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-right">
                        <!-- Tax -->
                        {{ \App\Models\Order::taxLabel($order->tax) }} ({{ $order->tax_percent }}%)
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-right">{{ __('Стоимость без налога') }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-right">{{ \App\Format::asCurrency($order->getPayableWithoutTaxAmount()) }}</td>
                </tr>
                <tr>
                    <td></td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-right">{{ __('Общая стоимость') }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-right">{{ \App\Format::asCurrency($order->getPayableAmount()) }}</td>
                </tr>
                <tr>
                    <td></td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-right">{{ __('Оплачено') }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-right">
                        {{ \App\Format::asCurrency($order->getPaidSum()) }}
                    </td>
                </tr>
                @if($order->getPayableAmount() - $order->getPaidSum() > 0)
                    <tr>
                        <td></td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-right">{{ __('Остаток') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-right">{{ \App\Format::asCurrency($order->getPayableAmount() - $order->getPaidSum()) }}</td>
                    </tr>
                @endif
            </tfoot>
        </table>
    </div>

    <!-- New Payment Modal -->
    <x-jet-dialog-modal wire:model="creatingNewPayment">
        <x-slot name="title">
            {{ __('Новый платеж') }}
        </x-slot>

        <x-slot name="content">
            <form wire:submit="createPayment">
                    <div class="grid grid-cols-6 gap-6">
                        <div class="col-span-6 sm:col-span-4">
                            <x-jet-label for="amount" value="{{ __('Сумма') }}" />
                            <x-jet-input id="amount" type="number" min="0" class="mt-1 block w-full" wire:model.defer="newPaymentForm.amount" autofocus />
                            <x-jet-input-error for="newPaymentForm.amount" class="mt-2" />
                        </div>

                    <div class="col-span-6 sm:col-span-4">
                        <x-jet-label for="payment_type" value="{{ __('Рассчет') }}" />
                        {{ \App\Models\Payment::paymentTypeLabel($order->payment_type) }}
                    </div>
                </div>
            </form>
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$set('creatingNewPayment', false)" wire:loading.attr="disabled">
                {{ __('Nevermind') }}
            </x-jet-secondary-button>

            <x-jet-button class="ml-2" wire:click="createPayment" wire:loading.attr="disabled">
                {{ __('Save') }}
            </x-jet-button>
        </x-slot>
    </x-jet-dialog-modal>


    <!-- Order Discount Modal -->
    <x-jet-dialog-modal wire:model="updatingOrderDiscount">
        <x-slot name="title">
            {{ __('Скидка в заказе') }}
        </x-slot>

        <x-slot name="content">
            <form wire:submit="updateOrderDiscount">
                <div class="grid grid-cols-6 gap-6">
                    <div class="col-span-6 sm:col-span-4">
                        <x-jet-label for="discount_amount" value="{{ __('Сумма скидки') }}" />
                        <x-jet-input id="discount_amount" type="number" min="0" class="mt-1 block w-full" wire:model.defer="updateOrderDiscountForm.discount_amount" autofocus />
                        <x-jet-input-error for="updateOrderDiscountForm.discount_amount" class="mt-2" />
                    </div>
                </div>
            </form>
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$set('updatingOrderDiscount', false)" wire:loading.attr="disabled">
                {{ __('Nevermind') }}
            </x-jet-secondary-button>

            <x-jet-button class="ml-2" wire:click="updateOrderDiscount" wire:loading.attr="disabled">
                {{ __('Save') }}
            </x-jet-button>
        </x-slot>
    </x-jet-dialog-modal>
</div>
