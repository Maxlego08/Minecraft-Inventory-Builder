<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Alert\AlertUser;
use App\Models\Conversation\ConversationAutoResponse;
use App\Models\Conversation\ConversationNotification;
use App\Models\Discord\DiscordNotification;
use App\Models\Payment\Payment;
use App\Models\Resource\Access;
use App\Models\Resource\Notification;
use App\Models\Resource\Resource;
use App\Models\Resource\Version;
use App\Models\User\Follow;
use App\Models\User\NameChangeHistory;
use App\Models\User\NameColor;
use App\Models\User\NameColorAccess;
use App\Models\User\UserPaymentInfo;
use App\Traits\HasProfilePhoto;
use App\Utils\Likeable;
use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticate;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Sanctum\HasApiTokens;

/**
 * Class User
 * @package App\Models
 * @property int $id
 * @property int $name_color_id
 * @property int $user_role_id
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
 * @property boolean $enable_conversation
 * @property DiscordUser $discord
 * @property AlertUser[] $alerts
 * @property Resource[] $resources
 * @property Notification[] $resourceNotifications
 * @property ConversationNotification $conversationNotifications
 * @property UserRole $role
 * @property Access $accesses
 * @property UserPaymentInfo $paymentInfo
 * @property NameColor $nameColor
 * @property ConversationAutoResponse $autoResponse
 * @property File[] $files
 * @property DiscordNotification[] $webhooks
 * @property Payment[] $payments
 * @property NameChangeHistory[] $nameChangeHistories
 * @property User[] $followers
 * @property User[] $followings
 * @property NameColorAccess[] $nameColorAccesses
 * @property NameColorAccess $names
 * @method static User find(int $id)
 * @method string getProfilePhotoUrlAttribute()
 * @method string getProfilePhotoLargeUrlAttribute()
 */
class User extends Authenticate implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, TwoFactorAuthenticatable, HasProfilePhoto;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['name', 'email', 'password', 'user_role_id', 'name_color_id', 'enable_conversation'];

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
     * Retourne la liste des couleurs que le joueur à accès
     *
     * @return HasMany
     */
    public function nameColorAccesses(): HasMany
    {
        return $this->hasMany(NameColorAccess::class);
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
     * Obtient l'historique des changements de nom de l'utilisateur.
     *
     * @return HasMany
     */
    public function nameChangeHistories(): HasMany
    {
        return $this->hasMany(NameChangeHistory::class);
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

    // Les utilisateurs qui suivent cet utilisateur
    public function followers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_follows', 'followed_id', 'follower_id');
    }

    public function followersTable(): Collection|array
    {
        return Follow::with('follower')->where('followed_id', $this->id)->orderBy('created_at', 'DESC')->get();
    }

    public function followingsTable(): Collection|array
    {
        return Follow::with('following')->where('follower_id', $this->id)->orderBy('created_at', 'DESC')->get();
    }

    // Les utilisateurs que cet utilisateur suit
    public function followings(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_follows', 'follower_id', 'followed_id');
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
     * Like de l'utilisateur
     *
     * @return HasMany
     */
    public function likes(): HasMany
    {
        return $this->hasMany(Like::class);
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

    /**
     * User auto message
     *
     * @return HasOne
     */
    public function autoResponse(): HasOne
    {
        return $this->hasOne(ConversationAutoResponse::class);
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
                'name_change' => $this->nameChangeHistories,
                'currency' => $this->paymentInfo?->currency->currency ?? 'eur',
                'followers' => $this->followers,
                'followings' => $this->followings,
                'followersTable' => $this->followersTable(),
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
     * user.color
     * user.name_change
     * user.currency
     * user.followings
     * user.followers
     * likes.total
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
        return $this->cache('role')->power == UserRole::ADMIN;
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
        $url = route('tooltip', $this);
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
        return $tooltipInformations['resources'] > 0 || $tooltipInformations['payments'] > 0 || $tooltipInformations['reactions'] > 0 || $tooltipInformations['followers'] > 0;
    }

    function getTooltipInformations(): array
    {
        return Cache::remember("user.tooltip::$this->id", 300, function () {
            return [
                'resources' => $this->resources->count(),
                'payments' => $this->payments->where('status', Payment::STATUS_PAID)->count(),
                'reactions' => $this->totalReceivedLikes(),
                'followers' => $this->cache('followers')->count(),
            ];
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

    public function getNameHistory(): string
    {
        $names = $this->cache('name_change')->pluck('old_name')->toArray();
        return implode(',', $names);
    }

    /**
     * Vérifie si l'utilisateur à liker un contenu spécifique.
     * Met en cache le résultat pendant 86400 secondes (1 jour).
     *
     * @param Likeable $likeable
     * @return bool Vrai si l'utilisateur a liké la ressource, sinon faux.
     */
    public function hasLiked(Likeable $likeable): bool
    {
        $type = match (true) {
            $likeable instanceof Resource => Resource::class,
            $likeable instanceof Version => Version::class,
            default => null
        };

        $cacheKey = "user_{$this->id}_{$likeable->getCacheName()}";

        return Cache::remember($cacheKey, 86400, function () use ($likeable, $type) {
            return $this->likes()
                ->where('likeable_id', $likeable->id)
                ->where('likeable_type', $type)
                ->exists();
        });
    }


    /**
     * Vérifier si l'utilisateur peut liker un contenu
     *
     * @param Likeable $likeable
     * @return bool
     */
    public function canLike(Likeable $likeable): bool
    {
        return match (true) {
                $likeable instanceof Resource => $likeable->user_id,
                $likeable instanceof Version => $likeable->resource->user_id,
                default => null
            } != $this->id || $this->cache('role')->isAdmin();
    }


    /**
     * Obtient le total des likes reçus sur les ressources et les versions de l'utilisateur.
     *
     * @return int
     */
    public function totalReceivedLikes(): int
    {
        return Cache::remember("likes.total::$this->id", 86400, function () {
            // Requête pour les likes sur les ressources
            $resourceLikes = Like::whereHas('likeable', function ($query) {
                $query->whereIn('id', $this->resources->pluck('id'))
                    ->where('likeable_type', Resource::class);
            });

            // Requête pour les likes sur les versions des ressources
            $versionLikes = Like::whereHasMorph('likeable', [Version::class], function ($query) {
                $resourceIds = $this->resources->pluck('id');
                $query->whereIn('resource_id', $resourceIds);
            });

            // Combine les deux requêtes en utilisant une union
            return DB::query()->fromSub($resourceLikes->union($versionLikes), 'combined_likes')->count();
        });
    }


}
