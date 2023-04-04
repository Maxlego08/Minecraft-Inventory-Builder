<?php

namespace App\Http\View\Composers;

use App\Models\Alert\AlertUser;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AlertComposer
{

    /**
     * Bind data to the view.
     *
     * @param View $view
     * @return void
     */
    public function compose(View $view)
    {
        if (!Auth::guest() && !$view->offsetExists('alertCount')) {
            $alerts = AlertUser::where('user_id', user()->id)->whereNull('opened_at')->count();
            $view->with('alertCount', $alerts);
        }
    }

}
