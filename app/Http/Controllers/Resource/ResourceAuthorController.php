<?php

namespace App\Http\Controllers\Resource;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redirect;

class ResourceAuthorController extends Controller
{

    /**
     * Show index page
     *
     * @param string $slug
     * @param User $user
     * @return View|\Illuminate\Foundation\Application|Factory|Application
     */
    public function index(string $slug, User $user): View|\Illuminate\Foundation\Application|Factory|Application
    {
        $resources = ResourcePagination::paginateAuthor($user);
        return view('resources.pages.author', [
            'user' => $user,
            'resources_count' => $resources->total(),
            'resources' => $resources,
        ]);
    }

    /**
     * Show user page
     *
     * @param User $user
     * @return RedirectResponse
     */
    public function indexById(User $user): RedirectResponse
    {
        return Redirect::route('resources.author', ['slug' => $user->slug(), 'user' => $user]);
    }
}
