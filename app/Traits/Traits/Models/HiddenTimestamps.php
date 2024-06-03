<?php

namespace App\Traits\Traits\Models;

trait HiddenTimestamps
{
    public function getHidden()
    {
        return ['created_at', 'updated_at'];
    }
}
