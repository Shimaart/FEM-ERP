<?php

namespace App\Http\Livewire\Users;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Laravel\Jetstream\Jetstream;
use Livewire\Component;

class UserForm extends Component
{
    public User $user;

    public function rules(): array
    {
        return [
            'user.name' => ['required', 'string', 'max:255'],
            'user.email' => ['required', 'email', 'max:255'], // TODO
//            'user.email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($this->user)],
            'user.assigned_role' => [
                'nullable', Rule::in(collect(Jetstream::$roles)->pluck('key')->toArray())
            ]
        ];
    }

    public function getRolesProperty()
    {
        return Jetstream::$roles;
    }

    public function mount(User $user): void
    {
        $this->user = $user;
    }

    public function save(): void
    {
        $this->validate();

        $this->user->save();

        $this->emit('saved');

        if ($this->user->id === Auth::id()) {
            $this->emit('refresh-navigation-dropdown');
        }
    }
}
