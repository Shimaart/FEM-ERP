<form wire:submit.prevent="submit">
    <div class="shadow overflow-hidden sm:rounded-md">
        <div class="px-4 py-5 bg-white sm:p-6">
            <div class="grid grid-cols-6 gap-6">
                <div class="col-span-6 sm:col-span-2">
                    <!-- Name -->
                    <x-jet-label for="name" value="{{ __('Название') }}" />
                    <x-jet-input id="name" type="text" class="mt-1 block w-full" wire:model.defer="itemType.name" />
                    <x-jet-input-error for="itemType.name" class="mt-2" />
                </div>
                <div class="col-span-6 sm:col-span-4">
                    <label class="inline-flex items-center mt-8">
                        <input type="checkbox" class="form-checkbox h-5 w-5 text-gray-600" wire:model="itemType.in_title">
                        <span class="ml-2 text-gray-700">{{ __('Добавлять в название')}}</span>
                    </label>
                    <x-jet-input-error for="itemType.in_title" class="mt-2" />
                </div>
            </div>
        </div>

        <div class="flex items-center justify-end px-4 py-3 bg-gray-50 text-right sm:px-6">
            <x-jet-action-message class="mr-3" on="itemTypeSaved">
                {{ __('Saved.') }}
            </x-jet-action-message>

            <x-jet-button>
                {{ __('Save') }}
            </x-jet-button>
        </div>
    </div>
</form>
