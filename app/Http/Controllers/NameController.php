<?php

namespace App\Http\Controllers;

use App\Models\User\NameColor;
use App\Models\UserLog;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redirect;

class NameController extends Controller
{
    /**
     * Affiche la page des couleurs
     *
     * @return View|\Illuminate\Foundation\Application|Factory|Application
     */
    public function index(): View|\Illuminate\Foundation\Application|Factory|Application
    {

        $colors = Cache::remember('colors', 86400, function () {
            return NameColor::all();
        });

        return view('members.colors.index', ['colors' => $colors,]);
    }

    /**
     * Permet d'activer la couleur pour le joueur
     *
     * @param NameColor $nameColor
     * @return RedirectResponse
     */
    public function active(NameColor $nameColor): RedirectResponse
    {

        $user = user();

        if ($user->hasNameAccess($nameColor)) {

            $user->update(['name_color_id' => $nameColor->id]);

            Cache::forget('resources:mostResources');
            $user->clear('user.color');

            foreach ($user->resources as $resource) {
                $resource->clear('resource.user');
            }

            $name = __('colors.' . $nameColor->code);
            userLog("Utilisation de la couleur $name.$nameColor->id", UserLog::COLOR_SUCCESS, UserLog::ICON_ADD);

            return Redirect::back()->with('toast', createToast('success', __('colors.success.title'), __('colors.success.description'), 5000));
        } else {

            return Redirect::back()->with('toast', createToast('error', __('colors.error.title'), __('colors.error.description'), 5000));
        }
    }

    /**
     * Désactiver la couleur de son pseudo
     *
     * @return RedirectResponse
     */
    public function disable(): RedirectResponse
    {
        user()->update(['name_color_id' => null]);
        userLog("Suppression de la couleur de pseudo", UserLog::COLOR_DANGER, UserLog::ICON_TRASH);
        return Redirect::back()->with('toast', createToast('success', __('colors.remove.title'), __('colors.remove.description'), 5000));
    }

}
