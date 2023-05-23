<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Resource\Resource;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;

class ResourceController extends Controller
{
    /**
     * Display resource
     *
     * @return \Illuminate\Contracts\Foundation\Application|Factory|View|Application
     */
    public function index(): Application|View|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $resources = Resource::paginate();
        return view('admins.resources.index', [
            'resources' => $resources,
        ]);
    }

    /**
     * Display pending resource
     *
     * @return \Illuminate\Contracts\Foundation\Application|Factory|View|Application
     */
    public function pending(): Application|View|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $resources = Resource::where('is_pending', true)->paginate();
        return view('admins.resources.pending', [
            'resources' => $resources,
        ]);
    }


}
