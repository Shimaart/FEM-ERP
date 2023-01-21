<form wire:submit.prevent="submit">
    <div class="shadow overflow-hidden sm:rounded-md">
        <div class="px-4 py-5 bg-white sm:p-6">
            <div class="grid grid-cols-6 gap-6">
                <div class="col-span-6 sm:col-span-2">
                    <!-- Name -->
                    <x-jet-label for="name" value="{{ __('Название') }}" />
                    <x-jet-input id="name" type="text" class="mt-1 block w-full" wire:model.defer="itemCategory.name" />
                    <x-jet-input-error for="itemCategory.name" class="mt-2" />
                </div>
                <div class="col-span-6 sm:col-span-2">
                    <!-- Name -->
                    <x-jet-label for="slug" value="{{ __('Ссылка') }}" />
                    <x-jet-input id="slug" type="text" class="mt-1 block w-full" wire:model.defer="itemCategory.slug" />
                    <x-jet-input-error for="itemCategory.slug" class="mt-2" />
                </div>
                <div class="col-span-6 sm:col-span-2">
                    <!-- Name -->
                    <x-jet-label for="sort" value="{{ __('Порядок сортировки') }}" />
                    <x-jet-input id="sort" type="text" class="mt-1 block w-full" wire:model.defer="itemCategory.sort" />
                    <x-jet-input-error for="itemCategory.sort" class="mt-2" />
                </div>

                <div class="col-span-6 sm:col-span-2">
                    <!-- Name -->
                    <label class="inline-flex items-center mt-3">
                        <input name="list_ids" type="checkbox" class="form-checkbox h-5 w-5 text-gray-600" wire:model="itemCategory.display_in_items">
                        <span class="ml-2 text-gray-700">Показывать в производстве</span>
                    </label>
                </div>

                <div class="col-span-6 sm:col-span-2">
                    <!-- Name -->
                    <label class="inline-flex items-center mt-3">
                        <input name="list_ids" type="checkbox" class="form-checkbox h-5 w-5 text-gray-600" wire:model="itemCategory.display_in_orders">
                        <span class="ml-2 text-gray-700">Показывать в заказах</span>
                    </label>
                </div>

            </div>
        </div>

        <div class="flex items-center justify-end px-4 py-3 bg-gray-50 text-right sm:px-6">
            <x-jet-action-message class="mr-3" on="saved">
                {{ __('Saved.') }}
            </x-jet-action-message>

            <x-jet-button>
                {{ __('Save') }}
            </x-jet-button>
        </div>
    </div>
</form>
