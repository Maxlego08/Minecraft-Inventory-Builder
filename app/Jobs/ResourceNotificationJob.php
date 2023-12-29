<?php

namespace App\Jobs;

use App\Models\Alert\AlertUser;
use App\Models\Resource\Resource;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ResourceNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var int
     */
    private int $resourceId;

    /**
     * Create a new job instance.
     *
     * @param int $resourceId
     */
    public function __construct(int $resourceId)
    {
        $this->resourceId = $resourceId;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $resource = Resource::findOrFail($this->resourceId);
        foreach ($resource->notifications as $notification) {

            if ($notification->enable_alert) {
                createAlert($notification->user_id, $resource->name, AlertUser::ICON_SUCCESS, AlertUser::SUCCESS, 'alerts.alerts.resources.updated', $resource->link('updates'), $resource->user_id);
            }
        }
    }
}
