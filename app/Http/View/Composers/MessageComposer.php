<?php

namespace App\Http\View\Composers;

use App\Models\Alert\AlertUser;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class MessageComposer
{

    /**
     * Bind data to the view.
     *
     * @param View $view
     * @return void
     */
    public function compose(View $view)
    {
        if (!Auth::guest() && !$view->offsetExists('messageCount')) {
            $messages = user()->conversationNotifications()->count();
            $view->with('messageCount', $messages);
        }
    }

}