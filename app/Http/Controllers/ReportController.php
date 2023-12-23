<?php

namespace App\Http\Controllers;

use App\Models\Resource\Resource;
use App\Models\UserLog;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\ValidationException;

class ReportController extends Controller
{
    /**
     * Report une resource
     *
     * @param Request $request
     * @param Resource $resource
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function reportResource(Request $request, Resource $resource): RedirectResponse
    {

        $this->validate($request, [
            'reason' => ['required', 'string', 'max:2000'],
        ]);

        $user = user();
        $key = "report::$user->id";
        if (Cache::has($key)) {
            return Redirect::route('resources.view', ['resource' => $resource, 'slug' => $resource->slug()])->with('toast', createToast('error', __('reports.report_cooldown.title'), __('reports.report_cooldown.description'), 5000));
        }

        Cache::put($key, 'cooldown', 60 * 2);

        $resource->reports()->create(['user_id' => $user->id, 'reason' => $request['reason']]);

        userLog("Vient de report la resource $resource->name.$resource->id", UserLog::COLOR_SUCCESS, UserLog::ICON_HEART_BREAK);

        return Redirect::route('resources.view', ['resource' => $resource, 'slug' => $resource->slug()])->with('toast', createToast('success', __('reports.report_submitted.title'), __('reports.report_submitted.description'), 5000));
    }
}
