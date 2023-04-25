<?php

namespace App\Http\Controllers;

use App\Models\Alert\AlertUser;
use App\Models\Conversation\Conversation;
use Carbon\Carbon;

class AlertController extends Controller
{

    public function show()
    {

        $data = Carbon::now()->subDays(1);
        $alerts = user()->alerts()->whereNull('opened_at')->orWhere('opened_at', '>=', $data)->orderBy('created_at', 'desc')->get();

        foreach ($alerts as $alert) {
            if ($alert->opened_at === null) {
                $alert->update(['opened_at' => now()]);
            }
        }

        return view('members.alerts', [
            'alerts' => $alerts,
        ]);

    }

    public function latestAlerts(): string
    {

        $alerts = user()->alerts()->whereNull('opened_at')->orderBy('created_at', 'desc')->limit(20)->get();

        $content = '';

        foreach ($alerts as $alert) {

            $divAlert = $this->toHtml($alert);
            $content .= $divAlert;

            $alert->update(['opened_at' => now()]);
        }

        if (strlen($content) == 0) {
            $content = '<li class="list-group-item list-group-item-success fs-7" id="alert-empty"><i class="bi bi-check2-circle"></i> ' . __('alerts.none') . '</li>';
        }

        return $content;
    }

    public function latestMessages(): string
    {
        $user = user();
        $messages = $user->conversationNotifications;
        $content = '';

        foreach ($messages as $message) {
            $conversation = $message->conversation;
            $div = $this->toHtmlConversation($conversation);
            $content .= $div;
            $conversation->deleteNotification($user);
        }

        if (strlen($content) == 0) {
            $content = '<li class="list-group-item list-group-item-success fs-7" id="alert-empty"><i class="bi bi-check2-circle"></i> ' . __('alerts.none') . '</li>';
        }

        return $content;
    }

    private function toHtmlConversation(Conversation $conversation): string
    {

        $lastMessage = $conversation->getLastMessage();
        $user = $lastMessage->user;
        $lastMessageURL = $conversation->getLastMessageURL();
        $url = $user->getProfileUrl();
        $userName = $user->name;

        $div = '<li class="list-group-item list-group-item-info fs-7 rounded-1 mt-1 p-1">';

        $div .= "<div class='d-flex'>";

        $div .= "<img src='{$user->getProfilePhotoUrlAttribute()}'
                             height='50' width='50' alt='{$user->name} avatar' class='rounded-2'>";

        $div .= "<div class='ms-1'>";
        $div .= __('alerts.alerts.messages', ['user' => "<a href='$url'>$userName</a>", 'conversation' => "<a href='$lastMessageURL'>$conversation->subject</a>"]);
        $div .= "</div>";

        $div .= "</div>";
        $div .= '</li>';

        return $div;
    }

    private function toHtml(AlertUser $alert): string
    {

        $divAlert = "<li class='list-group-item list-group-item-{$alert->level} fs-7 rounded-1 mt-1 p-1'>";

        if ($alert->target_id || $alert->translation_key || $alert->icon) {

            $divAlert .= "<div class='d-flex'>";
            if ($alert->target_id) {
                $target = $alert->target;
                $divAlert .= "<img src='{$target->getProfilePhotoUrlAttribute()}'
                             height='50' width='50' alt='{$target->name} avatar' class='rounded-2'>";
            } else {
                $divAlert .= $alert->icon;
            }
            $divAlert .= "<div class='ms-1'>";
            $divAlert .= "<div>";
            if ($alert->translation_key) {
                $link = $alert->link ?? "#";
                $targetName = $target->name ?? '';
                $targetUrl = $target->getProfileUrl() ?? '';
                $divAlert .= __($alert->translation_key, ['user' => "<a href='$targetUrl'>{$targetName}</a>", 'content' => "<a href='{$link}'>{$alert->content}</a>"]);
            } else {
                $divAlert .= $alert->content;
            }
            $divAlert .= "</div>";
            $date = format($alert->created_at);
            $divAlert .= "<small>{$date}</small>";
            $divAlert .= "</div>";
            $divAlert .= "</div>";

        } else {
            $divAlert .= $alert->content;
        }

        $divAlert .= "</li>";
        return $divAlert;

    }

}
