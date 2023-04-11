<?php

namespace App\Http\Controllers\Resource;

use App\Http\Controllers\Controller;
use App\Models\Resource\Resource;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;

class ResourceViewController extends Controller
{
    /**
     * Show a resource
     *
     * @param string $slug
     * @param Resource $resource
     * @return \Illuminate\Contracts\Foundation\Application|Factory|View|Application
     */
    public function index(string $slug, Resource $resource): Application|View|Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('resources.show', [
            'resource' => $resource,
        ]);
    }
}
