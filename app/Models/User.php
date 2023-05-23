<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Affiliates\Affiliate;
use App\Models\Alert\AlertUser;
use App\Models\Conversation\ConversationNotification;
use App\Models\Resource\Access;
use App\Models\Resource\Resource;
use App\Models\Webhook\Webhook;
use App\Traits\HasProfilePhoto;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticate;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Sanctum\HasApiTokens;

/**
 * Class User
 * @package App\Models
 * @property int $id
 * @property string $email
 * @property string $name
 * @property string $link
 * @property string $profile_photo_path
 * @property string $two_factor_secret
 * @property string $two_factor_recovery_codes
 * @property Carbon $created_at
 * @property Carbon $two_factor_confirmed_at
 * @property Carbon $updated_at
 * @property DiscordUser $discord
 * @property AlertUser[] $alerts
 * @property ConversationNotification $conversationNotifications
 * @property UserRole $role
 * @method static User find(int $id)
 * @method string getProfilePhotoUrlAttribute()
 */
class User extends Authenticate
{
    use HasApiTokens, HasFactory, Notifiable, TwoFactorAuthenticatable, HasProfilePhoto;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['name', 'email', 'password', 'user_role_id'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = ['password', 'remember_token',];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = ['email_verified_at' => 'datetime'];

    /**
     * Permet de retourner le lien du compte discord de l'utilisateur
     *
     * @return HasOne
     */
    public function discord(): HasOne
    {
        return $this->hasOne(DiscordUser::class);
    }

    /**
     * Retourne la couleur en fonction de l'espace disque utilisé
     *
     * @param bool $isAdmin
     * @return string
     */
    public function getDiskColor(bool $isAdmin = false): string
    {
        $userSize = $this->role->total_size;
        $size = $this->getDiskSize();

        $percent20 = (20 / 100) * $userSize;
        $percent10 = (10 / 100) * $userSize;

        if ($size >= $userSize - $percent10) {
            return "#e7321e";
        } else if ($size >= $userSize - $percent20) {
            return "#e57f18";
        } else {
            return $isAdmin ? "#858796" : "white";
        }
    }

    /**
     * Calculate the size of user's image
     *
     * @return mixed
     */
    public function getDiskSize(): mixed
    {
        return $this->images()->sum('file_size');
    }

    /**
     * User files
     *
     * @return Collection
     */
    public function images(): Collection
    {
        return $this->files->whereIn('file_extension', File::IMAGE);
    }

    /**
     * User files
     *
     * @return HasMany
     */
    public function files(): HasMany
    {
        return $this->hasMany(File::class);
    }

    /**
     * Retourne-les alerts
     *
     * @return HasMany
     */
    public function alerts(): HasMany
    {
        return $this->hasMany(AlertUser::class);
    }


    /**
     * @return HasMany
     */
    public function resources(): HasMany
    {
        return $this->hasMany(Resource::class);
    }

    /**
     * @return HasMany
     */
    public function conversationNotifications(): HasMany
    {
        return $this->hasMany(ConversationNotification::class);
    }

    /**
     * User role
     *
     * @return BelongsTo
     */
    public function role(): BelongsTo
    {
        return $this->belongsTo(UserRole::class, 'user_role_id');
    }

    /**
     * Permet de retourner le lien d'authentification discord de l'utilisateur
     *
     * @return string
     */
    public function getDiscordAuthLink(): string
    {
        $api = route('api.v1.discord');
        $client_id = env('DISCORD_CLIENT_ID');
        return 'https://discord.com/api/oauth2/authorize?client_id=' . $client_id . '&redirect_uri=' . urlencode($api) . '&response_type=code&scope=identify&state=' . $this->id;
    }

    public function getProfileUrl(): string
    {
        return route('resources.author', ['user' => $this, 'slug' => $this->slug()]);
    }

    /**
     * Return the path to the image
     *
     * @return string
     */
    public function getImagesPath(): string
    {
        return imagesPath($this->id);
    }

    /**
     * Return author page
     *
     * @return string
     */
    public function authorPage(): string
    {
        return route('resources.author', ['slug' => $this->slug(), 'user' => $this->id]);
    }

    /**
     * username as slug
     *
     * @return string
     */
    public function slug(): string
    {
        return Str::slug($this->name);
    }

    /**
     * Check if player has access to this resource
     *
     * @param Resource $resource
     * @return bool
     */
    public function hasAccess(Resource $resource): bool
    {
        if ($this->cache('role')->isModerator() || $this->id === $resource->user_id || $resource->price == 0) {
            return true;
        }
        return Cache::remember("user.access::$this->id", 86400, function () use ($resource) {
            return Access::where('user_id', $this->id)->where('resource_id', $resource->id)->count() > 0;
        });
    }

    /**
     * Cache system
     *
     * user.role
     *
     * @param string $key
     * @return mixed
     */
    public function cache(string $key): mixed
    {
        return Cache::remember("user.$key::$this->id", 86400, function () use ($key) {
            return match ($key) {
                "role" => $this->role,
                default => ""
            };
        });
    }

    /**
     * Check if player has access to this resource
     *
     * @param Resource $resource
     * @return bool
     */
    public function hasAccessWithoutCache(Resource $resource): bool
    {
        if ($this->cache('role')->isModerator() || $this->id === $resource->user_id || $resource->price == 0) {
            return true;
        }
        return Access::where('user_id', $this->id)->where('resource_id', $resource->id)->count() > 0;
    }

    /**
     * Delete cache value for user
     *
     * user.access
     *
     * @param string $key
     * @return void
     */
    public function clear(string $key)
    {
        Cache::forget("$key::$this->id");
    }
}
