<?php

namespace App;

use Laravel\Jetstream\Jetstream;
use Laravel\Jetstream\Role;

class Utils
{
    public static function findRolesByPermissions(...$permissions): array
    {
        return collect(Jetstream::$roles)
            ->filter(fn (Role $role) => count(array_intersect($role->permissions, $permissions)) > 0)
            ->toArray();
    }
}
