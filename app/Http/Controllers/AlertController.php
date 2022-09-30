<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AlertController extends Controller
{
    public function latestAlerts()
    {

        $alerts = user()->alerts()->whereNull('opened_at')->get();

        $content = '';

        foreach ($alerts as $alert) {

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
                if ($alert->translation_key) {
                    $divAlert .= __('alerts.alerts.resources.update', ['user' => '<a href="#">Maxlego08</a>', 'content' => "<a href='#'>{$alert->content}</a>"]);
                } else {
                    $divAlert .= $alert->content;
                }
                $divAlert .= "</div>";
                $divAlert .= "</div>";

            } else {
                $divAlert .= $alert->content;
            }

            $divAlert .= "</li>";
            $content .= $divAlert;
        }

        return $content;
    }
}
