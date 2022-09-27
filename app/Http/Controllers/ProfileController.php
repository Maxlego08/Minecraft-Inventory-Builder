<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\ValidationException;

class ProfileController extends Controller
{
    /**
     * Permet de supprimer son image de profile
     *
     * @return RedirectResponse
     */
    public function destroyProfile(): RedirectResponse
    {
        user()->deleteProfilePhoto();

        return Redirect::route('profile.index');
    }

    /**
     * Retourne la page du profile de l'utilisateur
     *
     * @return Application|Factory|View
     */
    public function index(): View|Factory|Application
    {
        return view('auth.profile');
    }


    /**
     * Permet d'upload une image de profile
     *
     * @param Request $request
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function uploadProfile(Request $request): RedirectResponse
    {
        $this->validate($request, [
            'image' => 'required|image',
        ]);

        user()->updateProfilePhoto($request->file('image'));

        return Redirect::route('profile.index');
    }
}
