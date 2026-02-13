<?php

namespace App\Support;

class Currency
{
    public static function format(float $amount, float $rate, string $symbol, int $decimals = 2): string
    {
        $value = $amount * $rate;

        return $symbol . number_format($value, $decimals);
    }
}
