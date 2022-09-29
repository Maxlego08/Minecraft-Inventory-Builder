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

if (!function_exists('createToast')) {
    /**
     * type = text / log / info / warn / error / success
     *
     * @param string $type
     * @param string $title
     * @param string $description
     * @param int $duration
     * @return array
     */
    function createToast(string $type = "success", string $title = "", string $description = "", int $duration = 3000): array
    {
        return ['type' => $type, 'title' => $title, 'description' => $description, 'duration' => $duration,];
    }
}
