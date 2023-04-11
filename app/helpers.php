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
    function format_date(Carbon $date, bool $fullTime = false, string $locale = 'en_US'): string
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

if (!function_exists('format')) {
    function format(Carbon $carbon): string
    {
        #https://carbon.nesbot.com/docs/#api-comparison
        $now = Carbon::now();
        if ($carbon->greaterThan($now->addHours(-4))) return $carbon->diffForHumans(); else if ($carbon->dayOfYear === $now->dayOfYear) {
            return __('messages.today_at') . ' ' . $carbon->format('H:m');
        } else if ($carbon->dayOfYear == Carbon::yesterday()->dayOfYear) {
            return __('messages.yesterday_at') . ' ' . $carbon->format('H:m');
        }
        return $carbon->format('d M. Y');
    }
}

/**
 * Retourne le chemin vers l'image
 *
 * @return string
 */
if (!function_exists('imagesPath')) {
    function imagesPath(int $id): string
    {
        // return 'images/' . ((int)($id / 10000)) . "/" . ((int)($id / 1000)) . "/" . ((int)($id / 100)) . '/' . $id . '/';
        return 'images/';
    }
}

/**
 * Retourne le chemin vers l'image
 *
 * @return string
 */
if (!function_exists('human_filesize')) {
    function human_filesize($size): string
    {
        if (!$size) {
            return '0B';
        }
        $units = array('B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');
        $i = floor(log($size, 1024));
        return round($size / pow(1024, $i), 2) . $units[$i];
    }

}

if (!function_exists('format')) {
    function format(Carbon $carbon)
    {
        #https://carbon.nesbot.com/docs/#api-comparison
        $now = Carbon::now();
        if ($carbon->greaterThan($now->addHours(-4)))
            return $carbon->diffForHumans();
        else if ($carbon->dayOfYear === $now->dayOfYear) {
            return __('Today at') . ' ' . $carbon->format('H:m');
        } else if ($carbon->dayOfYear == Carbon::yesterday()->dayOfYear) {
            return __('Yesterday at') . ' ' . $carbon->format('H:m');
        }
        return $carbon->format('d M. Y');
    }
}
