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

        userLog("(Paypal) Création du paiement $payment->payment_id.$payment->id", UserLog::COLOR_SUCCESS, UserLog::ICON_ADD);

        return redirect()->away('https://www.paypal.com/cgi-bin/webscr?' . Arr::query($attributes));
    }

    public function process(Request $request, ?string $paymentId): mixed
    {
        // TODO: Implement process() method.
        return "";
    }
}
