<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class DownloadHeadCategoriesJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $timeout = 300;

    private const CATEGORIES = [
        'alphabet',
        'animals',
        'blocks',
        'decoration',
        'food-drinks',
        'humans',
        'humanoid',
        'miscellaneous',
        'monsters',
        'plants',
    ];

    private const API_URL = 'https://minecraft-heads.com/scripts/api.php?cat=%s&tags=true';

    public function handle(): void
    {
        $downloaded = 0;

        foreach (self::CATEGORIES as $category) {
            $response = Http::timeout(60)->get(sprintf(self::API_URL, $category));

            if ($response->successful()) {
                Storage::put("heads/categories/{$category}.json", $response->body());
                $downloaded++;
                Log::info("Downloaded head category: {$category}");
            } else {
                Log::warning("Failed to download head category: {$category}, status: {$response->status()}");
            }
        }

        Log::info("Head categories download complete: {$downloaded}/" . count(self::CATEGORIES) . " categories downloaded.");
    }
}
