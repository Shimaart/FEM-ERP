<div>
    <form wire:submit.prevent="submit">
        <div class="shadow overflow-hidden sm:rounded-md">
            <div class="px-4 py-5 bg-white sm:p-6">
                <div class="grid grid-cols-6 gap-6">
                    <div class="col-span-6 sm:col-span-3">
                        <!-- Label -->
                        <x-jet-label for="name" value="{{ __('Название') }}" />
                        <x-jet-input id="name" type="text" class="mt-1 block w-full" wire:model.defer="attributeGroup.name" />
                        <x-jet-input-error for="attributeGroup.name" class="mt-2" />
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
</div>
