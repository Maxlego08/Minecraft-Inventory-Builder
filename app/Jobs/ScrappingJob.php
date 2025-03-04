<?php

namespace App\Jobs;

use App\Http\Controllers\ScrappingController;
use App\Models\Builder\Head;
use Goutte\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ScrappingJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $number;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($number)
    {
        $this->number = $number;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $client = new Client();
        $result = ScrappingController::fetchUrl($this->number, $client);
        if (!empty($result)) {
            Head::create($result);
        }
    }
}
