<div>
    <div class="flex items-center space-x-2 mb-4">
        <div>В период с</div>
        <x-jet-input type="date" wire:model="periodFrom" />
        <div>по</div>
        <x-jet-input type="date" wire:model="periodTo" />
        <x-heroicon-o-refresh wire:loading.delay="100" class="h-5 w-5 text-gray-400 animate-spin" />
    </div>
    <div class="grid grid-cols-6 gap-6">
        <div class="col-span-6 sm:col-span-4">
            <table class="table-auto min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-center text-sm font-medium text-gray-500 tracking-wider">
                        <x-jet-nav-link href="{{ route('payments.cashboxDetail', [
                                                    'periodFrom' => $this->periodFrom,
                                                    'periodTo' => $this->periodTo,
                                                ]) }}">
                            {{ __('Доход') }}
                        </x-jet-nav-link>
                    </th>
                    <th class="px-6 py-3 text-center text-sm font-medium text-gray-500 tracking-wider">
                        <x-jet-nav-link href="{{ route('payments.cashboxDetail', [
                                                    'periodFrom' => $this->periodFrom,
                                                    'periodTo' => $this->periodTo,
                                                    'type' => 'outgoing'
                                                ]) }}">
                            {{ __('Расход') }}
                        </x-jet-nav-link>
                    </th>
                    <th class="px-6 py-3 text-center text-sm font-medium text-gray-500 tracking-wider">{{ __('Итого') }}</th>
                </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                <tr>
                    <td class="px-6 py-4 text-center text-sm font-medium whitespace-nowrap">{{ $this->incomeTotal }}</td>
                    <td class="px-6 py-4 text-center text-sm font-medium whitespace-nowrap">{{ $this->outgoingTotal }}</td>
                    <td class="px-6 py-4 text-center text-sm font-medium whitespace-nowrap">{{ $this->total }}</td>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="col-span-6 sm:col-span-2">
            <table class="table-auto min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                <tr>
                    <th colspan="3">Налоговый лимит</th>
                </tr>
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-500 tracking-wider">
                        {{ __('Месяц') }}
                    </th>
                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-500 tracking-wider">
                        {{ __('Значение') }}
                    </th>
                </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                @foreach($this->taxLimits as $taxLimit)
                    <tr>
                        <td class="px-6 py-4 text-left text-sm font-medium whitespace-nowrap">{{ $taxLimit->month->format('Y-m-d') }}</td>
                        <td class="px-6 py-4 text-left text-sm font-medium whitespace-nowrap">{{ $taxLimit->value }}</td>
                    </tr>
                @endforeach
                </tbody>
                <tfoot class="bg-gray-50">
                <tr>
                    <td class="px-6 py-4 text-right text-sm font-medium whitespace-nowrap"><strong>Итого:</strong></td>
                    <td class="px-6 py-4 text-left text-sm font-medium whitespace-nowrap">{{ $this->taxLimits->sum('value') }}</td>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
