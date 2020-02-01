<?php

namespace App\Traits;

use App\Models\Setting;

trait SettingGroupRelation
{
    public function settings()
    {
        return $this->hasMany(Setting::class);
    }
}
