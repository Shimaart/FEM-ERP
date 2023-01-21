<div>
    @foreach($contacts as $index => $contact)
        <div wire:key="contact-field-{{ $index }}" class="mb-2">
            <div class="flex items-center justify-content-between">
                <select wire:model.defer="contacts.{{ $index }}.type" class="form-select mr-2">
                    @foreach(\App\Models\Contact::typeOptions() as $value => $label)
                        <option value="{{ $value }}">{{ $label }}</option>
                    @endforeach
                </select>
                <x-jet-input type="text" class="block w-full mr-2" wire:model.defer="contacts.{{ $index }}.value" />
                <button wire:click.prevent="removeContact({{ $index }})" class="cursor-pointer">
                    <x-heroicon-o-trash class="w-5 h-5 text-red-500" />
                </button>
            </div>
            <x-jet-input-error for="contacts.{{ $index }}.value" class="mt-2" />
        </div>
    @endforeach
    <x-jet-button type="button" wire:click.prevent="addContact">
        {{ __('Добавить контакт') }}
    </x-jet-button>
</div>
