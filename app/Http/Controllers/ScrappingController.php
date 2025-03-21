<?php

namespace App\Http\Controllers;

use App\Jobs\ScrappingJob;
use App\Jobs\UpdateHeadTable;
use App\Jobs\UpdateHeadValues;
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
        for ($i = 1; $i <= 88169; $i++) {
            ScrappingJob::dispatch($i);
        }
        return "ok";
    }

    public function index2(): string
    {
        $result = self::fetchUrl(86221, new Client());
        var_dump($result);
        if (empty($result)) return "empty !";
        Head::create($result);

        /*for ($i = 74127; $i <= 88169; $i++) {
            try {
                $result = self::fetchUrl($i, new Client());
                if (empty($result)) continue;
                Head::create($result);
            } catch (Exception) {
            }
        }*/
        return "ok";
    }

    public static function fetchUrl(int $id, Client $client): ?array
    {
        dd(Head::where('url_id', $id)->count() > 0);
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

    public function deleteAllData()
    {
        $heads = Head::where('created_at', '>=', '2024-04-18 00:00:00')->get();
        foreach ($heads as $head) {
            $imageName = basename($head->image_url);
            Storage::delete("public/images/head/{$imageName}");
            Storage::delete("public/images/head/{$head->image_name}");
            $head->delete();
        }
    }

    public function updateOtherValues(): string
    {

        $client = new Client();
        $heads = Head::whereNull('category')->get();
        foreach ($heads as $head) {
            UpdateHeadValues::dispatch($head);
        }

        return "ok";
    }

    public function renameFiles(): string
    {
        $heads = Head::all();
        foreach ($heads as $head) {
            /*try {
                $imageName = basename($head->image_url);
                Storage::move("public/images/head/{$imageName}", "public/images/head/$head->image_name.webp");
            } catch (Exception) {
                echo "Erreur avec l'id $head->id<br>";
            }*/
            $imageName = basename($head->image_url);
            if (Storage::exists("public/images/head/{$imageName}")) {
                if (Storage::move("public/images/head/{$imageName}", "public/images/head/{$head->image_name}.webp")) {
                    echo "Succès avec l'id $head->id<br>";
                } else {
                    if (Storage::exists("public/images/head/{$head->image_name}.webp")) {
                        echo "Il existe déjà avec l'id $head->id<br>";
                    } else {
                        echo "Impossible avec l'id $head->id<br>";
                    }
                }
            } else {
                echo "Erreur avec l'id $head->id<br>";
            }
        }

        return "FIN";
    }

    public function updateDatabase()
    {

        $categories = [
            "alphabet",
            "animals",
            "blocks",
            "decoration",
            "food-drinks",
            "humans",
            "humanoid",
            "miscellaneous",
            "monsters",
            "plants"
        ];
        $url = "https://minecraft-heads.com/scripts/api.php?cat=%s&tags=true";

        $amount = 0;
        foreach ($categories as $category) {
            $values = Http::get(sprintf($url, $category))->json();
            $amount += count($values);

            foreach ($values as $value) {
                UpdateHeadTable::dispatch($value, $category);
            }
        }

        return "ok -> $amount";
    }

    public function test()
    {

        $head = Head::whereNull('category')->first();

        var_dump($head);

        $client = new Client();
        $url = $head->url;
        $crawler = $client->request('GET', $url);
        $currentValues = [];

        $crawler->filter('.row .mb-2')->each(function ($node) use (&$currentValues) {
            $values = $node->filter('.col-sm-8');
            if ($values->count() > 0) {

                $current = $values->first()->text();
                $currentTags = [];

                if ($values->count() > 1) {
                    $tags = $values->eq(1);
                    $tags->filter('.text-decoration-none')->each(function ($node) use (&$currentTags) {
                        $currentTags[] = $node->text();
                    });
                }

                $currentValues[] = $current;
                $currentValues[] = implode(', ', $currentTags);
            }
        });

        if (!empty($currentValues)) {
            $head->update([
                'category' => $currentValues[0] ?? null,
                'tags' => $currentValues[1] ?? null,
            ]);
        }

        dd($currentValues);
    }

}
