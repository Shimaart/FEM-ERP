<div>
    <div class="flex items-center space-x-2 mb-4">
        <div>В период с</div>
        <x-jet-input type="date" wire:model="periodFrom" />
        <div>по</div>
        <x-jet-input type="date" wire:model="periodTo" />
        <x-heroicon-o-refresh wire:loading.delay="100" class="h-5 w-5 text-gray-400 animate-spin" />
    </div>
    <div>
        <table class="table-auto min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-sm text-left font-medium text-gray-500 tracking-wider">
                    {{ __('Номер') }}
                </th>
                <th class="px-6 py-3 text-sm text-left font-medium text-gray-500 tracking-wider">{{ __('Назначение') }}</th>
                <th class="px-6 py-3 text-sm text-left font-medium text-gray-500 tracking-wider">{{ __('Сумма') }}</th>
                <th class="px-6 py-3 text-sm text-left font-medium text-gray-500 tracking-wider">
                    {{ __('Дата оплаты') }}
                </th>
            </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
            @foreach($payments as $payment)
                <tr>
                    <td class="px-6 py-4 text-sm font-medium whitespace-nowrap">{{ $payment->id }}</td>
                    <td class="px-6 py-4 text-sm font-medium whitespace-nowrap">
                        @if($this->type === 'income')
                            {{ $payment->paymentable->number }}
                        @endif
                        @if($this->type === 'outgoing')
                            @if($payment->paymentable_type === 'shipment')
                                Доставка №{{ $payment->paymentable->id }}
                            @else
                                {{ $payment->paymentable->name }}
                            @endif
                        @endif
                    </td>
                    <td class="px-6 py-4 text-sm font-medium whitespace-nowrap">{{ $payment->amount }}</td>
                    <td class="px-6 py-4 text-sm font-medium whitespace-nowrap">{{ $payment->paid_at }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{ $payments->links() }}
    </div>
</div>
