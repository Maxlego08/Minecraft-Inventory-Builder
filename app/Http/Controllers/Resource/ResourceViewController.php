<?php

namespace App\Http\Controllers\Resource;

use App\Http\Controllers\Controller;
use App\Models\Resource\Resource;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
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
        if ($slug != $resource->slug()) return Redirect::route('resources.view', ['resource' => $resource->id, 'slug' => $resource->slug()]);
        $reviews = $resource->reviews()->orderBy('created_at', 'desc')->limit(5)->get();
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
