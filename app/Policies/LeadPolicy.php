<?php

namespace App\Policies;

use App\Models\Lead;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class LeadPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return $user->hasPermission('view any leads');
    }

    public function view(User $user, Lead $lead)
    {
        return $user->hasPermission('view any leads');
    }

    public function create(?User $user)
    {
        return $user->hasPermission('create any leads');
    }

    public function update(User $user, Lead $lead)
    {
        return $user->hasPermission('update any leads');
    }

    public function assignManager(User $user, Lead $lead)
    {
        return $user->hasPermission('assign any lead manager');
    }

    public function delete(User $user, Lead $lead)
    {
        return $user->hasPermission('delete any leads');
    }

    public function restore(User $user, Lead $lead)
    {
        //
    }

    public function forceDelete(User $user, Lead $lead)
    {
        //
    }
}
