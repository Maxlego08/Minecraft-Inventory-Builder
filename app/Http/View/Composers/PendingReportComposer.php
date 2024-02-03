<?php

namespace App\Http\View\Composers;

use App\Models\Report;
use App\Models\Resource\Resource;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class PendingReportComposer
{

    /**
     * Bind data to the view.
     *
     * @param View $view
     * @return void
     */
    public function compose(View $view)
    {
        $pendingReportCount = Cache::remember('pending_report', 300, function () {
            return Report::whereNull('resolved_at')->count();
        });
        $view->with('pending_reports', $pendingReportCount);
    }


}
