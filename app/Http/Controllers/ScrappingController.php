<?php

namespace App\Http\Controllers;

use App\Jobs\ScrappingJob;
use App\Models\Builder\Head;
use Exception;
use Goutte\Client;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ScrappingController extends Controller
{
    public function index(): string
    {
        for ($i = 1; $i <= 10; $i++) {
            ScrappingJob::dispatch($i);
        }
        return "ok";
    }

    public function index2(): string
    {
        for ($i = 1; $i <= 10; $i++) {
            try {
                Head::create(self::fetchUrl($i, new Client()));
            } catch (Exception) {
            }
        }
        return "ok";
    }

    public static function fetchUrl(int $id, Client $client): ?array
    {
        $url = "https://minecraft-heads.com/custom-heads/head/$id";
        $crawler = $client->request('GET', $url);

        $imageUrls = [];
        $crawler->filter('.head-renders')->each(function ($node) use (&$imageUrls) {
            $imageUrl = $node->filter('img')->first()->attr('src');
            if ($imageUrl) {
                $imageUrls[] = $imageUrl;
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
            // $imageName = basename($url);
            // Storage::put("public/images/head/{$imageName}", $response->body());
            Storage::put("public/images/head/$path", $response->body());
            return "Image téléchargée avec succès.";
        }

        return "Échec du téléchargement de l'image.";
    }

    public function renameFiles(): string
    {
        $heads = Head::all();
        foreach ($heads as $head) {
            try {
                $imageName = basename($head->image_url);
                Storage::move("public/images/head/{$imageName}", "public/images/head/$head->image_name.webp");
            } catch (Exception) {
                echo "Erreur avec l'id $head->id<br>";
            }
        }
        return "FIN";
    }

}
