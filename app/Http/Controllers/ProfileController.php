<?php

namespace App\Http\Controllers;

use App\Actions\Fortify\PasswordValidationRules;
use App\Models\User;
use App\Models\UserLog;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
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

        userLog('Suppression de la photo de profil', UserLog::COLOR_DANGER, UserLog::ICON_REMOVE);

        return Redirect::route('profile.index')
            ->with('toast', createToast('success', __('profiles.avatar.name'), __('profiles.avatar.deleted')));
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
        $this->validate($request, ['image' => 'required|image|mimes:jpeg,png,jpg|max:1024']);

        user()->updateProfilePhoto($request->file('image'));
        userLog('Création de la photo de profil', UserLog::COLOR_SUCCESS, UserLog::ICON_ADD);

        return Redirect::route('profile.index')
            ->with('toast', createToast('success', __('profiles.avatar.name'), __('profiles.avatar.added')));
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
        $this->validate($request, ['email' => ['required', 'string', 'email', 'max:100', 'unique:users,email,' . $request->user()->id]]);

        $request->user()->update($request->only('email'));
        userLog('Modification de l\'email', UserLog::COLOR_SUCCESS, UserLog::ICON_EDIT);

        return Redirect::route('profile.index')
            ->with('toast', createToast('success', __('messages.password'), __('profiles.email.updated')));
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

        userLog('Modification du mot de passe', UserLog::COLOR_SUCCESS, UserLog::ICON_EDIT);

        return Redirect::route('profile.index')
            ->with('toast', createToast('success', __('messages.password'), __('profiles.password.updated')));
    }

    /**
     * Permet de retirer l'accès a discord
     *
     * @return RedirectResponse
     * @throws Exception
     */
    public function discord(): RedirectResponse
    {
        $user = user();
        if ($user->discord === null) {
            return Redirect::route('profile.index')
                ->with('toast', createToast('success', __('profiles.discord.discord'), __('profiles.discord.removed')));
        }

        $discord = $user->discord;
        if ($discord->revokeAccess()) {

            $discord->delete();
            return Redirect::route('profile.index')
                ->with('toast', createToast('success', __('profiles.discord.discord'), __('profiles.discord.removed')));
        }

        userLog('Ajout du compte discord', UserLog::COLOR_SUCCESS, UserLog::ICON_ADD);

        return Redirect::route('profile.index')
            ->with('toast', createToast('success', __('profiles.discord.discord'), __('profiles.discord.removed')));
    }

    public function downloadRecoveryCode(): \Illuminate\Http\Response
    {

        $content = "";
        foreach (json_decode(decrypt(user()->two_factor_recovery_codes), true) as $code) {
            $content .= $code;
            $content .= "\n";
        }

        // file name that will be used in the download
        $fileName = "MIB-recovery-codes.txt";

        // use headers in order to generate the download
        $headers = [
            'Content-type' => 'text/plain',
            'Content-Disposition' => sprintf('attachment; filename="%s"', $fileName),
            'Content-Length' => strlen($content)
        ];

        userLog('Téléchargement des codes de double authentification', UserLog::COLOR_SUCCESS, UserLog::ICON_DOWNLOAD);

        // make a response, with the content, a 200 response code and the headers
        return Response::make($content, 200, $headers);

    }

    /**
     * Permet de générer le code pour la commande
     *
     * @return string
     */
    public function createCommand(): string
    {

        $user = user();
        $tokens = $user->tokens()->where('name', env('TOKEN_NAME'))->get();
        foreach ($tokens as $token) {
            $token->delete();
        }

        userLog('Création de la commande', UserLog::COLOR_SUCCESS, UserLog::ICON_CODE);

        return $user->createToken(env('TOKEN_NAME'), [env('ABILITY_RESOURCE')])->plainTextToken;
    }

}
