<?php

namespace App\Listeners;

use App\Payment\Events\PaymentDispute;
use App\Payment\Events\PaymentPaid;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class PaymentPaidNotification
{
    const EVENT = 'event.payment.completed';

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
    public function handle(PaymentPaid $paymentPaid): void
    {
        paymentManager()->sendDiscordWebhook($paymentPaid->payment, self::EVENT);
    }
}
