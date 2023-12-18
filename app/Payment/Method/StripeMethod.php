<?php

namespace App\Payment\Method;

use App\Models\Payment\Gift;
use App\Models\Payment\Payment;
use App\Models\User;
use App\Models\User\UserPaymentInfo;
use App\Models\UserLog;
use App\Payment\Events\PaymentDispute;
use App\Payment\Events\PaymentRefund;
use App\Payment\PaymentMethod;
use App\Payment\utils\StripeWebhook;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Stripe\Checkout\Session;
use Stripe\Exception\ApiErrorException;
use Stripe\Exception\SignatureVerificationException;
use Stripe\Stripe;
use Stripe\Webhook;
use function Symfony\Component\Translation\t;

class StripeMethod extends PaymentMethod
{

    protected $name = "Stripe";


    /**
     * @throws ApiErrorException
     */
    public function startPayment(User $user, User\UserPaymentInfo $paymentInfo, Payment $payment, float $price, Gift $gift = null): mixed
    {

        // Vérifier si l'endpoint est correcte
        try {
            $stripeWebhook = new StripeWebhook($paymentInfo);
            $stripeWebhook->make();
        } catch (Exception) {
            return Redirect::back()->with('toast', createToast('error', 'Error', 'Impossible to create Stripe Webhook', 5000));
        }

        Stripe::setApiKey($paymentInfo->sk_live);

        $name = $payment->getPaymentType();
        $description = $payment->getPaymentDescription();
        $content = $payment->getPaymentContent();
        $logo = $payment->getPaymentLogo();

        $session = $this->createSession($paymentInfo, $user, $price, $name, $description, $content, $payment->payment_id, $logo);

        userLog("Création du paiement $payment->payment_id.$payment->id", UserLog::COLOR_SUCCESS, UserLog::ICON_ADD);

        $pk_live = $paymentInfo->pk_live;
        return view('resources.purchase.stripe', ['pk_live' => $pk_live, 'payment_id' => $session->id]);
    }

    /**
     * Create une session stripe
     *
     * @param UserPaymentInfo $paymentInfo
     * @param User $user
     * @param $price
     * @param string $name
     * @param string $description
     * @param string $content
     * @param string $paymentId
     * @param string|null $logo
     * @return Session
     * @throws ApiErrorException
     */
    private function createSession(User\UserPaymentInfo $paymentInfo, User $user, $price, string $name, string $description, string $content, string $paymentId, string $logo = null): Session
    {
        return Session::create([ // -
            'payment_method_types' => ['card'], // -
            'customer_email' => $user->email, // -
            'line_items' => [ // -
                ['price_data' => [ // -
                    'currency' => $paymentInfo->currency->currency, // -
                    'unit_amount' => (int)($price * 100), // -
                    'product_data' => [ // -
                        'name' => $name, // -
                        'description' => $description,// -
                        'images' => [$logo,] // -
                    ], // -
                ], 'quantity' => 1,] // -
            ], // -
            'mode' => 'payment', // -
            'success_url' => route('resources.payment.success', $paymentId), // -
            'cancel_url' => route('resources.payment.cancel', $paymentId), // -
            'client_reference_id' => $paymentId, // -
            'payment_intent_data' => [ // -
                'description' => 'Minecraft Inventory Builder - ' . $content . ' | ' . $user->name . '.' . $user->id, // -
            ],]);
    }

    public function process(Request $request, ?string $paymentId): mixed
    {
        $referenceId = $request['data']['object']['client_reference_id'];

        $payment = Payment::where('payment_id', $referenceId)->first();

        if (!isset($payment)) {
            return json_encode(['status' => 'error', 'message' => 'Payment not found',]);
        }

        $endpointSecret = $payment->getEndpoint();

        if ($endpointSecret === null) return json_encode(['status' => 'error', 'message' => 'User endpoint secrset not found',]);

        $stripeSignature = $request->header('Stripe-Signature');

        try {
            $event = Webhook::constructEvent($request->getContent(), $stripeSignature, $endpointSecret);
        } catch (SignatureVerificationException $exception) {
            return json_encode(['status' => 'error', 'message' => $exception->getMessage(),]);
        }

        switch ($event->type) {
            case 'checkout.session.completed':
                if ($payment->isPaid()) return json_encode(['status' => 'error', 'message' => 'The payment is already validated.',]);
                if ($payment->isDispute()) return json_encode(['status' => 'error', 'message' => 'The payment is in dispute.',]);
                return $this->processPayment($request, $payment);
            case 'charge.refunded':
                if ($payment->isDispute()) return json_encode(['status' => 'error', 'message' => 'The payment is in dispute.',]);
                if (!$payment->isPaid()) return json_encode(['status' => 'error', 'message' => 'The payment is not validated.',]);
                return $this->refundPayment($request, $payment);
            case 'charge.dispute.created':
                if ($payment->isDispute()) return json_encode(['status' => 'error', 'message' => 'The payment is in dispute.',]);
                if (!$payment->isPaid()) return json_encode(['status' => 'error', 'message' => 'The payment is not validated.',]);
                return $this->disputePayment($request, $payment);
            default:
                return json_encode(['status' => 'error', 'message' => 'Method ' . $event->type . ' not found',]);
        }
    }

    private function processPayment(Request $request, Payment $payment): string
    {
        $paymentIntent = $request['data']['object']['payment_intent'];
        $payment->update(['external_id' => $paymentIntent]);

        return $this->postProcessPayment($request, $payment);
    }

    private function refundPayment(Request $request, Payment $payment): string|bool
    {
        $payment->update(['status' => Payment::STATUS_REFUND]);
        $this->removeAccess($payment);

        event(new PaymentRefund($payment));

        userLog("Remboursement du paiement $payment->payment_id.$payment->id", UserLog::COLOR_DANGER, UserLog::ICON_REMOVE);

        return json_encode(['status' => 'success',]);
    }

    private function disputePayment(Request $request, Payment $payment): string|bool
    {
        $payment->update(['status' => Payment::STATUS_DISPUTE]);
        $this->removeAccess($payment);

        event(new PaymentDispute($payment));

        userLog("Litige du paiement $payment->payment_id.$payment->id", UserLog::COLOR_DANGER, UserLog::ICON_REMOVE);

        return json_encode(['status' => 'success',]);
    }
}
