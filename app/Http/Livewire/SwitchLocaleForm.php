<?php

namespace App\Http\Livewire;

use App\Concerns\LocaleAware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Livewire\Component;

class SwitchLocaleForm extends Component
{
    use LocaleAware;

    public string $locale;

    public function rules(): array
    {
        return [
            'locale' => [
                Rule::in($this->applicationLocales())
            ]
        ];
    }

    public function mount(): void
    {
        $this->locale = app()->getLocale();
    }

    public function getUserProperty()
    {
        return Auth::user();
    }

    public function updatedLocale($locale): void
    {
        $this->user->forceFill([
            'preferred_locale' => $locale
        ])->save();

        app()->setLocale($locale);
    }

    public function render()
    {
        return view('profile.switch-locale-form');
    }
}
