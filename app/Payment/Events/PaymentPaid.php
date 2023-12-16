<?php


namespace App\Payment\Events;


use App\Models\Payment\Payment;

/**
 * Class PaymentPaid
 * @package App\Payment\events
 * @property Payment $payment
 */
class PaymentPaid
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
