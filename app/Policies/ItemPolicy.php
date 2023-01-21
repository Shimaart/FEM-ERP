<?php

namespace App\Policies;

use App\Models\Item;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ItemPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return $user->hasPermission('view any items');
    }

    public function view(User $user, Item $item)
    {
        return $user->hasPermission('view any items');
    }

    public function create(User $user)
    {
        return $user->hasPermission('create any items');
    }

    public function update(User $user, Item $item)
    {
        return $user->hasPermission('update any items');
    }

    public function delete(User $user, Item $item)
    {
        return $user->hasPermission('delete any items');
    }

//    public function restore(User $user, Item $item)
//    {
//        //
//    }
//
//    public function forceDelete(User $user, Item $item)
//    {
//        //
//    }
}
