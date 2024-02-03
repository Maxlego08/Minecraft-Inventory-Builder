<?php

namespace App\Models\Payment;

use App\Models\Gift\GiftLog;
use App\Models\Resource\Resource;
use App\Models\User;
use App\Models\User\NameColor;
use App\Models\UserRole;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property bool $active
 * @property int $user_id
 * @property int $used
 * @property int $max_use
 * @property string $code
 * @property int $giftable_id
 * @property string $giftable_type
 * @property double $reduction
 * @property Resource $resource
 * @property UserRole $role
 * @property User $user
 * @property NameColor $nameColor
 */
class Gift extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'code',
        'giftable_type',
        'giftable_id',
        'active',
        'max_use',
        'used',
        'reduction',
        'user'
    ];

    /**
     * @return HasMany
     */
    public function logs(): HasMany
    {
        return $this->hasMany(GiftHistory::class);
    }

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsTo
     */
    public function resource(): BelongsTo
    {
        return $this->belongsTo(Resource::class, 'giftable_id');
    }

    /**
     * @return BelongsTo
     */
    public function role(): BelongsTo
    {
        return $this->belongsTo(UserRole::class, 'giftable_id');
    }

    /**
     * @return BelongsTo
     */
    public function nameColor(): BelongsTo
    {
        return $this->belongsTo(NameColor::class, 'giftable_id');
    }

    public function getContentName(): string
    {
        return match ($this->giftable_type) {
            Resource::class => $this->resource->name,
            UserRole::class => $this->role->name,
            NameColor::class => "<span class='{$this->nameColor->code}'>{$this->nameColor->translation()}</span>",
            default => 'Erreur !'
        };
    }

}

