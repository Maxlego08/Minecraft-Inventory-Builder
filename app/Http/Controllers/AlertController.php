<?php

namespace App\Http\Controllers;

use App\Models\Alert\AlertUser;
use Carbon\Carbon;
use Illuminate\Http\Request;

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

    private function toHtml(AlertUser $alert): string
    {

        $divAlert = "<li class='list-group-item list-group-item-{$alert->level} fs-7 rounded-0 mt-1 p-1'>";

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
                $targetUrl = $target->name ?? '';
                $divAlert .= __($alert->translation_key, ['user' => "<a href='/profile/'{$targetUrl}>{$targetName}</a>", 'content' => "<a href='{$link}'>{$alert->content}</a>"]);
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
