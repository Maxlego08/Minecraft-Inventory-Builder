<?php

namespace App\Http\Controllers;

use App\Models\Payment\Gift;
use App\Models\Payment\Payment;
use App\Models\Resource\Resource;
use App\Models\User\NameColor;
use App\Models\User\UserPaymentInfo;
use App\Models\UserLog;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

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
        user()->clear('user.color');
        userLog("Suppression de la couleur de pseudo", UserLog::COLOR_DANGER, UserLog::ICON_TRASH);
        return Redirect::back()->with('toast', createToast('success', __('colors.remove.title'), __('colors.remove.description'), 5000));
    }

    /**
     * Permet d'afficher la page pour acheter une couleur
     *
     * @param NameColor $nameColor
     * @return Application|Factory|View|\Illuminate\Foundation\Application|RedirectResponse
     */
    public function checkout(NameColor $nameColor): \Illuminate\Foundation\Application|View|Factory|RedirectResponse|Application
    {
        // Si l'utilisateur à déjà accès à la resource ou que le prix est à 0, alors on retourne en arrière
        if ($nameColor->price == 0 || (user()->hasNameAccess($nameColor) && !user()->isAdmin())) {
            return Redirect::route('profile.colors.index');
        }

        $paymentInfo = UserPaymentInfo::where('id', env('PAYMENT_INFO_ADMIN_ID'))->first();
        $name = __("colors.$nameColor->code");

        // Sinon, on affiche la page d'achat
        return view('resources.purchase.checkout', [
            'paymentInfo' => $paymentInfo,
            'price' => $nameColor->getPrice(),
            'currency' => 'eur',
            'confirmUrl' => route('profile.colors.purchase', $nameColor),
            'name' => "Name Color : <span class='$nameColor->code'>$name</span>",
            'enableGift' => false,
        ]);
    }

    /**
     * Commencer l'achat d'une couleur
     *
     * @param Request $request
     * @param NameColor $nameColor
     * @return mixed
     * @throws ValidationException
     */
    public function purchase(Request $request, NameColor $nameColor): mixed
    {
        $this->validate($request, ['terms' => ['accepted'],]);

        $user = user();
        $payment = Payment::makeDefault($user, $nameColor->getPrice(), Payment::TYPE_NAME_COLOR, $nameColor->id, env('CURRENCY_ADMIN_ID'), 'stripe');

        return paymentManager()->startPaymentNameColor($request, $nameColor, $payment);
    }

}
