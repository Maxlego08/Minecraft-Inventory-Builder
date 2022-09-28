<?php

use App\Models\User;
use Carbon\Carbon;

if (!function_exists('user')) {
    function user(): User
    {
        return Auth::user();
    }
}

if (!function_exists('format_date')) {
    function format_date(Carbon $date, bool $fullTime = false, string $locale = 'fr_FR')
    {
        $date->locale($locale);
        return $date->translatedFormat(($fullTime ? 'j F Y \à G:i' : 'j F Y'));
    }
}
