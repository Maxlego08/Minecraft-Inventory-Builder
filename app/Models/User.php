<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Affiliates\Affiliate;
use App\Models\Alert\AlertUser;
use App\Models\Payment\Payment;
use App\Models\Webhook\Webhook;
use App\Traits\HasProfilePhoto;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticate;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Sanctum\HasApiTokens;

/**
 * Class User
 * @package App\Models
 * @property int $id
 * @property string $email
 * @property string $name
 * @property string $profile_photo_path
 * @property string $two_factor_secret
 * @property string $two_factor_recovery_codes
 * @property Carbon $created_at
 * @property Carbon $two_factor_confirmed_at
 * @property Carbon $updated_at
 * @property DiscordUser $discord
 * @property AlertUser[] $alerts
 * @method static User find(int $id)
 */
class User extends Authenticate
{
    use HasApiTokens, HasFactory, Notifiable, TwoFactorAuthenticatable, HasProfilePhoto;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['name', 'email', 'password',];

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
    protected $casts = ['email_verified_at' => 'datetime',];

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
     * Retourne les alerts
     *
     * @return HasMany
     */
    public function alerts(): HasMany
    {
        return $this->hasMany(AlertUser::class);
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
}
