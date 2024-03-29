<?php

namespace App\Http\Controllers\Resource;

use App\Http\Controllers\Controller;
use App\Models\Resource\Resource;
use App\Models\Resource\Version;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redirect;

class ResourceUpdateController extends Controller
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

        if ($slug != $resource->slug()) return Redirect::route('resources.updates', ['resource' => $resource->id, 'slug' => $resource->slug()]);

        $versions = Cache::remember("pages.updates.$resource->id", 300, function () use ($resource){
            return $resource->versions()->with('resource')->with('reviews')->orderBy('created_at', 'desc')->paginate(15);
        });

        return view('resources.pages.update', ['resource' => $resource, 'versions' => $versions]);
    }

    /**
     * @param Resource $resource
     * @return RedirectResponse
     */
    public function indexById(Resource $resource): RedirectResponse
    {
        return Redirect::route('resources.updates', ['resource' => $resource->id, 'slug' => $resource->slug()]);
    }

    /**
     * Display the update page
     *
     * @param Resource $resource
     * @return View|Application|Factory|RedirectResponse|\Illuminate\Contracts\Foundation\Application
     */
    public function update(Resource $resource): View|Application|Factory|RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {

        if (!$resource->isModerator()) {
            return Redirect::route('resources.index')->with('toast', createToast('error', __('resources.view.errors.permission.title'), __('resources.view.errors.permission.content'), 5000));
        }

        return view('resources.update', ['resource' => $resource]);
    }

    /**
     * Redirect to resources
     *
     * @param Version $version
     * @return RedirectResponse
     */
    public function indexUpdateById(Version $version): RedirectResponse
    {
        return Redirect::route('resources.update', ['slug' => $version->resource->slug(), 'resource' => $version->resource, 'version' => $version]);
    }

}
