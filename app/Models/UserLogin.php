<?php

namespace App\Models;

use App\Traits\UserLoginRelation;
use Illuminate\Database\Eloquent\Model;

class UserLogin extends Model
{
    use UserLoginRelation;

    protected $fillable = [
        'ip_address', 'device', 'platform', 'browser'
    ];
}
