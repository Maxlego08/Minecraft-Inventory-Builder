<?php

namespace App\Providers;

use App\View\Composers\AlertComposer;
use App\View\Composers\MessageComposer;
use App\View\Composers\PendingReportComposer;
use App\View\Composers\PendingResourceComposer;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Facades\View::composer('elements.alerts', AlertComposer::class);
        Facades\View::composer('elements.messages', MessageComposer::class);
        Facades\View::composer('admins.layouts.header', PendingResourceComposer::class);
        Facades\View::composer('admins.layouts.header', PendingReportComposer::class);
    }
}
