<?php

namespace App\Http\Controllers\Resource;

use App\Http\Controllers\Controller;
use App\Models\Resource\Download;
use App\Models\Resource\Resource;
use App\Models\Resource\Review;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\ValidationException;

class ResourceReviewController extends Controller
{
    /**
     * Rate a resource
     *
     * @param Request $request
     * @param Resource $resource
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function store(Request $request, Resource $resource): RedirectResponse
    {

        $this->validate($request, ['rate' => 'required', 'message' => 'required|max:5000|min:30',]);

        $user = user();
        if (empty(Download::hasAlreadyDownload($resource->version, $user))) {
            return Redirect::back()->with('toast', createToast('error', __('resources.reviews.errors.download.title'), __('resources.reviews.errors.download.content'), 5000));
        }

        if ($resource->user_id === $user->id) {
            return Redirect::back()->with('toast', createToast('error', __('resources.reviews.errors.self.title'), __('resources.reviews.errors.self.content'), 5000));
        }

        $review = Review::where('user_id', $user->id)->where('version_id', $resource->version_id)->count();
        if ($review > 0) {
            return Redirect::back()->with('toast', createToast('error', __('resources.reviews.errors.already.title'), __('resources.reviews.errors.already.content'), 5000));
        }

        $rate = $request['rate'];
        if (!in_array($rate, [1, 2, 3, 4, 5])) {
            return Redirect::back()->with('toast', createToast('error', __('resources.reviews.errors.rate.title'), __('resources.reviews.errors.rate.content'), 5000));
        }

        Review::create(['user_id' => $user->id, 'resource_id' => $resource->id, 'version_id' => $resource->version_id, 'score' => $rate, 'review' => $request['message'],]);

        return Redirect::back()->with('toast', createToast('success', __('resources.reviews.success.title'), __('resources.reviews.success.content'), 5000));
    }
}
