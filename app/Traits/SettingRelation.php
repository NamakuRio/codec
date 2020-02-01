<?php

namespace App\Traits;

use App\Models\SettingGroup;

trait SettingRelation
{
    public function settingGroup()
    {
        return $this->belongsTo(SettingGroup::class);
    }
}
