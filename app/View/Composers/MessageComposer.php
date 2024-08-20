<?php

namespace App\View\Composers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class MessageComposer
{

    /**
     * Bind data to the view.
     *
     * @param View $view
     * @return void
     */
    public function compose(View $view): void
    {
        if (!Auth::guest() && !$view->offsetExists('messageCount')) {
            $user = user();
            $messages = Cache::remember("conversations::{$user->id}", 86400, function () {
                return user()->conversationNotifications()->count();
            });
            $view->with('messageCount', $messages);
        }
    }

}
