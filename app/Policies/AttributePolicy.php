<?php

namespace App\Policies;

use App\Models\Attribute;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AttributePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        //
    }

    public function view(User $user, Attribute $attribute)
    {
        //
    }

    public function create(User $user)
    {
        //
    }

    public function update(User $user, Attribute $attribute)
    {
        //
    }

    public function delete(User $user, Attribute $attribute)
    {
        return $user->hasPermission('delete any attributes');
    }
}
