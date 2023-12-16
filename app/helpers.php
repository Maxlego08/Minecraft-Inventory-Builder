<?php

use App\Models\Alert\AlertUser;
use App\Models\Resource\Resource;
use App\Models\User;
use App\Models\UserLog;
use App\Payment\PaymentManager;
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

if (!function_exists('simple_date')) {
    function simple_date(Carbon $date): string
    {
        return $date->translatedFormat('M d, Y');
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
if (!function_exists('reviewScores')) {
    function reviewScores($score): string
    {
        $stars = '';
        for ($i = 1; $i <= 5; $i++) {
            if ($score >= $i) {
                $stars .= '<i class="bi bi-star-fill"></i>';
            } else if ($score >= ($i - 0.5)) {
                $stars .= '<i class="bi bi-star-half"></i>';
            } else {
                $stars .= '<i class="bi bi-star"></i>';
            }
        }
        return $stars;
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
    function format(Carbon $carbon): string
    {
        #https://carbon.nesbot.com/docs/#api-comparison
        $now = Carbon::now();
        if ($carbon->greaterThan($now->addHours(-4))) return $carbon->diffForHumans(); else if ($carbon->dayOfYear === $now->dayOfYear) {
            return __('Today at') . ' ' . $carbon->format('H:m');
        }
        return $carbon->format('d M. Y');
    }
}

if (!function_exists('isRoute')) {
    function isRoute(string ...$patterns)
    {
        return Route::currentRouteNamed(...$patterns) ? '-active' : '';
    }
}

if (!function_exists('dependencies')) {
    function dependencies(string $string): string
    {
        $values = explode(' ', $string);
        foreach ($values as $value) {
            $string = str_replace($value, replaceDependency($value), $string);
        }
        return $string;
    }
}

if (!function_exists('replaceDependency')) {
    function replaceDependency(string $string): string
    {
        return match (str_replace(',', '', strtolower($string))) {
            "itemadder" => "<a href='https://www.spigotmc.org/resources/73355/' target='_blank'>$string</a>",
            "hdb", "headdatabase" => "<a href='https://www.spigotmc.org/resources/14280/' target='_blank'>$string</a>",
            "oraxen" => "<a href='https://www.spigotmc.org/resources/72448/' target='_blank'>$string</a>",
            "zauctionhouse" => "<a href='https://www.spigotmc.org/resources/63010/' target='_blank'>$string</a>",
            "placeholderapi", "placeholder" => "<a href='https://www.spigotmc.org/resources/6245/' target='_blank'>$string</a>",
            "vault" => "<a href='https://www.spigotmc.org/resources/34315/' target='_blank'>$string</a>",
            "protocollib", "protocolib" => "<a href='https://www.spigotmc.org/resources/1997/' target='_blank'>$string</a>",
            "advancedheads", "advancedhead" => "<a href='https://www.spigotmc.org/resources/101876/' target='_blank'>$string</a>",
            "luckperm", "luckperms", => "<a href='https://www.spigotmc.org/resources/28140/' target='_blank'>$string</a>",
            default => $string
        };
    }
}

if (!function_exists('getIpV4')) {
    function getIpV4(): string
    {
        return request()->headers->get('cf-connecting-ip') ?? '0.0.0.0';
    }
}

if (!function_exists('userLog')) {
    function userLog(string $action, string $color, string $icon, int $type = UserLog::TYPE_DEFAULT)
    {
        UserLog::make(user(), $action, $color, $icon, $type);
    }
}

if (!function_exists('userLogOffline')) {
    function userLogOffline($userId, string $action, string $color, string $icon, int $type = UserLog::TYPE_DEFAULT): void
    {
        UserLog::makeOffline($userId, $action, $color, $icon, $type);
    }
}

if (!function_exists('format_date_compact')) {
    function format_date_compact(Carbon $date): string
    {
        return $date->format('d/m/Y \à G:i');
    }
}

if (!function_exists('createAlert')) {
    function createAlert(int $user_id, string $content, string $icon, string $level, string $translation_key = null, string $link = null, int $target_id = null): AlertUser
    {
        return AlertUser::create([
            'user_id' => $user_id,
            'level' => $level,
            'content' => $content,
            'link' => $link,
            'icon' => $icon,
            'translation_key' => $translation_key,
            'target_id' => $target_id
        ]);
    }
}

/*
 * Payment Manager
 * */
if (!function_exists('paymentManager')) {
    function paymentManager(): PaymentManager
    {
        return app(PaymentManager::class);
    }
}

/*
 * Price format
 * */
if (!function_exists('resourcePrice')) {
    function resourcePrice(Resource $resource): string
    {
        return formatPrice($resource->price, $resource->user->paymentInfo?->currency->currency ?: 'eur');
    }
}

/*
 * Price format
 * */
if (!function_exists('formatPrice')) {
    function formatPrice($price, $currency): string
    {
        // Format the price to 2 decimal places
        $formattedPrice = number_format($price, 2, '.', ' ');

        // Add currency symbol based on the currency code
        return match (strtolower($currency)) {
            'eur' => $formattedPrice . '€',
            'gbp' => $formattedPrice . '£',
            'usd' => '$' . $formattedPrice,
            default => $formattedPrice . ' ' . strtoupper($currency),
        };
    }
}

/*
 * Price format
 * */
if (!function_exists('currency')) {
    function currency($currency): string
    {
        return match (strtolower($currency)) {
            'eur' => '€',
            'gbp' => '£',
            'usd' => '$',
            default => $currency,
        };
    }
}

/*
 * Price format
 * */
if (!function_exists('currencyIcon')) {
    function currencyIcon($currency): string
    {
        return match (strtolower($currency)) {
            'eur' => '<i class="bi bi-currency-euro"></i>',
            'gbp' => '<i class="bi bi-currency-pound"></i>',
            'usd' => '<i class="bi bi-currency-dollar"></i>',
            default => $currency,
        };
    }
}

/*
 * Price format
 * */
if (!function_exists('formatPriceWithId')) {
    function formatPriceWithId($price, $currency): string
    {
        // Format the price to 2 decimal places
        $formattedPrice = number_format($price, 2, '.', ' ');

        // Add currency symbol based on the currency code
        return match (strtolower($currency)) {
            'eur' => "<span data-price='$price' id='price'>$formattedPrice</span>€",
            'usd' => "$<span data-price='$price' id='price'>$formattedPrice</span>",
            'gbp' => "<span data-price='$price' id='price'>$formattedPrice</span>£",
            default => $formattedPrice . ' ' . strtoupper($currency),
        };
    }
}
