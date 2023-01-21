<div class="grid grid-cols-6 gap-6">
    <!-- Name -->
    <div class="col-span-6 sm:col-span-2">
        <x-jet-label for="name" value="{{ __('Ф.И.О') }}" />
        <x-jet-input id="name" type="text" class="mt-1 block w-full" wire:model.defer="customer.name" />
        <x-jet-input-error for="customer.name" class="mt-2" />
    </div>
    <!-- Address -->
    <div class="col-span-6">
        <x-jet-label for="address" value="{{ __('Адрес доставки документов') }}" />
        <textarea id="address"
                  rows="3"
                  class="form-input rounded-md shadow-sm block w-full"
                  wire:model="customer.address"></textarea>
        <x-jet-input-error for="customer.address" class="mt-2" />
    </div>
    <!-- Contacts -->
    <div class="col-span-6">
        <x-livewire.contacts.contacts-fields :contacts="$contacts" />
    </div>
</div>
