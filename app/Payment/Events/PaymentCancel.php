<?php


namespace App\Payment\Events;


use App\Models\Payment\Payment;

class PaymentCancel
{

    /**
     * @var Payment
     */
    public $payment;

    /**
     * PaymentPaid constructor.
     * @param Payment $payment
     */
    public function __construct(Payment $payment)
    {
        $this->payment = $payment;
    }

}
