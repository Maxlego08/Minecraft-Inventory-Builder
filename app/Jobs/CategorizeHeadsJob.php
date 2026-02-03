<?php

namespace App\Jobs;

use App\Models\Builder\Head;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class CategorizeHeadsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $timeout = 600;

    public function handle(): void
    {
        $index = $this->buildIndex();

        if (empty($index)) {
            Log::warning('CategorizeHeadsJob: No category data found. Run DownloadHeadCategoriesJob first.');
            return;
        }

        $updated = 0;

        Head::whereNull('category')->chunkById(500, function ($heads) use ($index, &$updated) {
            foreach ($heads as $head) {
                if (isset($index[$head->head_url])) {
                    $data = $index[$head->head_url];
                    $head->update([
                        'category' => $data['category'],
                        'tags' => $data['tags'],
                    ]);
                    $updated++;
                }
            }
        });

        Log::info("CategorizeHeadsJob complete: {$updated} heads updated.");
    }

    private function buildIndex(): array
    {
        $index = [];
        $files = Storage::files('heads/categories');

        foreach ($files as $file) {
            if (!str_ends_with($file, '.json')) {
                continue;
            }

            $category = pathinfo($file, PATHINFO_FILENAME);
            $content = Storage::get($file);
            $items = json_decode($content, true);

            if (!is_array($items)) {
                Log::warning("CategorizeHeadsJob: Invalid JSON in {$file}");
                continue;
            }

            foreach ($items as $item) {
                if (isset($item['value'])) {
                    $index[$item['value']] = [
                        'category' => $category,
                        'tags' => $item['tags'] ?? null,
                    ];
                }
            }
        }

        return $index;
    }
}
