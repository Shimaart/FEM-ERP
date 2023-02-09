<?php

namespace App\Http\Livewire\Users;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Laravel\Jetstream\Jetstream;
use Livewire\Component;
use Laravel\Fortify\Rules\Password;
use Laravel\Jetstream\ConfirmsPasswords;

class UserForm extends Component
{
    public $user_id;
    public $name;
    public $email;
    public $password;
    public $old_password;
    public $password_confirmation;
    public $assigned_role;
    public $permissions = [];


    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users'],
            'assigned_role' => ['required', 'string', 'max:255'],
            'password' => ['required_if:user_id,null', 'confirmed'],
            'password_confirmation' => ['nullable','required_with:password','same:password'],
            'assigned_role' => [
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
        $this->user_id = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->old_password = $user->password;
        $this->assigned_role = $user->assigned_role;
        $role = Jetstream::findRole((string)$this->assigned_role);
        $this->permissions = $role->permissions ?? [];

    }
    public function updatedAssignedRole()
    {
        $role = Jetstream::findRole((string)$this->assigned_role);
        $this->permissions = $role->permissions;
    }

    public function save(): void
    {
        $this->validate();

        $user = User::updateOrCreate(
            ['id' => $this->user_id],
            [
                'name' => $this->name,
                'email' => $this->email,
                'assigned_role'=> $this->assigned_role,
                'password'=> $this->password ? Hash::make($this->password) : $this->old_password
            ]
        );

        $this->emit('saved');
        $this->reset();

        if ($user->id === Auth::id()) {
            $this->emit('refresh-navigation-dropdown');
        }
    }

}
