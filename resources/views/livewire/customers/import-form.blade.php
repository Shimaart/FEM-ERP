<div>
    <form wire:submit.prevent="submit">
        <div class="shadow overflow-hidden sm:rounded-md">
            <div class="px-4 py-5 bg-white sm:p-6">
                <div class="grid grid-cols-6 gap-6">
                    <div class="col-span-6 sm:col-span-3">
                        <!-- Symbol -->
                        <x-jet-label for="file" value="{{ __('Символ') }}" />
                        <x-jet-input id="file" type="file" class="mt-1 block w-full" wire:model.defer="file" />
                        <x-jet-input-error for="file" class="mt-2" />
                    </div>
                </div>
            </div>
            <div class="flex items-center justify-end px-4 py-3 bg-gray-50 text-right sm:px-6">
                <x-jet-action-message class="mr-3" on="unitSaved">
                    {{ __('Saved.') }}
                </x-jet-action-message>

                <x-jet-button>
                    {{ __('Save') }}
                </x-jet-button>
            </div>
        </div>
    </form>
</div>
