<?php

namespace App\Http\Livewire\Users;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Laravel\Jetstream\Jetstream;
use Livewire\Component;
use Illuminate\Support\Facades\Hash;

class UserForm extends Component
{
    public User $user;
    public $password;

    public function rules(): array
    {
        return [
            'user.name' => ['required', 'string', 'max:255'],
            'password' => [
                'nullable',
                'string',
                'min:6',
                'max:191'
            ],
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
        if (!$this->user->id && !$this->password) {
            $this->password = Str::random(8);
        }

        if ($this->password) {
            $this->user->password = Hash::make($this->password);
        }

        $this->user->save();

        $this->emit('saved');

        if ($this->user->id === Auth::id()) {
            $this->emit('refresh-navigation-dropdown');
        }
    }
}
