<?php

namespace src\Services;

class CountryChecker
{
    const EU_COUNTRIES = [
        'AT',
        'BE',
        'BG',
        'CY',
        'CZ',
        'DE',
        'DK',
        'EE',
        'ES',
        'FI',
        'FR',
        'GR',
        'HR',
        'HU',
        'IE',
        'IT',
        'LT',
        'LU',
        'LV',
        'MT',
        'NL',
        'PO',
        'PT',
        'RO',
        'SE',
        'SI',
        'SK'
    ];

    public static function isEu(?string $countryCode): bool
    {
        return $countryCode ? in_array($countryCode, self::EU_COUNTRIES) : false;
    }
}