<?php


namespace App\Payment;

use App\Models\Alert\AlertUser;
use App\Models\Payment\Gift;
use App\Models\Payment\Payment;
use App\Models\Resource\Access;
use App\Models\User;
use App\Models\UserLog;
use App\Payment\Events\PaymentPaid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

abstract class PaymentMethod
{

    protected $name;

    /**
     * Commencer un paiement
     *
     * @param User $user
     * @param User\UserPaymentInfo $paymentInfo
     * @param Payment $payment
     * @param float $price
     * @param Gift|null $gift
     * @return mixed
     */
    abstract public function startPayment(User $user, User\UserPaymentInfo $paymentInfo, Payment $payment, float $price, Gift $gift = null): mixed;

    /**
     * Lorsqu'une notification est reçue
     *
     * @param Request $request
     * @param string|null $paymentId
     * @return mixed
     */
    abstract public function process(Request $request, ?string $paymentId): mixed;

    /**
     * Process le paiement
     *
     * @param Request $request
     * @param Payment $payment
     * @return string
     */
    protected function postProcessPayment(Request $request, Payment $payment): string
    {
        // On va mettre à jour le status du paiement
        $payment->update(['status' => Payment::STATUS_PAID,]);
        // On va utiliser le code cadeau
        $payment->updateGiftCode();
        // Gestion des accès lié au paiement
        switch ($payment->type) {
            case Payment::TYPE_RESOURCE :
            {
                $resource = $payment->resource;
                Access::create(['user_id' => $payment->user_id, 'resource_id' => $payment->content_id, 'payment_id' => $payment->id]);
                Cache::forget("user.access::$payment->user_id");

                createAlert($payment->user_id, $resource->name, AlertUser::ICON_SUCCESS, AlertUser::SUCCESS, 'alerts.alerts.resources.purchased', $resource->link('description'));

                userLogOffline($payment->user_id, "Ressource achetée $resource->name.$resource->id", UserLog::COLOR_SUCCESS, UserLog::ICON_ADD);
            }
            case Payment::TYPE_ACCOUNT_UPGRADE :
            {

            }
            case Payment::TYPE_NAME_COLOR :
            {
                $nameColor = $payment->nameColor;
                User\NameColorAccess::create(['user_id' => $payment->user_id, 'color_id' => $payment->content_id, 'payment_id' => $payment->id]);

                createAlert($payment->user_id, $nameColor->translation(), AlertUser::ICON_SUCCESS, AlertUser::SUCCESS, 'alerts.alerts.name_color.purchased');

                userLogOffline($payment->user_id, "Couleur achetée {$nameColor->translation()}.$nameColor->id", UserLog::COLOR_SUCCESS, UserLog::ICON_ADD);
            }
        }

        // TODO
        // Gérer les mails
        // Gérer les notifications
        // Gérer les webhooks discord
        // Gérer les logs

        event(new PaymentPaid($payment));

        return json_encode(['status' => 'true']);
    }

    /**
     * Retirer l'accès à un contenu lié au paiement
     *
     * @param Payment $payment
     * @return void
     */
    protected function removeAccess(Payment $payment): void
    {

        $user = $payment->user;
        switch ($payment->type) {
            case Payment::TYPE_RESOURCE :
            {
                $access = Access::where('user_id', $payment->user_id)->where('resource_id', $payment->content_id)->first();
                $access?->delete();

                $user->clear('user.resource_access');
                break;
            }
            case Payment::TYPE_ACCOUNT_UPGRADE :
            {
                break;
            }
            case Payment::TYPE_NAME_COLOR :
            {
                $access = User\NameColorAccess::where('user_id', $payment->user_id)->where('color_id', $payment->content_id)->first();
                $access?->delete();

                $user->update(['name_color_id' => null]);
                $user->clear('user.clear');
                break;
            }
        }
    }

}
