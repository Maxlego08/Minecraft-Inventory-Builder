<?php

namespace App\Http\Controllers\Resource;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;

class ResourceAuthorController extends Controller
{

    /**
     * Show index page
     *
     * @param string $tag
     * @param User $user
     * @return View|\Illuminate\Foundation\Application|Factory|Application
     */
    public function index(string $tag, User $user): View|\Illuminate\Foundation\Application|Factory|Application
    {
        return view('resources.pages.author', [
            'user' => $user,
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