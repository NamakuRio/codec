<?php

namespace App\Services;

use App\Models\Role;

class RoleService
{
    public function getAllRole()
    {
        $roles = Role::all();

        return $roles;
    }
}
