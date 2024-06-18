<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Newsletter;
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
        return redirect()->back()->with('status', 'Subscribed successfully!');
    }

    public function newsletterInactive()
    {
        user()->update(['newsletter_active' => false, 'newsletter_at' =>Carbon::now()]);
        return redirect()->back()->with('status', 'Unsubscribed successfully!');
    }
}
