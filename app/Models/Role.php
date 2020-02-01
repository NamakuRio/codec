<?php

namespace App\Models;

use App\Traits\RoleRelation;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use RoleRelation;

    protected $fillable = [
        'name', 'default_user', 'login_destination'
    ];
}
