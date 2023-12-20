<?php

namespace App\Jobs;

use App\Utils\Discord\DiscordWebhook;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Http\Client\HttpClientException;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class DiscordWebhookNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var DiscordWebhook
     */
    protected DiscordWebhook $webhook;

    /**
     * @var string
     */
    protected string $url;

    /**
     * SendDiscordWebhook constructor.
     * @param DiscordWebhook $webhook
     * @param string $url
     */
    public function __construct(DiscordWebhook $webhook, string $url)
    {
        $this->webhook = $webhook;
        $this->url = $url;
    }


    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(): void
    {
        try {
            $this->webhook->send($this->url);
        } catch (HttpClientException $e) {
            $this->fail($e);
        }
    }
}
