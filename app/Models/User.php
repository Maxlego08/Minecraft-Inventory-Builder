<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Alert\AlertUser;
use App\Models\Conversation\ConversationNotification;
use App\Models\Discord\DiscordNotification;
use App\Models\Payment\Payment;
use App\Models\Resource\Access;
use App\Models\Resource\Notification;
use App\Models\Resource\Resource;
use App\Models\User\NameColor;
use App\Models\User\NameColorAccess;
use App\Models\User\UserPaymentInfo;
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
 * @property int $name_color_id
 * @property string $email
 * @property string $name
 * @property string $link
 * @property string $profile_photo_path
 * @property string $profile_photo_path_large
 * @property string $banner_photo_path
 * @property string $two_factor_secret
 * @property string $two_factor_recovery_codes
 * @property Carbon $created_at
 * @property Carbon $two_factor_confirmed_at
 * @property Carbon $updated_at
 * @property DiscordUser $discord
 * @property AlertUser[] $alerts
 * @property Resource[] $resources
 * @property Notification[] $resourceNotifications
 * @property ConversationNotification $conversationNotifications
 * @property UserRole $role
 * @property Access $accesses
 * @property UserPaymentInfo $paymentInfo
 * @property NameColor $nameColor
 * @property File[] $files
 * @property DiscordNotification[] $webhooks
 * @property Payment[] $payments
 * @property NameColorAccess $names
 * @method static User find(int $id)
 * @method string getProfilePhotoUrlAttribute()
 * @method string getProfilePhotoLargeUrlAttribute()
 */
class User extends Authenticate
{
    use HasApiTokens, HasFactory, Notifiable, TwoFactorAuthenticatable, HasProfilePhoto;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['name', 'email', 'password', 'user_role_id', 'name_color_id'];

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
     * Retourne la liste des logs de l'utilisateur
     *
     * @return HasMany
     */
    public function logs(): HasMany
    {
        return $this->hasMany(UserLog::class);
    }

    /**
     * Retourne la liste des webhook discords de l'utilisateur
     *
     * @return HasMany
     */
    public function webhooks(): HasMany
    {
        return $this->hasMany(DiscordNotification::class);
    }

    /**
     * Retourne la liste des accès aux resources
     *
     * @return HasMany
     */
    public function accesses(): HasMany
    {
        return $this->hasMany(Access::class);
    }

    /**
     * Retourne les informations de paiement de l'utilisateur
     *
     * @return HasOne
     */
    public function paymentInfo(): HasOne
    {
        return $this->hasOne(UserPaymentInfo::class);
    }

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
     * Permet de retourner la couleur de l'utilisateur
     *
     * @return BelongsTo
     */
    public function nameColor(): BelongsTo
    {
        return $this->belongsTo(NameColor::class);
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
     * User payments
     *
     * @return HasMany
     */
    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    /**
     * User names
     *
     * @return HasMany
     */
    public function names(): HasMany
    {
        return $this->hasMany(NameColorAccess::class);
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

    public function createConversation(): string
    {
        return route('profile.conversations.create', ['user' => $this]);
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
     * @param bool $useCache
     * @return bool
     */
    public function hasAccess(Resource $resource, bool $useCache = true): bool
    {
        if ($this->cache('role')->isModerator() || $this->id === $resource->user_id || $resource->price == 0) {
            return true;
        }
        if ($useCache) {
            return Cache::remember("user.access::$this->id", 86400, function () use ($resource) {
                return Access::where('user_id', $this->id)->where('resource_id', $resource->id)->count() > 0;
            });
        } else {
            return Access::where('user_id', $this->id)->where('resource_id', $resource->id)->count() > 0;
        }
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
                'role' => $this->role,
                'color' => $this->nameColor,
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
     * user.resource_count
     * user.resource_access
     *
     * @param string $key
     * @return void
     */
    public function clear(string $key): void
    {
        Cache::forget("$key::$this->id");
    }

    /**
     * Adds a notification to the user if it does not exist
     *
     * @param Resource $resource
     * @return void
     */
    public function enableNotification(Resource $resource): void
    {
        $isExist = $this->resourceNotifications()->where('resource_id', $resource->id)->exists();
        if (!$isExist) {
            Notification::create(['user_id' => $this->id, 'resource_id' => $resource->id, 'unsubscribe' => Str::random(64),]);
        }
    }

    /**
     * Retourne la liste des notifications de l'utilisateur
     *
     * @return HasMany
     */
    public function resourceNotifications(): HasMany
    {
        return $this->hasMany(Notification::class);
    }

    public function isAdmin(): bool
    {
        return $this->role->power == UserRole::ADMIN;
    }

    function countResources(): int
    {
        return Cache::remember("user.resource_count::$this->id", 86400, function () {
            return $this->resources->count();
        });
    }

    function countAccess(): int
    {
        return Cache::remember("user.resource_access::$this->id", 86400, function () {
            return $this->accesses->count();
        });
    }

    function displayNameAndLink(bool $tooltip = true, ?string $customId = null): string
    {
        return "<a href='{$this->getProfileUrl()}' class='text-decoration-none'>{$this->displayName($tooltip, $customId)}</a>";
    }

    public function getProfileUrl(): string
    {
        return route('resources.author', ['user' => $this, 'slug' => $this->slug()]);
    }

    function displayName(bool $tooltip = true, ?string $customId = null, ?string $customCss = null): string
    {
        $tooltipCss = $tooltip ? 'username-tooltip' : '';
        $url = route('api.v1.tooltip', $this);
        $idElement = $customId == null ? '' : "id='$customId'";
        $css = $customCss == null ? '' : $customCss;

        if ($this->name_color_id) {
            $color = $this->cache('color')->code;
            return "<span $idElement class='username $tooltipCss $color $css' data-url='$url'>$this->name</span>";
        }

        return match ($this->cache('role')->power) {
            UserRole::ADMIN => "<span $idElement class='username $tooltipCss username-admin $css' data-url='$url'>$this->name</span>",
            UserRole::MODERATOR => "<span $idElement class='username $tooltipCss username-moderator $css' data-url='$url'>$this->name</span>",
            UserRole::PREMIUM => "<span $idElement class='username $tooltipCss username-premium $css' data-url='$url'>$this->name</span>",
            UserRole::PRO => "<span $idElement class='username $tooltipCss username-pro $css' data-url='$url'>$this->name</span>",
            UserRole::BANNED => "<span $idElement class='username $tooltipCss username-banned $css' data-url='$url'>$this->name</span>",
            default => "<span $idElement class='username $tooltipCss username-member $css' data-url='$url'>$this->name</span>"
        };
    }

    /**
     * Vérifier si l'utilisateur à des informations à afficher dans le tooltips
     *
     * @return bool
     */
    function hasTooltipInformations(): bool
    {
        $tooltipInformations = $this->getTooltipInformations();
        return $tooltipInformations['resources'] > 0 || $tooltipInformations['payments'] > 0;
    }

    function getTooltipInformations(): array
    {
        return Cache::remember("user.tooltip::$this->id", 300, function () {
            return ['resources' => $this->resources->count(), 'payments' => $this->payments->where('status', Payment::STATUS_PAID)->count(),];
        });
    }

    /**
     * Vérifier si le joueur à l'accès à la couleur
     *
     * @param NameColor $nameColor
     * @return bool
     */
    function hasNameAccess(NameColor $nameColor): bool
    {
        if ($this->cache('role')->isModerator()) return true;
        return $this->names->where('color_id', $nameColor->id)->count() > 0;
    }

}
