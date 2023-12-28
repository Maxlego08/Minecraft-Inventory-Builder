<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class UserRole
 * @package App\Models
 * @property int $id
 * @property string $name
 * @property int $total_size
 * @property int $size
 * @property int $power
 * @property int $max_resources
 * @property int $max_discord_webhook
 * @property double $price
 * @property boolean $is_banned
 * @property boolean $premium_resources
 * @property string $allow_files
 */
class UserRole extends Model
{
    use HasFactory;

    const BANNED = 0;
    const FREE = 1;
    const PREMIUM = 2;
    const PRO = 3;
    const MODERATOR = 50;
    const ADMIN = 100;

    const ICON_BANNED = "bi bi-shield-lock-fill";
    const ICON_MEMBER = "bi bi-person";
    const ICON_PREMIUM = "bi bi-balloon-heart-fill";
    const ICON_PRO = "bi bi-gem";
    const ICON_MODERATOR = "bi bi-hammer";
    const ICON_ADMIN = "bi bi-code-slash";

    protected $fillable = ['name', 'total_size', 'size', 'allow_files', 'max_resources', 'premium_resources', 'power', 'is_banned', 'max_inventories', 'max_folders', 'max_discord_webhook', 'price'];


    /**
     * Return the validator for an image
     *
     * @return string
     */
    public function getImageValidator(): string
    {
        return 'required|image|mimes:' . $this->allow_files . '|max:' . ($this->size / 1000);
    }

    /**
     * Return the validator for profil image
     *
     * @return string
     */
    public function getImageValidatorProfil(): string
    {
        if ($this->isPro()) {
            return 'required|image|mimes:jpeg,png,jpg,gif|max:' . ($this->size / 1000);
        } else {
            return 'required|image|mimes:jpeg,png,jpg|max:' . ($this->size / 1000);
        }
    }

    public function isPro(): bool
    {
        return $this->power >= self::PRO;
    }

    /**
     * Return the validator for banner image
     *
     * @return string
     */
    public function getImageValidatorBanner(): string
    {
        return 'required|image|mimes:jpeg,png,jpg|max:' . ($this->size / 1000);
    }

    public function isModerator(): bool
    {
        return $this->power == self::ADMIN || $this->power == self::MODERATOR;
    }

    public function isAdmin(): bool
    {
        return $this->power == self::ADMIN;
    }

    public function isBanned(): bool
    {
        return $this->power == self::BANNED;
    }

    public function isMember(): bool
    {
        return $this->power <= self::FREE;
    }

    public function getRoleIcon(): string
    {
        return match ($this->power) {
            self::ADMIN => "<span class='btn-role btn-admin rounded-1'><i class='me-2 " . self::ICON_ADMIN . "'></i>$this->name</span>",
            self::MODERATOR => "<span class='btn-role btn-moderator rounded-1'><i class='me-2 " . self::ICON_MODERATOR . "'></i>$this->name</span>",
            self::PRO => "<span class='btn-role btn-pro rounded-1'><i class='me-2 " . self::ICON_PRO . "'></i>$this->name</span>",
            self::PREMIUM => "<span class='btn-role btn-premium rounded-1'><i class='me-2 " . self::ICON_PREMIUM . "'></i>$this->name</span>",
            self::BANNED => "<span class='btn-role btn-banned rounded-1'><i class='me-2 " . self::ICON_BANNED . "'></i>$this->name</span>",
            default => "<span class='btn-role btn-member rounded-1'><i class='me-2 " . self::ICON_MEMBER . "'></i>$this->name</span>",
        };
    }

}
