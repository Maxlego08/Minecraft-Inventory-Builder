<?php

namespace App\Http\Controllers;

use App\Models\Payment\Gift;
use App\Models\Payment\Payment;
use App\Models\User\UserPaymentInfo;
use App\Models\UserRole;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\ValidationException;

class PremiumController extends Controller
{
    /**
     * Afficher la page d'achat
     *
     * @return View|\Illuminate\Foundation\Application|Factory|Application
     */
    public function index(): View|\Illuminate\Foundation\Application|Factory|Application
    {
        return view('members.premium');
    }

    /**
     * Permet d'afficher la page d'achat de rôle
     *
     * @param UserRole $userRole
     * @return View|\Illuminate\Foundation\Application|Factory|RedirectResponse|Application
     */
    public function checkout(UserRole $userRole): View|\Illuminate\Foundation\Application|Factory|RedirectResponse|Application
    {

        // Si l'utilisateur à déjà le role
        if (user()->role->power >= $userRole->power && !user()->isAdmin()) {
            return Redirect::route('premium.index')->with('toast', createToast('error', 'Huummmmm', "its very nice to you to want to buy this upgrade again, but you already owned it."));
        }

        if ($userRole->power != UserRole::PREMIUM && $userRole->power != UserRole::PRO) {
            return Redirect::route('premium.index')->with('toast', createToast('error', 'Huummmmm', "You can't purchase this, sad :'("));
        }

        $paymentInfo = UserPaymentInfo::where('id', env('PAYMENT_INFO_ADMIN_ID'))->first();
        $name = $userRole->power == UserRole::PRO ? __("upgrade.pro") : __("upgrade.premium");

        $price = $userRole->price;
        $reduction = [];
        if ($userRole->isPro() && user()->role->isPremium()) {
            $reduction = [
                'name' => 'Premium',
                'reduction' => 14.99,
            ];
        }

        // Sinon, on affiche la page d'achat
        return view('resources.purchase.checkout', [
            'paymentInfo' => $paymentInfo,
            'price' => $price,
            'currency' => 'eur',
            'confirmUrl' => route('premium.purchase', $userRole),
            'name' => $name,
            'enableGift' => true,
            'contentType' => UserRole::class,
            'contentId' => $userRole->id,
            'reduction' => $reduction,
        ]);
    }

    /**
     * Acheter un role
     *
     * @param Request $request
     * @param UserRole $userRole
     * @return mixed
     * @throws ValidationException
     */
    public function purchase(Request $request, UserRole $userRole): mixed
    {
        $this->validate($request, ['terms' => ['accepted']]);

        $user = user();
        $payment = Payment::makeDefault($user, $userRole->price, Payment::TYPE_ACCOUNT_UPGRADE, $userRole->id, env('CURRENCY_ADMIN_ID'), 'stripe');

        $gift = null;
        if (isset($request['gift'])) {
            $gift = Gift::where('code', $request['gift'])->first();
        }

        $price = $userRole->price;
        if ($userRole->power == UserRole::PRO && user()->role->isPremium()) {
            $price -= 14.99;
        }

        return paymentManager()->startPaymentInterne($request, $price, $payment, $gift, UserRole::class);

    }
}
