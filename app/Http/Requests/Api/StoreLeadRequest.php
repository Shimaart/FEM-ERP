<?php

namespace App\Http\Requests\Api;

use App\Models\Contact;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreLeadRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
            'contacts.*.type' => ['required', Rule::in(Contact::types())],
            'contacts.*.value' => ['required', 'string'],
            'note' => ['nullable', 'string'],
            'referrer' => ['nullable', 'string'],
        ];
    }
}
