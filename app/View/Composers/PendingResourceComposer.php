<?php

namespace App\View\Composers;

use App\Models\Resource\Resource;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class PendingResourceComposer
{

    /**
     * Bind data to the view.
     *
     * @param View $view
     * @return void
     */
    public function compose(View $view)
    {
        $pendingResourcesCounts = Cache::remember('pending_resources', 300, function () {
            return Resource::where('is_pending', true)->count();
        });
        $view->with('pending_resources', $pendingResourcesCounts);
    }

}
