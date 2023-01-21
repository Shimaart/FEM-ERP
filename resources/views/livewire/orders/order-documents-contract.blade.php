<div class="inline-block">

    <x-jet-button type="button" wire:click="$set('managingDocumentParameters', true)">
        <x-heroicon-o-download class="-ml-1 mr-2 w-4 h-4" />
        {{ __('Создать отчет') }}
    </x-jet-button>


    <x-jet-dialog-modal wire:model="managingDocumentParameters">
        <x-slot name="title">
            {{ __('Создать отчет') }}
        </x-slot>

        <x-slot name="content">
            <form wire:submit.prevent="submit">
                <div class="grid grid-cols-6 gap-6">
                    <div class="col-span-6 sm:col-span-2">
                        <select class="form-select rounded-md shadow-sm w-full" wire:model="tax">
                            @foreach(\App\Models\Order::taxOptions() as $value => $label)
                                <option value="{{ $value }}">{{ $label }}</option>
                            @endforeach
                        </select>
                        <x-jet-input-error for="tax" class="mt-2" />
                    </div>

                    <div class="col-span-6">
                        <div class="flex flex-col">
                            <x-jet-label value="{{ __('Продукция') }}" />
                            @foreach($this->itemCategories as $itemCategory)
                                <label class="inline-flex items-center mt-3">
                                    <input type="checkbox" class="form-checkbox h-5 w-5 text-gray-600" wire:model="selectedCategories" value="{{ $itemCategory->id }}">
                                    <span class="ml-2 text-gray-700">{{ $itemCategory->name }}</span>
                                </label>
                            @endforeach
                            <x-jet-input-error for="selectedTypes" class="mt-2" />
                            <x-jet-input-error for="selectedTypes.*" class="mt-2" />
                        </div>
                    </div>
                </div>
            </form>
        </x-slot>

        <x-slot name="footer">
            <div class="flex items-center justify-end">
                <x-jet-secondary-button wire:click="$set('managingDocumentParameters', false)" wire:loading.attr="disabled">
                    {{ __('Nevermind') }}
                </x-jet-secondary-button>

                <x-jet-button class="ml-2" wire:click="generate" wire:loading.attr="disabled">
                    <x-heroicon-o-download class="-ml-1 mr-2 w-4 h-4" />
                    {{ __('Скачать документ') }}
                </x-jet-button>
            </div>
        </x-slot>
    </x-jet-dialog-modal>
</div>
