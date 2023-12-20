<?php

namespace App\Listeners;

use App\Payment\Events\PaymentPaid;
use App\Payment\Events\PaymentRefund;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class PaymentRefundNotification
{
    const EVENT = 'event.payment.refunded';

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
    public function handle(PaymentRefund $paymentRefund): void
    {
        paymentManager()->sendDiscordWebhook($paymentRefund->payment, self::EVENT);
    }
}
