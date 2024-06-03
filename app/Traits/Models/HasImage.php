<?php

namespace App\Traits\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;

trait HasImage
{

    protected function image(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => !$value ? null : (request()->expectsJson() ? asset('storage/' . $value) : $value),
        );
    }
}
