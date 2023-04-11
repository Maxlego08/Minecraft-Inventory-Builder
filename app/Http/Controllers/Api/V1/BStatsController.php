<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Cache;

class BStatsController extends Controller
{

    const BSTATS_URL_STATS = 'https://bstats.org/api/v1/plugins/%pluginId%/charts/%chartId%/data/?maxElements=1';
    const BSTATS_URL_BASE = 'https://bstats.org/api/v1/plugins/%pluginId%';
    const BSTATS_URL_SHOW = 'https://bstats.org/plugin/%software%/%name%/%pluginId%';

    /**
     * Get plugin url
     * @param $id
     * @return string|string[]
     */
    public function getUrl($id): array|string
    {
        return Cache::remember("bstats.$id.url", 86400, function () use ($id) {
            $client = new Client();
            $buildUrl = $this->buildURL($id, '', self::BSTATS_URL_BASE);
            $response = $client->get($buildUrl, ['headers' => ['Accept' => 'application/json',]]);
            $json = json_decode((string)$response->getBody(), true);
            $software = config('software.' . $json['software']['id']);
            $name = $json['name'];
            $id = $json['id'];

            $url = self::BSTATS_URL_SHOW;
            $url = str_replace('%pluginId%', $id, $url);
            $url = str_replace('%software%', $software['name'], $url);
            return str_replace('%name%', $name, $url);
        });
    }

    /**
     * Build URL
     * @param $id
     * @param $chart
     * @param $url
     * @return string|string[]
     */
    public function buildURL($id, $chart, $url)
    {
        $url = str_replace('%pluginId%', $id, $url);
        return str_replace('%chartId%', $chart, $url);
    }

    /**
     * @param $id
     * @param $chart
     * @return int
     */
    public function getStats($id, $chart): int
    {
        return Cache::remember("bstats.$id.$chart", 600, function () use ($id, $chart) {
            $client = new Client();
            $buildUrl = $this->buildURL($id, $chart, self::BSTATS_URL_STATS);
            $response = $client->get($buildUrl, ['headers' => ['Accept' => 'application/json',]]);
            $json = json_decode((string)$response->getBody(), true);
            try {
                return $json[0][1];
            } catch (Exception $e) {
                return 0;
            }
        });

    }
}
