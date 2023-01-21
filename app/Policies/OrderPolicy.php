<?php

namespace App\Policies;

use App\Models\Order;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class OrderPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return $user->hasPermission('view any orders');
    }

    public function view(User $user, Order $order)
    {
        return $user->hasPermission('view any orders');
    }

    public function create(User $user)
    {
        return $user->hasPermission('create any orders');
    }

    public function update(User $user, Order $order)
    {
        return $user->hasPermission('update any orders');
    }

    public function delete(User $user, Order $order)
    {
        return $user->hasPermission('delete any orders');
    }

//    public function restore(User $user, Order $order)
//    {
//        //
//    }
//
//    public function forceDelete(User $user, Order $order)
//    {
//        //
//    }
}
