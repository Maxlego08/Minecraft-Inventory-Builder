<?php

namespace App\Models\Discord;

use App\Models\Resource\Version;
use App\Models\User;
use App\Utils\Discord\Embed;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class DiscordNotification
 * @package App\Models
 * @property int $id
 * @property int $user_id
 * @property string $content
 * @property string $url
 * @property string $event
 * @property string $username
 * @property string $avatar_url
 * @property boolean $is_enable
 * @property boolean $is_valid
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property User $user
 * @property DiscordEmbed[] $embeds
 * @method static DiscordNotification find(int $id)
 */
class DiscordNotification extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'url', 'content', 'is_enable', 'is_valid', 'event', 'username', 'avatar_url',];

    /**
     * Discord embeds
     *
     * @return HasMany
     */
    public function embeds(): HasMany
    {
        return $this->hasMany(DiscordEmbed::class, 'discord_id');
    }

    /**
     * User
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

}
