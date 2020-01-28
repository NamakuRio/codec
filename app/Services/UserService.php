<?php

namespace App\Services;

use App\Models\User;

class UserService
{
    public function getAllUser()
    {
        $users = User::all();

        return $users;
    }

    public function count($type = 'all')
    {
        $users = new User;
        if ($type == 'all') {
            $count = $users->get()->count();
        } else if ($type == 'inactive') {
            $count = $users->where('status', 0)->get()->count();
        } else if ($type == 'active') {
            $count = $users->where('status', 1)->get()->count();
        } else if ($type == 'blocked') {
            $count = $users->where('status', 2)->get()->count();
        }

        return $count;
    }
}
