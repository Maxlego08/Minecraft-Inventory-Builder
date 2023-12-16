<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;

class TooltipController extends Controller
{
    public function tooltip(User $user): string
    {
        $userProfilePhotoUrl = $user->getProfilePhotoUrlAttribute(); // Récupérer l'URL de la photo de profil
        $userDisplayName = $user->displayNameAndLink(false); // Récupérer le nom d'affichage
        $userCreatedAt = simple_date($user->created_at); // Récupérer la date de création et la formater
        $conversationLink = $user->createConversation(); // Récupérer le lien pour créer une conversation
        $tooltipJoinAt = __('tooltip.join_at'); // Localiser le texte
        $tooltipConversation = __('tooltip.conversation'); // Localiser le texte

        $htmlContent = <<<HTML
    <div class='user-tooltip'>

        <div class="user-tooltip-header d-flex">
            <div class="me-2">
                <img src="{$userProfilePhotoUrl}" height="50" width="50"
                     alt="{$user->name}" class="rounded-2">
            </div>
            <div class="d-flex flex-column">
                <span class="name">{$userDisplayName}</span>
                <span class="join-info">{$tooltipJoinAt}{$userCreatedAt}</span>
            </div>
        </div>
        <div class="user-tooltip-content">
            <a class="conversation-button rounded-1" href="{$conversationLink}">{$tooltipConversation}</a>
        </div>

    </div>
HTML;
        return $htmlContent;
    }

    public function test(User $user)
    {
        return view('members.tooltip', [
            'user' => $user,
        ]);
    }

}
