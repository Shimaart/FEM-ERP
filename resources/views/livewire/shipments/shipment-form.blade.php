<form wire:submit.prevent="submit">
    <div class="shadow overflow-hidden sm:rounded-md">
        <div class="px-4 py-5 bg-white sm:p-6 sm:pb-3">
            <div class="grid grid-cols-6 gap-6">
                @if($canUpdateOrder)
                    <!-- Order -->
                    <div class="col-span-6 sm:col-span-2">
                        <x-jet-label for="order_id" value="{{ __('Заказ') }}" />
                        <select disabled="disabled" class="form-input rounded-md shadow-sm block w-full" wire:model="shipment.order_id">
                            <option value=""></option>
                            @foreach($this->orders as $order)
                                <option value="{{ $order->id }}">№{{ $order->number }} @if($order->customer)({{ $order->customer->name }})@endif</option>
                            @endforeach
                        </select>
                        <x-jet-input-error for="shipment.order_id" class="mt-2" />
                    </div>
                @endif
                <!-- Type -->
                <div class="col-span-6 sm:col-span-2">
                    <x-jet-label for="type" value="{{ __('Тип доставки') }}" />
                    <select disabled="disabled" class="form-input rounded-md shadow-sm block w-full" wire:model="shipment.type">
                        <option value=""></option>
                        @foreach($this->types as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </select>
                    <x-jet-input-error for="shipment.type" class="mt-2" />
                </div>
                <!-- Transport -->
                @if($this->shipment->type === \App\Models\Shipment::TYPE_DELIVERY)
                    <div class="col-span-6 sm:col-span-2">
                        <x-jet-label for="transport_id" value="{{ __('Транспорт') }}" />
                        <select disabled="disabled" class="form-input rounded-md shadow-sm block w-full" wire:model.defer="shipment.transport_id">
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
                    <x-textarea disabled="disabled" id="address" class="mt-1 block w-full" wire:model.defer="shipment.address" rows="2" />
                    <x-jet-input-error for="shipment.address" class="mt-2" />
                </div>
                <!-- Desired Date -->
                <div class="col-span-6 sm:col-span-2">
                    <x-jet-label for="desired_date" value="{{ __('Дата доставки') }}" />
                    <x-jet-input disabled="disabled" type="date" id="desired_date" class="mt-1 block w-full" wire:model.defer="shipment.desired_date" />
                    <x-jet-input-error for="shipment.desired_date" class="mt-2" />
                </div>
                <!-- Distance -->
                <div class="col-span-6 sm:col-span-2">
                    <x-jet-label for="distance" value="{{ __('Километраж') }}" />
                    <x-jet-input disabled="disabled" type="number" id="distance" class="mt-1 block w-full" wire:model="shipment.distance" step="0.01" min="0" />
                    <x-jet-input-error for="shipment.distance" class="mt-2" />
                </div>
                <!-- Kilometer price -->
                <div class="col-span-6 sm:col-span-2">
                    <x-jet-label for="kilometer_price" value="{{ __('Стоимость грн/км') }}" />
                    <x-jet-input disabled="disabled" type="number" id="kilometer_price" class="mt-1 block w-full" wire:model="shipment.kilometer_price" step="0.01" min="0" />
                    <x-jet-input-error for="shipment.kilometer_price" class="mt-2" />
                </div>
            </div>
        </div>
        <!-- Shippable items -->
        <div class="px-4 py-5 bg-white sm:p-6 sm:pb-3">
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
                @foreach($orderItems as $index => $orderItem)
                    <tr wire:key="order-item-{{ $orderItem->id }}">
                        <td class="px-6 py-3">{{ $orderItem->item->name }}</td>
                        <td class="px-6 py-3">
                            <x-jet-input disabled="disabled" type="number" min="0" :max="$orderItem->quantity" step="0.01" wire:model="shipmentItems.{{ $index }}.quantity" />
                            / {{ $orderItem->quantity }} {{ $orderItem->item->unit->symbol }}
                        </td>
                        <td class="px-6 py-3">
                            {{ $shipmentItems[$index]->quantity * $orderItem->item->weight }} кг
                            <div class="text-xs text-gray-500">{{ $orderItem->item->weight }} кг за 1{{ $orderItem->item->unit->symbol }}</div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot class="bg-gray-50 divide-y divide-gray-200">
                <tr>
                    <td></td>
                    <td class="px-6 py-3 text-right">{{ __('Общий вес') }}</td>
                    <td class="px-6 py-3">{{ $totalWeight }} кг</td>
                </tr>
            </tfoot>
        </table>

        <div class="flex items-center justify-end px-4 py-3 bg-gray-50 text-right sm:px-6">
            <x-jet-action-message class="mr-3" on="saved">
                {{ __('Saved.') }}
            </x-jet-action-message>

            @if($this->shipment->status === \App\Models\Shipment::STATUS_CREATED)
                <x-jet-button class="ml-2" wire:click="sendShipment" wire:loading.attr="disabled">
                    {{ __('Отправить') }}
                </x-jet-button>
            @endif

            @if($this->shipment->status === \App\Models\Shipment::STATUS_SHIPPED)
                <x-jet-button class="ml-2" wire:click="deliveredShipment" wire:loading.attr="disabled">
                    {{ __('Доставлен') }}
                </x-jet-button>
            @endif
        </div>
    </div>
</form>
