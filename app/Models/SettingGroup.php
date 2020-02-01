<?php

namespace App\Models;

use App\Traits\SettingGroupRelation;
use Illuminate\Database\Eloquent\Model;

class SettingGroup extends Model
{
    use SettingGroupRelation;

    protected $fillable = [
        'name', 'slug', 'description', 'icon', 'order'
    ];
}
