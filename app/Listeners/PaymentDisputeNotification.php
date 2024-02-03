<?php

namespace App\Listeners;

use App\Payment\Events\PaymentCreate;
use App\Payment\Events\PaymentDispute;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class PaymentDisputeNotification
{
    const EVENT = 'event.payment.dispute.created';

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
    public function handle(PaymentDispute $dispute): void
    {
        paymentManager()->sendDiscordWebhook($dispute->payment, self::EVENT);
    }
}
