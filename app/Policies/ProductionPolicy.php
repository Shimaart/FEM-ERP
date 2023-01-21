<?php

namespace App\Policies;

use App\Models\Production;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductionPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return $user->hasPermission('view any productions');
    }

    public function view(User $user, Production $production)
    {
        return $user->hasPermission('view any productions');
    }

    public function create(User $user)
    {
        return $user->hasPermission('create any productions');
    }

    public function update(User $user, Production $production)
    {
        return $user->hasPermission('update any productions');
    }

    public function receive(User $user, Production $production)
    {
        return $user->hasPermission('receive any productions');
    }

    public function process(User $user, Production $production)
    {
        return $user->hasPermission('process any productions');
    }

    public function delete(User $user, Production $production)
    {
        return $user->hasPermission('delete any productions');
    }

//    public function restore(User $user, Production $production)
//    {
//        //
//    }
//
//    public function forceDelete(User $user, Production $production)
//    {
//        //
//    }
}
