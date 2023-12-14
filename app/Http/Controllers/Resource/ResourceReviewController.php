<?php

namespace App\Http\Controllers\Resource;

use App\Http\Controllers\Controller;
use App\Models\Alert\AlertUser;
use App\Models\Resource\Download;
use App\Models\Resource\Resource;
use App\Models\Resource\Review;
use App\Models\UserLog;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\ValidationException;

class ResourceReviewController extends Controller
{

    /**
     * Show a resource
     *
     * @param string $slug
     * @param Resource $resource
     * @return \Illuminate\Contracts\Foundation\Application|Factory|View|Application|RedirectResponse
     */
    public function index(string $slug, Resource $resource): \Illuminate\Contracts\Foundation\Application|Factory|View|Application|RedirectResponse
    {

        if ($resource->is_pending && (Auth::guest() || !$resource->isModerator())) {
            return Redirect::route('resources.index')->with('toast', createToast('error', __('resources.view.errors.pending.title'), __('resources.view.errors.pending.content'), 5000));
        }

        if ($resource->is_deleted && (Auth::guest() || !user()->role->isModerator())) {
            return Redirect::route('resources.index')->with('toast', createToast('error', __('resources.view.errors.deleted.title'), __('resources.view.errors.deleted.content'), 5000));
        }

        if ($slug != $resource->slug()) return Redirect::route('resources.reviews', ['resource' => $resource->id, 'slug' => $resource->slug()]);
        $reviews = $resource->reviews()->with('version')->with('user')->orderBy('created_at', 'desc')->paginate();
        return view('resources.pages.reviews', ['resource' => $resource, 'reviews' => $reviews]);
    }

    /**
     * @param Resource $resource
     * @return RedirectResponse
     */
    public function indexById(Resource $resource): RedirectResponse
    {
        return Redirect::route('resources.reviews', ['resource' => $resource->id, 'slug' => $resource->slug()]);
    }

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

        if ($resource->is_pending && (Auth::guest() || !$resource->isModerator())) {
            return Redirect::route('resources.index')->with('toast', createToast('error', __('resources.view.errors.pending.title'), __('resources.view.errors.pending.content'), 5000));
        }

        if ($resource->is_deleted && (Auth::guest() || !user()->role->isModerator())) {
            return Redirect::route('resources.index')->with('toast', createToast('error', __('resources.view.errors.deleted.title'), __('resources.view.errors.deleted.content'), 5000));
        }

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

        $review = Review::create(['user_id' => $user->id, 'resource_id' => $resource->id, 'version_id' => $resource->version_id, 'score' => $rate, 'review' => $request['message']]);

        $resource->clearReview();
        userLog("Création de review $review->id pour la resource $resource->id", UserLog::COLOR_SUCCESS, UserLog::ICON_STARS);

        createAlert($resource->user_id, $resource->name, AlertUser::ICON_ENVELOPE, AlertUser::SUCCESS, 'resources.resources.alert', $resource->link('reviews'), $user->id);

        return Redirect::back()->with('toast', createToast('success', __('resources.reviews.success.title'), __('resources.reviews.success.content'), 5000));
    }

    /**
     * Delete a review
     *
     * @param Review $review
     * @return RedirectResponse
     */
    public function deleteReview(Review $review): RedirectResponse
    {

        $user = user();
        if ($review->user_id != $user->id && !$user->role->isModerator()) {
            return Redirect::back()->with('toast', createToast('error', __('resources.reviews.errors.permission.title'), __('resources.reviews.errors.permission.content'), 5000));
        }

        $resource = $review->resource;
        $review->delete();

        $resource->clearReview();
        userLog("Suppression de review $review->id de la resource $resource->id", UserLog::COLOR_SUCCESS, UserLog::ICON_STARS);

        return Redirect::back()->with('toast', createToast('error', __('resources.reviews.delete.title'), __('resources.reviews.delete.content'), 5000));
    }

    /**
     * Delete a response
     *
     * @param Review $review
     * @return RedirectResponse
     */
    public function deleteResponse(Review $review): RedirectResponse
    {
        $user = user();
        if (!$user->role->isModerator() && !$review->resource->user_id != $user->id) {
            return Redirect::back()->with('toast', createToast('error', 'Erreur !', 'Vous ne pouvez pas effectuer cette action.', 5000));
        }

        $review->update(['response' => null]);

        userLog("Suppression de la review $review->id", UserLog::COLOR_SUCCESS, UserLog::ICON_STARS);

        return Redirect::back()->with('toast', createToast('success', __('resources.reviews.response.title'), __('resources.reviews.response.content'), 5000));
    }

    /**
     * Reply
     *
     * @throws ValidationException
     */
    public function reply(Request $request, Review $review): RedirectResponse
    {

        $this->validate($request, ['message' => 'required|min:3|max:5000']);
        $review->update(['response' => $request['message']]);

        userLog("Réponse à la review $review->id", UserLog::COLOR_SUCCESS, UserLog::ICON_STARS);

        return Redirect::back()->with('toast', createToast('success', __('resources.reviews.reply.title'), __('resources.reviews.reply.content'), 5000));
    }

}
