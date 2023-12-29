<?php

namespace App\Listeners;

use App\Http\Controllers\Resource\ResourcePagination;
use App\Payment\utils\Resources\ResourceCreate;

class ResourceCreateNotification
{

    const EVENT = 'event.resource.created';

    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(ResourceCreate $event): void
    {
        ResourcePagination::sendDiscordWebhook($event->resource, $event->user, self::EVENT);
    }
}
