<?php

namespace App\Models;

use App\Traits\SettingRelation;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use SettingRelation;

    protected $fillable = [
        'name', 'value', 'default_value', 'type', 'comment', 'required', 'order'
    ];
}
