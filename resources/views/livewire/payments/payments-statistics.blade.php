<div>
{{--    <h3 class="text-xl font-medium text-gray-900">{{ __('Доходы') }}</h3>--}}
    <div class="flex items-center space-x-2 mb-4">
        <div>В период с</div>
        <x-jet-input type="date" wire:model="periodFrom" />
        <div>по</div>
        <x-jet-input type="date" wire:model="periodTo" />
        <label class="inline-flex items-center">
            <input type="checkbox" class="form-checkbox h-5 w-5 text-gray-600" wire:model="withOrdersInProcess">
            <span class="ml-2 text-gray-700">{{ __('С учетом заказов в работе') }}</span>
        </label>
        <x-heroicon-o-refresh wire:loading.delay="100" class="h-5 w-5 text-gray-400 animate-spin" />
    </div>
    <div class="relative shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
        <table class="table-auto min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th></th>
                    <th class="px-6 py-3 text-right text-sm font-medium text-gray-500 tracking-wider">
                        <x-jet-nav-link href="{{ route('payments.cashStatistics') }}">
                            {{ __('Без НДС') }}
                        </x-jet-nav-link>
                    </th>
                    <th class="px-6 py-3 text-right text-sm font-medium text-gray-500 tracking-wider">
                        <x-jet-nav-link href="{{ route('payments.cashlessStatistics') }}">
                            {{ __('С НДС') }}
                        </x-jet-nav-link>
                    </th>
                    <th class="px-6 py-3 text-right text-sm font-medium text-gray-500 tracking-wider">{{ __('Общая') }}</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($this->incomeItems as $incomeItem)
                    <tr>
                        <td class="px-6 py-4 text-sm font-medium whitespace-nowrap">{{ $incomeItem->category }}</td>
                        <td class="px-6 py-4 text-right text-sm font-medium whitespace-nowrap">{{ \App\Format::asCurrency($incomeItem->amountWithoutTax) }}</td>
                        <td class="px-6 py-4 text-right text-sm font-medium whitespace-nowrap">{{ \App\Format::asCurrency($incomeItem->amountWithTax) }}</td>
                        <td class="px-6 py-4 text-right text-sm font-medium whitespace-nowrap">{{ \App\Format::asCurrency($incomeItem->totalAmount) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
