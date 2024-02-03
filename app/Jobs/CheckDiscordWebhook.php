<?php

namespace App\Jobs;

use App\Models\Discord\DiscordNotification;
use App\Utils\Discord\DiscordWebhook;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Http\Client\HttpClientException;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CheckDiscordWebhook implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var int
     */
    protected int $notification_id;

    /**
     * @var DiscordWebhook
     */
    protected DiscordWebhook $webhook;

    /**
     * @var string
     */
    protected string $url;

    /**
     * CheckDiscordWebhook constructor.
     * @param int $notification_id
     * @param DiscordWebhook $webhook
     * @param string $url
     */
    public function __construct(int $notification_id, DiscordWebhook $webhook, string $url)
    {
        $this->notification_id = $notification_id;
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

            $notification = DiscordNotification::find($this->notification_id);
            $notification->update(['is_valid' => true,]);
        } catch (HttpClientException $exception) {
            $this->fail($exception);
        }
    }


}
