<?php

namespace App\Models;

use Laravel\Jetstream\Role;

class GuestRole extends Role
{
    public function __construct()
    {
        parent::__construct('guest', __('Без роли'), []);
    }
}
