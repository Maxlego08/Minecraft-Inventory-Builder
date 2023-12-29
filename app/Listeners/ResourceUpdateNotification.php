<?php

namespace App\Listeners;

use App\Http\Controllers\Resource\ResourcePagination;
use App\Payment\utils\Resources\ResourceUpdate;

class ResourceUpdateNotification
{

    const EVENT = 'event.resource.updated';

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
    public function handle(ResourceUpdate $event): void
    {
        ResourcePagination::sendDiscordWebhook($event->resource, $event->user, self::EVENT);
    }
}
