<form wire:submit.prevent="submit">
    <div class="shadow overflow-hidden sm:rounded-md">
        <div class="px-4 py-5 bg-white sm:p-6">
            <div class="grid grid-cols-6 gap-6">
                <div class="col-span-6 sm:col-span-3">
                    <!-- Name -->
                    <x-jet-label for="name" value="{{ __('Название') }}" />
                    <x-jet-input id="name" type="text" class="mt-1 block w-full" wire:model.defer="costItem.name" />
                    <x-jet-input-error for="costItem.name" class="mt-2" />
                </div>

                <div class="col-span-6 sm:col-span-3">
                    <x-jet-label for="type" value="{{ __('Тип') }}" />
                    <select class="form-input rounded-md shadow-sm block w-full" wire:model.defer="costItem.type">
                        @foreach(\App\Models\CostItem::typeOptions() as $type => $label)
                            <option value="{{ $type }}">{{ $label }}</option>
                        @endforeach
                    </select>
                    <x-jet-input-error for="costItem.type" class="mt-2" />
                </div>
            </div>
        </div>

        <div class="flex items-center justify-end px-4 py-3 bg-gray-50 text-right sm:px-6">
            <x-jet-button>
                {{ __('Save') }}
            </x-jet-button>
        </div>
    </div>
</form>
