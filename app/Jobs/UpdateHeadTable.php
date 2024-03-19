<?php

namespace App\Jobs;

use App\Models\Builder\Head;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateHeadTable implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $value;
    protected $category;


    /**
     * Create a new job instance.
     */
    public function __construct($value, $category)
    {
        $this->value = $value;
        $this->category = $category;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $head = Head::where('head_url', $this->value['value'])->first();
        if ($head) {
            $head->update([
                'tags' => $this->value['tags'],
                'category' => $this->category,
            ]);
        }
    }
}
