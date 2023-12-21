<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class TooltipController extends Controller
{
    public function tooltip(User $user): string
    {
        $userBannerStyle = '';
        $userProfilePhotoUrl = htmlspecialchars($user->getProfilePhotoLargeUrlAttribute());
        $userName = htmlspecialchars($user->name);
        $userDisplayNameAndLink = $user->displayNameAndLink(false); // Assurez-vous que cette méthode échappe à son contenu interne
        $userRoleIcon = $user->role->getRoleIcon(); // Assurez-vous que cette méthode échappe à son contenu interne
        $userJoinDate = htmlspecialchars(simple_date($user->created_at));
        $userResources = htmlspecialchars($user->getTooltipInformations()['resources'] ?? '');
        $userPayments = htmlspecialchars($user->getTooltipInformations()['payments'] ?? '');
        $userCreateConversationUrl = htmlspecialchars($user->createConversation());
        $tooltipJoinAt = htmlspecialchars(__('tooltip.join_at'));
        $tooltipConversation = htmlspecialchars(__('tooltip.conversation'));
        $tooltipResources = htmlspecialchars(__('tooltip.resources'));
        $tooltipPayments = htmlspecialchars(__('tooltip.payments'));
        $tooltipCss = $user->hasTooltipInformations() ? '' : ' pt-3';

        if (isset($user->banner_photo_path)) {
            $userBannerUrl = htmlspecialchars($user->getBannerUrlAttribute());
            $userBannerStyle = "style=\"background-image: url('$userBannerUrl'); background-repeat: no-repeat; background-size: cover; background-position: 0 0;\"";
        }

        $userEnableConversation = $user->enable_conversation;
        $conversationTooltip = __('tooltip.conversation');
        $createConversationUrl = $user->createConversation();

        if (!$userEnableConversation) {
            $htmlContentButton = <<<HTML
        <span class="conversation-button rounded-1 disabled cursor-disabled">{$conversationTooltip}</span>
    HTML;
        } else {
            $htmlContentButton = <<<HTML
        <a class="conversation-button rounded-1" href="{$createConversationUrl}">{$conversationTooltip}</a>
    HTML;
        }

        $tooltipInformations = '';
        if ($user->hasTooltipInformations()) {
            $tooltipInformations = <<<HTML
                    <div class="d-flex justify-content-evenly user-tooltip-content-informations">
                        <div class="d-flex flex-column">
                            <span>{$tooltipResources}</span>
                            <span class="text-center">{$userResources}</span>
                        </div>
                        <div class="d-flex flex-column">
                            <span>{$tooltipPayments}</span>
                            <span class="text-center">{$userPayments}</span>
                        </div>
                    </div>
                    <hr>
HTML;
        }

        return <<<HTML
        <div class='user-tooltip'>
            <div class="user-tooltip-header d-flex" {$userBannerStyle}>
                <div class="me-2">
                    <img src="{$userProfilePhotoUrl}" height="75" width="75" alt="{$userName}" class="rounded-2">
                </div>
                <div class="d-flex flex-column">
                    <span class="name h5 mb-0">{$userDisplayNameAndLink}</span>
                    <div class="pt-2 pb-2">
                    {$userRoleIcon}
                    </div>
                    <span class="join-info">{$tooltipJoinAt}{$userJoinDate}</span>
                </div>
            </div>
            <div class="user-tooltip-content">
                {$tooltipInformations}
                <div class="user-tooltip-content-buttons$tooltipCss">
                    {$htmlContentButton}
                </div>
            </div>
        </div>
HTML;
    }

    /**
     * Test du tooltip sur une page static
     *
     * @param User $user
     * @return View|\Illuminate\Foundation\Application|Factory|Application
     */
    public function test(User $user): View|\Illuminate\Foundation\Application|Factory|Application
    {
        return view('members.tooltip', ['user' => $user,]);
    }

}
