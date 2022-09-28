<?php

namespace App\Http\Controllers;

use App\Actions\Fortify\PasswordValidationRules;
use App\Models\Log;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\ValidationException;

class ProfileController extends Controller
{

    use PasswordValidationRules;

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
        return view('members.index');
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
        $this->validate($request, ['image' => 'required|image',]);

        user()->updateProfilePhoto($request->file('image'));

        return Redirect::route('profile.index');
    }

    /**
     * Modifier l'email de l'utilisateur
     *
     * @param Request $request
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function changeEmail(Request $request): RedirectResponse
    {
        $this->validate($request, ['email' => ['required', 'string', 'email', 'max:100', 'unique:users,email,' . $request->user()->id],]);

        $request->user()->update($request->only('email'));
        return Redirect::route('profile.index');
    }

    /**
     * Changer le mot de passe
     *
     * @param Request $request
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function changePassword(Request $request): RedirectResponse
    {
        $this->validate($request, ['old_password' => ['required', 'string', 'min:8'], 'password' => $this->passwordRules(),]);

        if ($request->input('password') === $request->input('old_password')) {
            return Redirect::back()->withErrors(['password' => "Vous ne pouvez pas mettre le même mot de passe qu'actuellement."]);
        }

        if (!Hash::check($request->input('old_password'), $request->user()->password)) {
            return Redirect::back()->withErrors(['old_password' => 'Le mot de passe ne correspond pas.']);
        }

        $password = Hash::make($request->input('password'));
        $request->user()->update(['password' => $password]);

        return Redirect::route('profile.index');
    }

    /**
     * Permet de retirer l'accès a discord
     *
     * @param Request $request
     * @return RedirectResponse
     * @throws Exception
     */
    public function discord(Request $request): RedirectResponse
    {
        $user = user();
        if ($user->discord === null) {
            return Redirect::route('profile.index');
        }

        $discord = $user->discord;
        if ($discord->revokeAccess()) {

            $discord->delete();
            return Redirect::route('profile.index');
        }

        return Redirect::route('profile.index');
    }

}
