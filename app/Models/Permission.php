<?php

namespace App\Models;

use App\Traits\PermissionRelation;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use PermissionRelation;

    protected $fillable = [
        'name', 'guard_name'
    ];
}
