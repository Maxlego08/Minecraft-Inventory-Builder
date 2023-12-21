<?php

namespace App\Providers;

use App\Listeners\LoginListener;
use App\Listeners\PaymentCancelNotification;
use App\Listeners\PaymentCreateNotification;
use App\Listeners\PaymentDisputeNotification;
use App\Listeners\PaymentPaidNotification;
use App\Listeners\PaymentRefundNotification;
use App\Listeners\ResourceCreateNotification;
use App\Listeners\ResourceDownloadNotification;
use App\Listeners\ResourceUpdateNotification;
use App\Payment\Events\PaymentCancel;
use App\Payment\Events\PaymentCreate;
use App\Payment\Events\PaymentDispute;
use App\Payment\Events\PaymentPaid;
use App\Payment\Events\PaymentRefund;
use App\Payment\utils\Resources\ResourceCreate;
use App\Payment\utils\Resources\ResourceDownload;
use App\Payment\utils\Resources\ResourceUpdate;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        Login::class => [
            LoginListener::class,
        ],
        PaymentPaid::class => [
            PaymentPaidNotification::class,
        ],
        PaymentRefund::class => [
            PaymentRefundNotification::class,
        ],
        PaymentDispute::class => [
            PaymentDisputeNotification::class,
        ],
        PaymentCreate::class => [
            PaymentCreateNotification::class,
        ],
        PaymentCancel::class => [
            PaymentCancelNotification::class,
        ],
        ResourceCreate::class => [
            ResourceCreateNotification::class,
        ],
        ResourceUpdate::class => [
            ResourceUpdateNotification::class,
        ],
        ResourceDownload::class => [
            ResourceDownloadNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     *
     * @return bool
     */
    public function shouldDiscoverEvents()
    {
        return false;
    }
}
