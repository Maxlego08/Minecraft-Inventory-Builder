<?php


namespace App\Payment\Method;


use App\Models\Log;
use App\Models\Payment\Gift;
use App\Models\Payment\Payment;
use App\Models\User;
use App\Models\UserLog;
use App\Payment\PaymentMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class PaypalMethod extends PaymentMethod
{

    protected $name = "PayPal";


    public function startPayment(User $user, User\UserPaymentInfo $paymentInfo, Payment $payment, float $price, Gift $gift = null): mixed
    {

        $name = $payment->getPaymentType();
        $content = $payment->getPaymentContent();

        $attributes = [
            'cmd' => '_xclick',
            'charset' => 'utf-8',
            'business' => $paymentInfo->paypal_email,
            'amount' => $price,
            'currency_code' => strtoupper($paymentInfo->currency->currency),
            'item_name' => "$name - $user->name.$user->id",
            'quantity' => 1,
            'no_shipping' => 1,
            'no_note' => 1,
            'return' => route('resources.payment.success', $payment->payment_id),
            'cancel_url' => route('resources.payment.cancel', $payment->payment_id),
            'notify_url' => route('api.v1.notification', ['payment' => 'paypal']),
            'custom' => $payment->id,
            'bn' => 'Minecraft Inventory Builder',
        ];

        logger()->channel('paypal')->info("Start Paypal paiement $payment->payment_id.$payment->id");
        userLog("(Paypal) Création du paiement $payment->payment_id.$payment->id", UserLog::COLOR_SUCCESS, UserLog::ICON_ADD);

        return redirect()->away('https://www.paypal.com/cgi-bin/webscr?' . Arr::query($attributes));
    }

    public function process(Request $request, ?string $paymentId): mixed
    {
        $data = ['cmd' => '_notify-validate'] + $request->all();
        logger()->channel('paypal')->info("Réception des données pour $paymentId", $request->all());

        $response = Http::asForm()->post('https://ipnpb.paypal.com/cgi-bin/webscr', $data);
        if ($response->body() !== 'VERIFIED') {
            logger()->channel('paypal')->info("Wrong paypal informations for $paymentId");
            return response()->json('Invalid response');
        }

        $paymentId = $request->input('txn_id');
        $amount = (float)$request->input('mc_gross');
        $currency = $request->input('mc_currency');
        $status = $request->input('payment_status');
        $receiverEmail = Str::lower($request->input('receiver_email'));

        logger()->channel('paypal')->info("[Paypal] Receive information with paymentID: " . $paymentId);
        logger()->channel('paypal')->info("[Paypal] Status: " . $status);
        logger()->channel('paypal')->info("[Paypal] Email: " . $receiverEmail);
        logger()->channel('paypal')->info("[Paypal] Current: " . $currency);
        logger()->channel('paypal')->info("[Paypal] Amount: " . $amount);
        logger()->channel('paypal')->info("[Paypal] Request: " . json_encode($request->all()));

        $payment = Payment::findOrFail($request->input('custom'));

        logger()->channel('paypal')->info("[Paypal] PaymentID: " . $payment->id);

        if ($status === 'Pending') {
            logger()->channel('paypal')->info("[Paypal] Pending payment for #{$paymentId}: {$status}");
            $payment->update([
                'external_id' => $paymentId,
                'status' => Payment::STATUS_PENDING,
            ]);
            return response()->noContent();
        }

        if ($status !== 'Completed') {
            return json_encode([
                'status' => 'payment Invalid'
            ]);
        }

        logger()->channel('paypal')->info("[Paypal] Payment is valid !");

        if ($paymentId != null) {
            $payment->update(['external_id' => $paymentId]);
        }

        return $this->postProcessPayment($request, $payment);
    }
}
