<?php


namespace App\Payment\Method;


use App\Models\Payment\Gift;
use App\Models\Payment\Payment;
use App\Models\User;
use App\Payment\PaymentMethod;
use Illuminate\Http\Request;

class PaypalMethod extends PaymentMethod
{

    protected $name = "PayPal";


    public function startPayment(User $user, User\UserPaymentInfo $paymentInfo, Payment $payment, float $price, Gift $gift = null): mixed
    {
        // TODO: Implement startPayment() method.
        return "";
    }

    public function process(Request $request, ?string $paymentId): mixed
    {
        // TODO: Implement process() method.
    }
}
