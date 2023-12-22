<?php

namespace App\Http\Controllers;

use App\Models\Resource\Resource;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Cache;

class IndexController extends Controller
{
    /**
     * @return Application|Factory|View|\Illuminate\Foundation\Application
     */
    public function index(): \Illuminate\Foundation\Application|View|Factory|Application
    {
        $resource = Cache::remember('resource:index', 86400, function () {
            return Resource::first();
        });
        return view('home', [
            'resource' => $resource,
        ]);
    }
}
