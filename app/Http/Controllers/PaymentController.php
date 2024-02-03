<?php

namespace App\Http\Controllers;

use App\Models\Payment\Currency;
use App\Models\User\UserPaymentInfo;
use App\Models\UserLog;
use App\Payment\utils\StripeWebhook;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\ValidationException;
use Stripe\Exception\ApiErrorException;

class PaymentController extends Controller
{
    /**
     * Afficher la page des paiements de l'utilisateur
     *
     * @return \Illuminate\Contracts\Foundation\Application|Factory|View|Application
     */
    public function index(): Application|View|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $paymentInfo = user()->paymentInfo ?? null;
        $currencies = Currency::all();
        return view('members.payment.index', [
            'paymentInfo' => $paymentInfo,
            'currency' => $paymentInfo->currency->id ?? 1,
            'currencies' => $currencies,
        ]);
    }

    /**
     * Mettre à jour ses informations stipe
     *
     * @param Request $request
     * @return RedirectResponse
     * @throws ValidationException
     * @throws ApiErrorException
     */
    public function storeStripe(Request $request): RedirectResponse
    {

        $this->validate($request, [
            'pk_live' => ['required'],
            'sk_live' => ['required'],
        ]);

        $pk_live = $request['pk_live'];
        if (!str_starts_with($pk_live, 'pk_live') && env('APP_DEBUG') === false) {
            return Redirect::back()->with('toast', createToast('error', __('payment.stripe.error_pk_live.title'), __('payment.stripe.error_pk_live.description'), 5000));
        }

        $sk_live = $request['sk_live'];
        if (!str_starts_with($sk_live, 'sk_live') && env('APP_DEBUG') === false) {
            return Redirect::back()->with('toast', createToast('error', __('payment.stripe.error_sk_live.title'), __('payment.stripe.error_sk_live.description'), 5000));
        }

        $paymentInfo = user()->paymentInfo;
        if (isset($paymentInfo)) {
            $paymentInfo->update($request->all());
        } else {
            $paymentInfo = UserPaymentInfo::create([
                'user_id' => user()->id,
                'sk_live' => $sk_live,
                'pk_live' => $pk_live
            ]);
        }

        try {
            $stripeWebhook = new StripeWebhook($paymentInfo);
            $stripeWebhook->make();
        } catch (ApiErrorException $exception) {
            $paymentInfo->update([
                'pk_live' => null,
                'sk_live' => null,
            ]);
            return Redirect::back()->with('toast', createToast('error', __('payment.stripe.error_api.title'), __('payment.stripe.error_api.description'), 5000));
        }

        userLog("Ajout des informations Stripe", UserLog::COLOR_SUCCESS, UserLog::ICON_EURO);

        return Redirect::route('profile.payment.index')->with('toast', createToast('success', __('payment.stripe.success.title'), __('payment.stripe.success.description'), 5000));
    }

    /**
     * Mettre à jour ses informations paypal
     *
     * @param Request $request
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function storePaypal(Request $request): RedirectResponse
    {

        $this->validate($request, [
            'paypal_email' => ['required', 'string', 'email', 'max:100'],
        ]);

        $paymentInfo = user()->paymentInfo;
        if (isset($paymentInfo)) {
            $paymentInfo->update($request->all());
        } else {
            UserPaymentInfo::create([
                'user_id' => user()->id,
                'paypal_email' => $request['paypal_email']
            ]);
        }

        userLog("Ajout d'un email Paypal ({$request['paypal_email']})", UserLog::COLOR_SUCCESS, UserLog::ICON_EURO);

        return Redirect::route('profile.payment.index')->with('toast', createToast('success', __('payment.paypal.success.title'), __('payment.paypal.success.description'), 5000));
    }

    /**
     * Supprime stripe
     *
     * @return RedirectResponse
     */
    function deleteStripe(): RedirectResponse
    {
        $paymentInfo = user()->paymentInfo;
        $paymentInfo->update([
            'sk_live' => null,
            'pk_live' => null,
        ]);

        userLog("Suppression de Stripe", UserLog::COLOR_DANGER, UserLog::ICON_TRASH);

        return Redirect::route('profile.payment.index')->with('toast', createToast('success', __('payment.stripe.delete.title'), __('payment.stripe.delete.description'), 5000));
    }

    /**
     * Supprimer paypal
     *
     * @return RedirectResponse
     */
    function deletePaypal(): RedirectResponse
    {
        $paymentInfo = user()->paymentInfo;
        $paymentInfo->update([
            'paypal_email' => null,
        ]);

        userLog("Suppression de Paypal", UserLog::COLOR_DANGER, UserLog::ICON_TRASH);

        return Redirect::route('profile.payment.index')->with('toast', createToast('success', __('payment.paypal.delete.title'), __('payment.paypal.delete.description'), 5000));
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     * @throws ValidationException
     */
    function storeCurrency(Request $request): RedirectResponse
    {
        $this->validate($request, [
            'currency' => ['required'],
        ]);

        $currency = Currency::find($request['currency']);
        $currencyIcon = '€';

        if (!isset($currency)) {
            $currency = 1;
        } else {
            $currencyIcon = $currency->icon;
            $currency = $currency->id;
        }

        $paymentInfo = user()->paymentInfo;
        $oldCurrency = '€';
        if (isset($paymentInfo)) {
            $oldCurrency = $paymentInfo->currency->icon;
            $paymentInfo->update([
                'currency_id' => $currency,
            ]);
        } else {
            UserPaymentInfo::create([
                'user_id' => user()->id,
                'currency_id' => $currency
            ]);
        }

        user()->clear('user.currency');
        userLog("Mise à jour de la devise, $oldCurrency vers $currencyIcon", UserLog::COLOR_SUCCESS, UserLog::ICON_EURO);

        return Redirect::route('profile.payment.index')->with('toast', createToast('success', __('payment.currency.success.title'), __('payment.currency.success.description'), 5000));
    }

}
