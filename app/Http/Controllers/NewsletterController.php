<?php


namespace App\Http\Controllers;

use App\Models\UserLog;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class NewsletterController extends Controller
{
    public function index()
    {
        return view('newsletter.index');
    }

    public function newsletterActive()
    {
        user()->update(['newsletter_active' => true, 'newsletter_at' =>Carbon::now()]);

        //Enregistrer l'action d'abonnement
        userLog("l'utilisateur s'est abonné à la newsletter", UserLog::COLOR_SUCCESS, UserLog::ICON_ADD);

        return redirect()->back()->with('status', 'Subscribed successfully!');
    }

    public function newsletterInactive()
    {
        user()->update(['newsletter_active' => false, 'newsletter_at' =>Carbon::now()]);
        userLog("l'utilisateur s'est désabonné à la newsletter", UserLog::COLOR_WARNING, UserLog::ICON_TRASH);
        return redirect()->back()->with('status', 'Unsubscribed successfully!');
    }

    public function logAction(string $action, string $color, string $icon)
    {
        // Focntion pour enregistrer l'action dans le journal
        userLog($action, $color, $icon);
    }

}
