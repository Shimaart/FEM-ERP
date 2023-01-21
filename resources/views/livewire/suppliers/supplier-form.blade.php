<form wire:submit.prevent="submit">
    <div class="shadow overflow-hidden sm:rounded-md">
        <div class="px-4 py-5 bg-white sm:p-6">
            <div class="grid grid-cols-6 gap-6">
                <!-- Name -->
                <div class="col-span-6 sm:col-span-2">
                    <x-jet-label for="name" value="{{ __('Название') }}" />
                    <x-jet-input id="name" type="text" class="mt-1 block w-full" wire:model.defer="supplier.name" />
                    <x-jet-input-error for="supplier.name" class="mt-2" />
                </div>
                <!-- Contact Name -->
                <div class="col-span-6 sm:col-span-2">
                    <x-jet-label for="contact_name" value="{{ __('Контактное лицо') }}" />
                    <x-jet-input id="contact_name" type="text" class="mt-1 block w-full" wire:model.defer="supplier.contact_name" />
                    <x-jet-input-error for="supplier.contact_name" class="mt-2" />
                </div>
                <!-- Identifier -->
                <div class="col-span-6 sm:col-span-2">
                    <x-jet-label for="identifier" value="{{ __('ЕГРПОУ') }}" />
                    <x-jet-input id="identifier" type="text" class="mt-1 block w-full" wire:model.defer="supplier.identifier" />
                    <x-jet-input-error for="supplier.identifier" class="mt-2" />
                </div>
                <!-- Address -->
                <div class="col-span-6">
                    <x-jet-label for="address" value="{{ __('Адрес доставки документов') }}" />
                    <textarea id="address"
                              rows="3"
                              class="form-input rounded-md shadow-sm block w-full"
                              wire:model="supplier.address"></textarea>
                    <x-jet-input-error for="supplier.address" class="mt-2" />
                </div>
                <!-- Contacts -->
                <div class="col-span-6">
                    <x-livewire.contacts.contacts-fields :contacts="$contacts" />
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
