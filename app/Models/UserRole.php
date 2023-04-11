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

    protected $fillable = [
        'name',
        'total_size',
        'size',
        'allow_files',
        'max_resources',
        'premium_resources',
        'power',
        'is_banned'
    ];


    /**
     * Return the validator for an image
     *
     * @return string
     */
    public function getImageValidator(): string
    {
        return 'required|image|mimes:' . $this->allow_files . ',|max:' . ($this->size / 1000);
    }

    public function isModerator(): bool
    {
        return $this->power == self::ADMIN || $this->power == self::MODERATOR;
    }

    public function isAdmin(): bool
    {
        return $this->power == self::ADMIN;
    }
}
