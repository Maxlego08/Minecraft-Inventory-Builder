<?php

namespace App\Jobs;

use App\Models\Resource\Resource;
use App\Utils\Discord\DiscordWebhook;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class JobResourceInformation implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    private $resource;

    /**
     * Create a new job instance.
     */
    public function __construct(Resource $resource)
    {
        $this->resource = $resource;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $link = route('admin.resources.pending');
        $webhook = DiscordWebhook::create("{$this->resource->name}.{$this->resource->id} vient de créer la resource [{$this->resource->name}]({$this->resource->link('description')}) - Accepter la resource [ici]($link)");
        $webhook->send(env('MODERATOR_WEBHOOK_URL'));
    }
}
