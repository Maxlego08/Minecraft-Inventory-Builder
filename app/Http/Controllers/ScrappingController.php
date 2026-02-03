<?php

namespace App\Http\Controllers;

use App\Models\Builder\Head;
use Exception;
use Goutte\Client;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ScrappingController extends Controller
{
    public static function fetchUrl(int $id, Client $client): ?array
    {
        $alreadyExist = Head::where('url_id', $id)->count() > 0;
        if ($alreadyExist) return [];

        $url = "https://minecraft-heads.com/custom-heads/head/$id";
        $crawler = $client->request('GET', $url);

        $imageUrls = [];
        $crawler->filter('.head-renders')->each(function ($node) use (&$imageUrls) {
            try {
                $imageUrl = $node?->filter('img')?->first()?->attr('src');
                if ($imageUrl) {
                    $imageUrls[] = $imageUrl;
                }
            } catch (Exception $exception) {
            }
        });

        $headUrl = $crawler->filter('#Value')->text();
        $name = $crawler->filter('h1')->last()->text();
        $imageName = Str::random(64);

        self::downloadImage($imageUrls[0], "$imageName.webp");

        return [
            'image_url' => $imageUrls[0],
            'head_url' => $headUrl,
            'name' => $name,
            'image_name' => $imageName,
            'url_id' => $id,
            'url' => $url,
        ];
    }

    public static function downloadImage($url, $path): string
    {
        $response = Http::get($url);

        if ($response->successful()) {
            $imageName = basename($url);
            Storage::put("public/images/head/{$imageName}", $response->body());
            Storage::put("public/images/head/$path", $response->body());
            return "Image téléchargée avec succès.";
        }

        return "Échec du téléchargement de l'image.";
    }
}
