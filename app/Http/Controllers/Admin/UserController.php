<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment\Currency;
use App\Models\User;
use App\Models\UserLog;
use App\Models\UserRole;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{

    /**
     * See users
     *
     * @param Request $request
     * @return View|\Illuminate\Foundation\Application|Factory|Application
     */
    public function index(Request $request): View|\Illuminate\Foundation\Application|Factory|Application
    {

        $search = $request->input('search');
        $users = User::select('users.*')
            ->when($search, function ($query, $search) {
                return $query
                    ->where('users.name', 'like', '%' . $search . '%')
                    ->orWhere('users.email', 'like', '%' . $search . '%');
            })
            ->paginate();
        return view('admins.users.index', [
            'users' => $users,
            'search' => $search
        ]);

    }

    /**
     * @param User $user
     * @return Application|Factory|View|\Illuminate\Foundation\Application
     */
    public function show(User $user): \Illuminate\Foundation\Application|View|Factory|Application
    {
        $resources = $user->resources()->paginate(10, ['*'], 'resources');
        $logs = $user->logs()->latest()->paginate(10, ['*'], 'logs');
        $inventories = $user->inventories()->latest()->paginate(10, ['*'], 'inventories');

        $roles = UserRole::all();
        $colors = User\NameColor::all();
        return view('admins.users.show', [
            'resources' => $resources,
            'user' => $user,
            'roles' => $roles,
            'logs' => $logs,
            'colors' => $colors,
            'currencies' => Currency::all(),
            'nameColorAccesses' => $user->nameColorAccesses,
            'inventories' => $inventories,
        ]);
    }

    /**
     * @param Request $request
     * @param User $user
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function store(Request $request, User $user): RedirectResponse
    {
        $this->validate($request, [
            'name' => ['required', 'string', 'max:16', 'min:3', 'regex:/^[a-zA-Z0-9_]+$/u'],
            'email' => ['required', 'string', 'email', 'max:100', 'unique:users,email,' . $user->id],
        ]);

        $user->update($request->all());
        if ($request->has('name_color')) {
            $nameColor = $request['name_color'];
            if ($nameColor != '-1') {
                $user->update(['name_color_id' => $nameColor]);
            } else if ($user->name_color_id) {
                $user->update(['name_color_id' => null]);
            }
        }
        if ($request->has('new-password')) {
            $password = $request['new-password'];
            if (strlen($password) > 6) {
                $user->update(['password' => Hash::make($password),]);
            } else
                if (strlen($password) >= 1) {

                    return Redirect::back()->withInput()->withErrors([
                        'password' => 'Le mot de passe doit avoir au minimum 6 characters.'
                    ]);
                }
        }

        Cache::forget('resources:mostResources');
        foreach ($user->resources as $resource) {
            $resource->clear('resource.user');
        }
        $user->clear('user.color');
        $user->clear('user.role');
        $user->clear('user.access');

        userLog("Modification de l'utilisateur $user->name.$user->id", UserLog::COLOR_WARNING, UserLog::ICON_EDIT);

        return Redirect::route('admin.users.show', ['user' => $user])->with('toast',
            createToast('success', 'Succès', "Modification de l'utilisateur $user->name"));
    }

    /**
     * Supprimer la photo de profile d'un utilisateur
     *
     * @param User $user
     * @return RedirectResponse
     */
    public
    function deleteIcon(User $user): RedirectResponse
    {
        $user->deleteProfilePhoto();
        foreach ($user->resources as $resource) {
            $resource->clear('resource.user');
        }

        userLog("Suppression de la photo de profile l'utilisateur $user->name.$user->id", UserLog::COLOR_DANGER, UserLog::ICON_TRASH);

        return Redirect::route('admin.users.show', ['user' => $user])->with('toast',
            createToast('success', 'Succès', "Suppression de la photo de profile l'utilisateur " . $user->name));
    }

    /**
     * Supprimer la photo de profile d'un utilisateur
     *
     * @param User $user
     * @return RedirectResponse
     */
    public
    function deleteBanner(User $user): RedirectResponse
    {
        $user->deleteBannerPhoto();

        userLog("Suppression de la bannière l'utilisateur $user->name.$user->id", UserLog::COLOR_DANGER, UserLog::ICON_TRASH);

        return Redirect::route('admin.users.show', ['user' => $user])->with('toast',
            createToast('success', 'Succès', "Suppression de la bannière l'utilisateur " . $user->name));
    }

    /**
     * Supprimer la photo de profile d'un utilisateur
     *
     * @param User $user
     * @return RedirectResponse
     */
    public
    function deleteDiscord(User $user): RedirectResponse
    {

        $discord = $user->discord;
        if ($discord->revokeAccess()) {
            $discord->delete();
        }

        userLog("Suppression du compte discord de $user->name.$user->id", UserLog::COLOR_DANGER, UserLog::ICON_REMOVE);

        return Redirect::route('admin.users.show', ['user' => $user])->with('toast',
            createToast('success', 'Succès', "Suppression du compte discord de " . $user->name));
    }

    /**
     * Supprimer la double authentification d'une personne
     *
     * @param User $user
     * @return RedirectResponse
     */
    public
    function deleteDoubleAuth(User $user): RedirectResponse
    {
        $user->two_factor_secret = null;
        $user->two_factor_recovery_codes = null;
        $user->two_factor_confirmed_at = null;
        $user->save();

        userLog("Suppression de la double authentification de $user->name.$user->id", UserLog::COLOR_DANGER, UserLog::ICON_REMOVE);

        return Redirect::route('admin.users.show', ['user' => $user])->with('toast',
            createToast('success', 'Succès', "Suppression de la double authentification de $user->name"));
    }

    /**
     * Modification des informations de paiement
     *
     * @param User $user
     * @param Request $request
     * @return RedirectResponse
     */
    public
    function updatePayment(User $user, Request $request): RedirectResponse
    {
        $user->paymentInfo->update($request->all());
        userLog("Modification des informations de paiement de $user->name.$user->id", UserLog::COLOR_DANGER, UserLog::ICON_REMOVE);

        return Redirect::route('admin.users.show', ['user' => $user])->with('toast',
            createToast('success', 'Succès', "Modification des informations de paiement de $user->name"));
    }

}
