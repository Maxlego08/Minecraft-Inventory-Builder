<?php

namespace App\Listeners;

use App\Models\User;
use App\Models\UserLog;
use Illuminate\Auth\Events\Login;

class LoginListener
{

    /**
     * Quand un joueur va se connecter
     *
     * @param Login $event
     * @return void
     */
    public function handle(Login $event): void
    {
        if ($event->user instanceof User) {
            userLog("Vient de se connecter", UserLog::COLOR_CONNEXION, UserLog::ICON_USER_LOGIN);
        }
    }
}
