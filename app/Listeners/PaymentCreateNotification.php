<?php

namespace App\Listeners;

use App\Payment\Events\PaymentCreate;

class PaymentCreateNotification
{
    const EVENT = 'event.payment.created';

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
    public function handle(PaymentCreate $paymentCreate): void
    {
        paymentManager()->sendDiscordWebhook($paymentCreate->payment, self::EVENT);
    }
}
