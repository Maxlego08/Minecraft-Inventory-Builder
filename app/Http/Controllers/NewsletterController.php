<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Newsletter;
use Illuminate\Support\Facades\Auth;

class NewsletterController extends Controller
{
    public function index()
    {
        $newsletter = Auth::user()->newsletter;
        return view('newsletter.index', compact('newsletter'));
    }

    public function newsletterActive()
    {
        $newsletter = Auth::user()->newsletter;
        if (!$newsletter) {
            $newsletter = new Newsletter();
            $newsletter->user_id = Auth::id();
        }
        $newsletter->newsletter_active = true;
        $newsletter->save();

        return redirect()->back()->with('status', 'Subscribed successfully!');
    }

    public function newsletterInactive()
    {
        $newsletter = Auth::user()->newsletter;
        if ($newsletter) {
            $newsletter->newsletter_active = false;
            $newsletter->save();
        }

        return redirect()->back()->with('status', 'Unsubscribed successfully!');
    }
}
