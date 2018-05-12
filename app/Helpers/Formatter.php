<?php

namespace App\Helpers;

/**
*
*/
class Formatter
{
    public static function toMoney($amount)
    {
        return config('app.currency_symbol', '£') . \number_format($amount, config('app.currency_decimals', '2'));
    }

    public static function toMoneyShort($amount)
    {
        return config('app.currency_symbol', '£') . round($amount);
    }

    public static function toStep($decimalPlaces)
    {
        return '.' . str_repeat('0', $decimalPlaces - 1) . '1';
    }
}
