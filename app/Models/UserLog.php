<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserLog extends Model
{
    use HasFactory;

    public const ICON_ADD = "fas fa-plus";
    public const ICON_SMS = "fas fa-sms";
    public const ICON_FILE = "fas fa-file-archive";
    public const ICON_STARS = "fas fa-star";
    public const ICON_DOWNLOAD = "fas fa-download";
    public const ICON_REMOVE = "fas fa-minus";
    public const ICON_CODE = "fas fa-code";
    public const ICON_EURO = "fas fa-euro-sign";
    public const ICON_VOTE = "fas fa-vote-yea";
    public const ICON_USER_CREATE = "fas fa-user-plus";
    public const ICON_USER_LOGIN = "fas fa-sign-in-alt";
    public const ICON_USER_LOGOUT = "fas fa-user-minus";
    public const ICON_PASSWORD = "fas fa-key";
    public const ICON_EMAIL = "fas fa-envelope";
    public const ICON_TRASH = "fas fa-trash";
    public const ICON_HEART = "fas fa-heart";
    public const ICON_HEART_BREAK = "fas fa-heart-broken";
    public const ICON_PREMIUM = "fas fa-sun";
    public const ICON_EDIT = "fas fa-edit";
    public const ICON_DOLLAR = "fas fa-dollar-sign";
    public const ICON_STRIPE = "fab fa-stripe-s";

    public const COLOR_SUCCESS = "#3CB371";
    public const COLOR_REGISTER = "#0b5037";
    public const COLOR_CONNEXION = "#0b5037";
    public const COLOR_DECONNEXION = "#0b5037";
    public const COLOR_INFO = "#36b9cc";
    public const COLOR_WARNING = "#f6c23e";
    public const COLOR_DANGER = "#e74a3b";
    public const COLOR_FOLLOW = "#BC153B";
    public const COLOR_PREMIUM = "#fcd020";

    public const TYPE_DEFAULT = 1;
    public const TYPE_CONNEXION = 2;
    public const TYPE_DECONNEXION = 3;
    public const TYPE_PAYMENT = 4;
    public const TYPE_SERVER = 5;
    public const TYPE_ADMIN = 6;
    public const TYPE_DISCORD = 7;
    public const TYPE_DEVELOPER = 8;

    protected $fillable = [
        'user_id',
        'ipv4',
        'ipv6',
        'action',
        'color',
        'icon',
        'type',
    ];

    /**
     * Retourne l'utilisateur lié au log
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Create new log
     *
     * @param User $user
     * @param string $action
     * @param string $color
     * @param string $icon
     * @param int $type
     * @return UserLog
     */
    public static function make(User $user, string $action, string $color, string $icon, int $type = self::TYPE_DEFAULT): UserLog
    {
        $ipV4 = getIpV4();
        return self::create([
            'user_id' => $user->id,
            'action' => $action,
            'color' => $color,
            'icon' => $icon,
            'type' => $type,
            'ipv4' => $ipV4,
        ]);
    }

    /**
     * Create new log
     *
     * @param $user
     * @param string $action
     * @param string $color
     * @param string $icon
     * @param int $type
     * @return UserLog
     */
    public static function makeOffline($userId, string $action, string $color, string $icon, int $type = self::TYPE_DEFAULT): UserLog
    {
        $ipV4 = "";
        return self::create([
            'user_id' => $userId,
            'action' => $action,
            'color' => $color,
            'icon' => $icon,
            'type' => $type,
            'ipv4' => $ipV4,
        ]);
    }

    /**
     * Create new log
     *
     * @param User $user
     * @param string $action
     * @param string $color
     * @param string $icon
     * @param int $type
     * @return UserLog
     */
    public static function makeWithoutIP(User $user, string $action, string $color, string $icon, int $type = self::TYPE_DEFAULT): UserLog
    {
        $ipV4 = "";
        return self::create([
            'user_id' => $user->id,
            'action' => $action,
            'color' => $color,
            'icon' => $icon,
            'ipv4' => $ipV4,
            'type' => $type,
        ]);
    }
}
