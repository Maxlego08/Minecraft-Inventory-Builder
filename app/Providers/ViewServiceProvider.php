<?php

namespace App\Providers;

use App\Http\View\Composers\AlertComposer;
use App\Http\View\Composers\MessageComposer;
use App\Http\View\Composers\PendingReportComposer;
use App\Http\View\Composers\PendingResourceComposer;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('elements.alerts', AlertComposer::class);
        View::composer('elements.messages', MessageComposer::class);
        View::composer('admins.layouts.header', PendingResourceComposer::class);
        View::composer('admins.layouts.header', PendingReportComposer::class);
    }

}
