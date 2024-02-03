<?php

namespace App\Listeners;

use App\Payment\Events\PaymentCancel;

class PaymentCancelNotification
{

    const EVENT = 'event.payment.canceled';

    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(PaymentCancel $paymentCancel): void
    {
        paymentManager()->sendDiscordWebhook($paymentCancel->payment, self::EVENT);
    }
}
