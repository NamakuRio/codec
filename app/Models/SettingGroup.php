<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SettingGroup extends Model
{
    protected $fillable = [
        'name', 'slug', 'description', 'icon', 'order'
    ];
}
