<div>
    <form wire:submit.prevent="submit">
        <div class="shadow overflow-hidden sm:rounded-md">
            <div class="px-4 py-5 bg-white sm:p-6">
                <div class="grid grid-cols-6 gap-6">
                    <!-- Desired Date -->
                    <div class="col-span-6 sm:col-span-2">
                        <x-jet-label for="date" value="{{ __('Дата задачи') }}" />
                        <x-jet-input type="date" id="date" class="mt-1 block w-full" wire:model.defer="production.date" />
                        <x-jet-input-error for="production.date" class="mt-2" />
                    </div>
                </div>
            </div>

            <!-- Items -->
            <table class="min-w-full divide-y divide-gray-200">
                <thead>
                <tr>
                    <th scope="col"
                        class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Наименование
                    </th>
                    <th scope="col"
                        class="px-6 py-3 bg-gray-50 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Неоходимое к-во
                    </th>
                    <th scope="col"
                        class="px-6 py-3 bg-gray-50 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Произведенное к-во
                    </th>
                    <th scope="col"
                        class="px-6 py-3 bg-gray-50 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                        К-во брака
                    </th>
                    <th scope="col"
                        class="px-6 py-3 bg-gray-50 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Принятое к-во
                    </th>
                    <th scope="col"
                        width="20%"
                        class="px-6 py-3 bg-gray-50 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Материалы
                    </th>
                </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                @foreach($production->productionItems as $productionItem)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            {{ $productionItem->item->name }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-right">
                            {{ $productionItem->need_quantity }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-right">
                            @if($production->status === \App\Models\Production::STATUS_CREATED)
                                <x-jet-input type="number"  step="0.01" wire:model.defer="productionItems.{{ $productionItem->id }}.processed_quantity" />
                            @else
                                {{ $productionItem->processed_quantity }}
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-right">
                            @if($production->status === \App\Models\Production::STATUS_CREATED)
                                <x-jet-input type="number"   step="0.01" wire:model.defer="productionItems.{{ $productionItem->id }}.defects_count" />
                            @else
                                {{ $productionItem->defects_count }}
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-right">
                            @if($production->status === \App\Models\Production::STATUS_PROCESSED)
                                <x-jet-input type="number"   step="0.01" wire:model.defer="productionItems.{{ $productionItem->id }}.received_quantity" />
                            @else
                                {{ $productionItem->received_quantity ? $productionItem->received_quantity : '-' }}
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-right">
                            @if($production->status === \App\Models\Production::STATUS_CREATED)
                                <livewire:productions.production-item-materials-manager :production-item="$productionItem" :key="$productionItem->id" />
                            @endif
                            @if($productionItem->materials->count())
                                <ul>
                                    @foreach($productionItem->materials as $material)
                                        <li>{{ $material->material->name }} ({{ $material->value }} {{ $material->material->unit->symbol }})</li>
                                    @endforeach
                                </ul>
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            @if($errors->has('productionItems'))
                <div class="px-4 py-5 bg-white sm:p-6">
                    <p class="text-sm text-red-600 mt-2 text-right">@error('productionItems') <span class="error">{{ $message }}</span> @enderror</p>
                </div>
            @endif

            @if($production->status === \App\Models\Production::STATUS_RECEIVED)
                <div class="flex items-center justify-center px-4 py-3 bg-gray-50 text-right sm:px-6">
                    <p class="text-center uppercase text-green-800 font-semibold text-2xl">Принят</p>
                </div>
            @else
                <div class="flex items-center justify-end px-4 py-3 bg-gray-50 text-right sm:px-6">
                    <x-jet-action-message class="mr-3" on="saved">
                        {{ __('Saved.') }}
                    </x-jet-action-message>

                    <x-jet-button>
                        {{ __('Save') }}
                    </x-jet-button>
                </div>
            @endif

            <!-- Comments -->
            <table class="min-w-full divide-y divide-gray-200">
                <thead>
                <tr>
                    <th scope="col"
                        class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Автор
                    </th>
                    <th scope="col"
                        class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Комментарий
                    </th>
                    <th scope="col"
                        class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Статус
                    </th>
                </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                @foreach($production->comments as $comment)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            {{ $comment->author->name }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-left">
                            {{ $comment->comment }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-left">
                            {{ \App\Format::asEnum($comment->status, \App\Models\Production::statusOptions()) }}
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </form>
</div>
