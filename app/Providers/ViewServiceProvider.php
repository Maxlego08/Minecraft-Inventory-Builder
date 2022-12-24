<?php

namespace App\Providers;

use App\Http\View\Composers\AlertComposer;
use App\Http\View\Composers\MessageComposer;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

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
    }

}
