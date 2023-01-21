<?php

namespace App;

use Carbon\Carbon;

class Format
{
    public static function asDate(?Carbon $carbon): ?string
    {
        if (is_null($carbon)) {
            return null;
        }

        return $carbon->format('d/m/Y');
    }

    public static function asDateTime(?Carbon $carbon): ?string
    {
        if (is_null($carbon)) {
            return null;
        }

        return $carbon->format('d/m/Y H:i');
    }

    public static function asCurrency(?float $number): ?string
    {
        if (is_null($number)) {
            return null;
        }

        return number_format($number, 2, ',', ' ');
    }

    public static function asEnum($value, array $enum)
    {
        return $enum[$value] ?? null;
    }
}
