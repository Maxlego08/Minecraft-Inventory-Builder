<?php


namespace App\Payment;

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

        if ($payment->type == Payment::TYPE_RESOURCE) {

            $resource = $payment->resource;
            Access::create([
                'user_id' => $payment->user_id,
                'resource_id' => $payment->content_id,
                'payment_id' => $payment->id
            ]);
            Cache::forget("user.access::$payment->user_id");

            userLogOffline($payment->user_id, "Ressource acheté $resource->name.$resource->id", UserLog::COLOR_SUCCESS, UserLog::ICON_ADD);
        }

        // TODO
        // Gérer les mails
        // Gérer les notifications
        // Gérer les webhooks discord
        // Gérer les logs

        event(new PaymentPaid($payment));

        return json_encode(['status' => 'true']);
    }

    protected function removeAccess(Payment $payment)
    {

        if ($payment->type == Payment::TYPE_RESOURCE) {
            $access = Access::where('user_id', $payment->user_id, 'resource_id', $payment->content_id);
            if (isset($access)) {
                $access->delete();
            }
        }

    }

}
