<?php

namespace App\Http\Controllers\Resource;

use App\Http\Controllers\Controller;
use App\Models\Resource\Resource;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class ResourceViewController extends Controller
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

        if ($slug != $resource->slug()) return Redirect::route('resources.view', ['resource' => $resource->id, 'slug' => $resource->slug()]);
        $reviews = $resource->lastReviews();
        return view('resources.show', ['resource' => $resource, 'reviews' => $reviews]);
    }

    /**
     * @param Resource $resource
     * @return RedirectResponse
     */
    public function indexById(Resource $resource): RedirectResponse
    {
        return Redirect::route('resources.view', ['resource' => $resource->id, 'slug' => $resource->slug()]);
    }
}
