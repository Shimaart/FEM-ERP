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
                <th class="px-6 py-3 text-center text-sm font-medium text-gray-500 tracking-wider">
                    {{ __('Доход') }}
                </th>
                <th class="px-6 py-3 text-center text-sm font-medium text-gray-500 tracking-wider">
                    {{ __('Расход') }}
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
</div>
