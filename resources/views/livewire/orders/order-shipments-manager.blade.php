<div>
    <div class="flex justify-between items-center py-5 sm:pb-3">
        <h3 class="text-xl font-medium text-gray-900">{{ __('Отгрузка') }}</h3>

        <x-jet-button class="ml-2" wire:click="manageShipment" wire:loading.attr="disabled">
            <x-heroicon-o-plus class="-ml-1 mr-2 h-4 w-4" />
            {{ __('Добавить отгрузку') }}
        </x-jet-button>
    </div>

    <livewire:orders.order-shipments-table :order="$order" />

    <!-- Shipment Form Modal -->
    <x-jet-dialog-modal wire:model="managingShipment" max-width="2xl">
        <x-slot name="title">
            {{ __('Добавление отгрузки к заказу') }}
        </x-slot>

        <x-slot name="content">
            @if($shipment)
                <div class="grid grid-cols-6 gap-6">
                    <!-- Type -->
                    <div class="col-span-6 sm:col-span-3">
                        <x-jet-label for="type" value="{{ __('Тип доставки') }}" />
                        <select wire:change="setDefaultProfitPercent" class="form-input rounded-md shadow-sm block w-full" wire:model="shipment.type">
                            <option value=""></option>
                            @foreach(\App\Models\Shipment::typeOptions() as $value => $label)
                                <option value="{{ $value }}">{{ $label }}</option>
                            @endforeach
                        </select>
                        <x-jet-input-error for="shipment.type" class="mt-2" />
                    </div>
                    <!-- Transport -->
                    @if($shipment->type === \App\Models\Shipment::TYPE_DELIVERY)
                    <div class="col-span-6 sm:col-span-3">
                        <x-jet-label for="transport_id" value="{{ __('Транспорт') }}" />
                        <select class="form-input rounded-md shadow-sm block w-full" wire:model="shipment.transport_id">
                            <option value=""></option>
                            @foreach($this->transports as $transport)
                                <option value="{{ $transport->id }}">{{ $transport->name }}</option>
                            @endforeach
                        </select>
                        <x-jet-input-error for="shipment.transport_id" class="mt-2" />
                    </div>
                    @endif
                    <!-- Address -->
                    <div class="col-span-6">
                        <x-jet-label for="address" value="{{ __('Адрес') }}" />
                        <x-textarea id="address" class="mt-1 block w-full" wire:model.defer="shipment.address" rows="2" />
                        <x-jet-input-error for="shipment.address" class="mt-2" />
                    </div>
                    <!-- Desired Date -->
                    <div class="col-span-6">
                        <x-jet-label for="desired_date" value="{{ __('Дата доставки') }}" />
                        <x-jet-input type="date" id="desired_date" class="mt-1 block w-full" wire:model.defer="shipment.desired_date" />
                        <x-jet-input-error for="shipment.desired_date" class="mt-2" />
                    </div>
                    <!-- Distance -->
                    <div class="col-span-6 sm:col-span-2">
                        <x-jet-label for="distance" value="{{ __('Километраж') }}" />
                        <x-jet-input type="number" id="distance" class="mt-1 block w-full" wire:model="shipment.distance" step="0.01" min="0" />
                        <x-jet-input-error for="shipment.distance" class="mt-2" />
                    </div>
                    <!-- Kilometer price -->
                    <div class="col-span-6 sm:col-span-2">
                        <x-jet-label for="kilometer_price" value="{{ __('Стоимость грн/км') }}" />
                        <x-jet-input type="number" id="kilometer_price" class="mt-1 block w-full" wire:model="shipment.kilometer_price" step="0.01" min="0" />
                        <x-jet-input-error for="shipment.kilometer_price" class="mt-2" />
                    </div>
                    <!-- Amount -->
                    <div class="col-span-6 sm:col-span-2">
                        <x-jet-label for="kilometer_price" value="{{ __('Стоимость') }}" />
                        <div class="mt-3">
                            <?php
                            $distance = (!$shipment->distance || $shipment->distance === '') ? 0 : $shipment->distance;
                            $kilometer_price = (!$shipment->kilometer_price || $shipment->kilometer_price === '') ? 0 : $shipment->kilometer_price;
                            ?>
                            {{ \App\Format::asCurrency($kilometer_price * $distance) }}
                        </div>
                    </div>
{{--                    @TODO only TYPE_DELIVERY_SERVICE--}}
                    @if($shipment->type !== \App\Models\Shipment::TYPE_DELIVERY)
                        <!-- Profit percent -->
                        <div class="col-span-6 sm:col-span-3">
                            <x-jet-label for="profit_percent" value="{{ __('Процент заработка') }}" />
                            <div class="flex justify-content-between items-center mt-1">
                                <x-jet-input id="profit_percent" type="number" min="0" class="block w-full" wire:model="shipment.profit_percent" />
                                <div class="ml-2">%</div>
                            </div>
                            <x-jet-input-error for="shipment.profit_percent" class="mt-2" />
                        </div>
                    @endif
                    <!-- Paid by order -->
                    <div class="col-span-6 sm:col-span-4">
                        <label class="inline-flex items-center">
                            <input type="checkbox" class="form-checkbox h-5 w-5 text-gray-600" wire:model="shipment.paid_by_order" :value="true">
                            <span class="ml-2 text-gray-700">{{ __('Входит в стоимость заказа')}}</span>
                        </label>
                        <x-jet-input-error for="shipment.paid_by_order" class="mt-2" />
                    </div>
                </div>
                <!-- Shippable items -->
                <div class="py-5 sm:pb-3">
                    <h3 class="text-lg font-medium text-gray-900">{{ __('Отгружаемая продукция') }}</h3>
                </div>
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr>
                            <th scope="col"
                                class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                {{ __('Продукция') }}
                            </th>
                            <th scope="col"
                                class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                {{ __('Количество') }}
                            </th>
                            <th scope="col"
                                class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                {{ __('Вес') }}
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($order->orderItems as  $orderItem)
                            <tr wire:key="shipment-item-{{ $orderItem->id }}">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">{{ $orderItem->item->name }}</td>
                                <td class="px-6 py-3 whitespace-nowrap text-sm font-medium">
                                    <div class="flex justify-content-between items-center">
                                        <x-jet-input type="number" min="0" :max="$orderItem->getAvailableQuantity($shipment->id)" step="0.01" wire:model="quantities.{{ $orderItem->id }}" />
                                        <div class="ml-2">/ {{ $orderItem->getAvailableQuantity($shipment->id) }} ({{ $orderItem->quantity }}) {{ $orderItem->item->unit->symbol }}</div>
                                    </div>
                                </td>
                                <td class="px-6 py-3 whitespace-nowrap text-sm font-medium">
                                    {{ $quantities[$orderItem->id] ?? 0 * $orderItem->item->weight }} кг
                                    <div class="text-xs text-gray-500">{{ $orderItem->item->weight }} кг за 1{{ $orderItem->item->unit->symbol }}</div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="bg-gray-50 divide-y divide-gray-200">
                        <tr>
                            <td></td>
                            <td class="px-6 py-3 whitespace-nowrap text-sm font-medium text-right">{{ __('Общий вес') }}</td>
                            <td class="px-6 py-3 whitespace-nowrap text-sm font-medium">{{ $this->totalWeight }} кг</td>
                        </tr>
                    </tfoot>
                </table>
            @endif
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$set('managingShipment', false)" wire:loading.attr="disabled">
                {{ __('Nevermind') }}
            </x-jet-secondary-button>

            <x-jet-button class="ml-2" wire:click="saveShipment" wire:loading.attr="disabled">
                {{ __('Save') }}
            </x-jet-button>
        </x-slot>
    </x-jet-dialog-modal>
</div>
