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
        // Préparation des variables PHP
        $profilePhotoUrl = $user->getProfilePhotoUrlAttribute();
        $userName = $user->name;
        $displayNameAndLink = $user->displayNameAndLink(false);
        $joinInfo = __('tooltip.join_at') . simple_date($user->created_at);
        $conversationLink = $user->createConversation();
        $conversationText = __('tooltip.conversation');


        $hasTooltipInformations = $user->hasTooltipInformations();
        $resources = $hasTooltipInformations ? $user->getTooltipInformations()['resources'] : '';
        $payments = $hasTooltipInformations ? $user->getTooltipInformations()['payments'] : '';
        $resourcesLabel = __('tooltip.resources');
        $paymentsLabel = __('tooltip.payments');

        $htmlContent = <<<HTML
<div class='user-tooltip'>
    <div class="user-tooltip-header d-flex">
        <div class="me-2">
            <img src="{$profilePhotoUrl}" height="50" width="50" alt="{$userName}" class="rounded-2">
        </div>
        <div class="d-flex flex-column">
            <span class="name">{$displayNameAndLink}</span>
            <span class="join-info">{$joinInfo}</span>
        </div>
    </div>
    <div class="user-tooltip-content">
HTML;

        if ($hasTooltipInformations) {
            $htmlContent .= <<<HTML
        <div class="d-flex justify-content-evenly user-tooltip-content-informations">
            <div class="d-flex flex-column">
                <span>{$resourcesLabel}</span>
                <span class="text-center">{$resources}</span>
            </div>
            <div class="d-flex flex-column">
                <span>{$paymentsLabel}</span>
                <span class="text-center">{$payments}</span>
            </div>
        </div>
        <hr>
HTML;
        }

        $htmlContent .= <<<HTML
        <div class="user-tooltip-content-buttons">
            <a class="conversation-button rounded-1" href="{$conversationLink}">{$conversationText}</a>
        </div>
    </div>
</div>
HTML;

        return $htmlContent;
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
