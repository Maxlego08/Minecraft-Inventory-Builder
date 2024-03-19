<?php

namespace App\Jobs;

use App\Models\Builder\Head;
use Goutte\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateHeadValues implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $head;

    /**
     * Créez une nouvelle instance du job.
     *
     * @return void
     */
    public function __construct(Head $head)
    {
        $this->head = $head;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $client = new Client();
        $url = $this->head->url;
        $crawler = $client->request('GET', $url);
        $currentValues = [];
        $crawler->filter('.row .mb-0')->each(function ($node) use (&$currentValues) {
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
            $this->head->update([
                'category' => $currentValues[0] ?? null,
                'tags' => $currentValues[1] ?? null,
            ]);
        }
    }
}
