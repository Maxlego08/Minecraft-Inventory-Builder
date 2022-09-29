<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\DiscordUser;
use App\Models\Log;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redirect;

class DiscordAuthController extends Controller
{

    /**
     * Permet de relier son compte discord
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function authentication(Request $request): RedirectResponse
    {
        if ($request->missing('code') && $request->missing('state')) {
            return Redirect::route('profile.index')
                ->with('toast', createToast('error', __('messages.error'), __('profiles.discord.error.url')));
        }

        $userId = $request->get('state');
        $user = User::find($userId);

        if (!isset($user)){
            return Redirect::route('profile.index')
                ->with('toast', createToast('error', __('messages.error'), __('profiles.discord.error.user')));
        }

        $tokenData = [
            "client_id" => env("DISCORD_CLIENT_ID"),
            "client_secret" => env("DISCORD_CLIENT_SECRET"),
            "grant_type" => "authorization_code",
            "code" => $request->get('code'),
            "redirect_uri" => route('api.v1.discord'),
            "scope" => "identifiy"
        ];

        $client = new Client();

        try {
            $accessTokenData = $client->post(DiscordUser::TOKEN_URL, ["form_params" => $tokenData]);
            $accessTokenData = json_decode($accessTokenData->getBody());
        } catch (Exception | GuzzleException $error) {
            return Redirect::route('profile.index')
                ->with('toast', createToast('error', __('messages.error'), __('profiles.discord.error.oauth')));
        }

        $userData = Http::withToken($accessTokenData->access_token)->get(DiscordUser::API_URL);
        if ($userData->clientError() || $userData->serverError()) {
            return Redirect::route('profile.index')
                ->with('toast', createToast('error', __('messages.error'), __('profiles.discord.error.api')));
        }

        $userData = json_decode($userData);

        $discordUser = DiscordUser::where('discord_id', $userData->id)->first();
        if (isset($discordUser)) {
            return Redirect::route('profile.index')
                ->with('toast', createToast('error', __('messages.error'), __('profiles.discord.error.already')));
        }

        $expired_at = Carbon::now();
        $expired_at->addSeconds($accessTokenData->expires_in);

        DiscordUser::create([
            'user_id' => $user->id,
            'discord_id' => $userData->id,
            'email' => '',
            'username' => $userData->username,
            'discriminator' => $userData->discriminator,
            'avatar' => $userData->avatar ?? '',
            'access_token' => $accessTokenData->access_token,
            'refresh_token' => $accessTokenData->refresh_token,
            'expired_at' => $expired_at,
            'is_valid' => true,
        ]);

        return Redirect::route('profile.index')
            ->with('toast', createToast('success', __('profiles.discord.discord'), __('profiles.discord.linked')));
    }

}
