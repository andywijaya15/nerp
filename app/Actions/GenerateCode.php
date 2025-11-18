<?php

namespace App\Actions;

use Illuminate\Support\Str;

class GenerateCode
{
    public static function execute(string $prefix)
    {
        return $prefix.strtoupper(Str::random(6));
    }
}
