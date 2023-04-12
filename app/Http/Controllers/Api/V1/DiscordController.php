<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Cache;

class DiscordController extends Controller
{

    const API_URL = "https://discord.com/api/guilds/%serverId%/widget.json";

    /**
     * Get server information
     *
     * @param $serverId
     * @return mixed
     */
    public function getDiscordInformation($serverId): array
    {
        return Cache::remember("discord.url.$serverId", 600, function () use ($serverId) {
            try {
                $url = str_replace('%serverId%', $serverId, self::API_URL);
                $client = new Client();
                $response = $client->get($url, ['headers' => ['Accept' => 'application/json',]]);
                $json = json_decode((string)$response->getBody(), true);
                return ['id' => $json['id'], 'name' => $json['name'], 'invite' => $json['instant_invite']];
            } catch (Exception) {
                abort(404);
            }
        });
    }
}
