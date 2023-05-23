<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Resource\Resource;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class IndexController extends Controller
{
    /**
     * First page of dashboard
     *
     * @return Application|Factory|View|\Illuminate\Foundation\Application
     */
    public function index(): \Illuminate\Foundation\Application|View|Factory|Application
    {
        return view('admins.dashboard', [
            'users' => User::count(),
            'resources' => Resource::count(),
        ]);
    }
}
