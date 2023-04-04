<?php

namespace App\Models;

use Carbon\Carbon;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Http;

/**
 * @property int $id
 * @property string $discord_id
 * @property string $avatar
 * @property string $username
 * @property string $email
 * @property string $discriminator
 * @property string $access_token
 * @property string $refresh_token
 * @property boolean $is_valid
 * @property Carbon $expired_at
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property User $user
 */
class DiscordUser extends Model
{
    use HasFactory;

    public const TOKEN_URL = "https://discord.com/api/oauth2/token";
    public const TOKEN_REVOKE_URL = "https://discord.com/api/oauth2/token/revoke";
    public const API_URL = "https://discord.com/api/users/@me";
    public const AVATAR_URL = "https://cdn.discordapp.com/avatars/%s/%s";
    public const DIFF_SECONDS = 60 * 5; // On va vérifier toute les 5 minutes.

    protected $fillable = ['user_id', 'discord_id', 'access_token', 'refresh_token', 'expired_at', 'email', 'username', 'discriminator', 'avatar', 'is_valid',];

    protected $casts = ['created_at' => 'datetime', 'expired_at' => 'datetime', 'updated_at' => 'datetime'];


    /**
     * Retourne l'utilisateur
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Retourne l'avatar de l'utilisateur
     *
     * @return string
     */
    public function getAvatar(): string
    {
        // Si l'avatar est pas bon
        if ($this->avatar === '') {
            return "https://cdn.discordapp.com/embed/avatars/0.png";
        }
        return sprintf(self::AVATAR_URL, $this->discord_id, $this->avatar);
    }

    /**
     * Permet de mettre a jour les informations
     */
    public function refreshInformations()
    {
        $now = Carbon::now();
        $diffInSecs = $now->diffInSeconds($this->updated_at);
        if ($diffInSecs >= self::DIFF_SECONDS) {

            if ($now->greaterThan($this->expired_at)) $this->refreshOAuth();

            $userData = Http::withToken($this->access_token)->get(self::API_URL);
            if ($userData->clientError() || $userData->serverError()) {
                $this->update(['is_valid' => false,]);
                return;
            }

            $userData = json_decode($userData);

            $this->update(['username' => $userData->username, 'discriminator' => $userData->discriminator, 'avatar' => $userData->avatar ?? '', 'is_valid' => true,]);
        }
    }

    /**
     * Permet de refresh l'access token de OAuth
     */
    public function refreshOAuth()
    {
        $tokenData = ["client_id" => env("DISCORD_CLIENT_ID"), "client_secret" => env("DISCORD_CLIENT_SECRET"), "grant_type" => "refresh_token", "refresh_token" => $this->refresh_token,];

        $client = new Client();

        try {
            $accessTokenData = $client->post(self::TOKEN_URL, ["form_params" => $tokenData]);
            $accessTokenData = json_decode($accessTokenData->getBody());

            $expired_at = Carbon::now();
            $expired_at->addSeconds($accessTokenData->expires_in);
            $this->update(['access_token' => $accessTokenData->access_token, 'refresh_token' => $accessTokenData->refresh_token, 'expired_at' => $expired_at,]);
        } catch (Exception|GuzzleException $error) {
        }
    }

    /**
     * Permet de supprimer l'accès de discord au site
     *
     * @return bool
     */
    public function revokeAccess(): bool
    {

        $now = Carbon::now();
        if ($now->greaterThan($this->expired_at)) $this->refreshOAuth();

        $tokenData = ["client_id" => env("DISCORD_CLIENT_ID"), "client_secret" => env("DISCORD_CLIENT_SECRET"), "token" => $this->refresh_token,];

        $headers = ['Authorization' => 'Bearer ' . $this->access_token, 'Accept' => 'application/json',];

        $client = new Client();
        try {
            $accessTokenData = $client->post(self::TOKEN_REVOKE_URL, ["form_params" => $tokenData, "headers" => $headers,]);
            return true;
        } catch (Exception|GuzzleException $error) {
            return false;
        }
    }
}

