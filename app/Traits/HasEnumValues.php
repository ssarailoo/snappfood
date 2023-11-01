<?php

namespace App\Traits;

trait HasEnumValues
{
    public static function getValues(): array
    {
        return array_map(fn($value) => $value->value, self::cases());
    }

}
