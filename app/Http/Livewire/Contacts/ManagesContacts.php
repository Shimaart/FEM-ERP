<?php

namespace App\Http\Livewire\Contacts;

use App\Concerns\HasContacts;
use App\Models\Contact;
use Illuminate\Validation\Rule;

trait ManagesContacts
{
    public array $contacts = [];

    /**
     * @return HasContacts
     */
    protected abstract function contactable();

    public function mountManagesContacts(): void
    {
        $this->setContacts();
    }

    private function setContacts(): void
    {
        $this->contacts = $this->contactable()->contacts()->get()->toArray();
    }

    protected function contactsRules(): array
    {
        return [
            'contacts.*.id' => ['nullable', 'exists:contacts,id'],
            'contacts.*.type' => ['required', Rule::in(Contact::types())],
            'contacts.*.value' => ['required', 'string']
        ];
    }

    public function addContact(): void
    {
        $this->contacts[] = [
            'id' => null,
            'type' => Contact::TYPE_PHONE_NUMBER,
            'value' => ''
        ];
    }

    public function removeContact($index): void
    {
        unset($this->contacts[$index]);
    }

    protected function saveContacts(): void
    {
        $exists = $this->contactable()->contacts()->pluck('id');

        $saved = collect($this->contacts)->map(function ($data) {
            return $this->contactable()->contacts()->updateOrCreate([
                'id' => $data['id'] ?? 0
            ], $data)->id;
        });

        $this->contactable()->contacts()->whereIn('id', $exists->diff($saved))->delete();
    }
}
