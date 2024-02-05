<?php

namespace App\Http\Controllers\Resource;

use App\Http\Controllers\Controller;
use App\Jobs\CheckDiscordWebhook;
use App\Models\Discord\DiscordEmbed;
use App\Models\Discord\DiscordNotification;
use App\Models\Payment\Payment;
use App\Models\Resource\Resource;
use App\Models\Resource\Version;
use App\Models\User;
use App\Models\UserLog;
use App\Utils\Discord\DiscordWebhook;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\ValidationException;

class DashboardDiscordController extends Controller
{
    const EVENTS = [
        'event.payment.completed',
        'event.payment.refunded',
        'event.payment.created',
        'event.payment.canceled',
        'event.payment.dispute.created',
        'event.resource.created',
        'event.resource.updated',
        // 'event.resource.download',
    ];

    const REPLACEMENT_VARIABLES = [
        'client_id',
        'client_name',
        # 'client_email',
        'payment_price',
        'payment_currency',
        'payment_id',
        'payment_content_name',
        'payment_content_id',
        'resource_name',
        'resource_tag',
        'resource_id',
        'resource_price',
        'resource_logo',
        'resource_download',
        'resource_link',
        'resource_currency',
        'author_name',
        'author_id',
        'resource_version',
        'resource_version_name',
        'resource_version_download',
        'color_random',
    ];

    public static function replaceContent(string $message, ?User $user, ?Payment $payment, ?Resource $resource, ?Version $version): array|string
    {

        if (isset($user)) {

            $message = str_replace('{client_id}', $user->id, $message);
            $message = str_replace('{client_name}', $user->name, $message);
            # $message = str_replace('{client_email}', $user->email, $message);

        }

        if (isset($payment)) {

            $message = str_replace('{payment_price}', $payment->price, $message);
            $message = str_replace('{payment_currency}', currency($payment->currency?->currency ?? 'eur'), $message);
            $message = str_replace('{payment_id}', $payment->external_id ?? '', $message);

            if ($payment->content_id == -1) {
                $message = str_replace('{payment_content_name}', 'Test content', $message);
                $message = str_replace('{payment_content_id}', '1', $message);
            } else {
                $message = str_replace('{payment_content_name}', $payment->getPaymentContentName(), $message);
                $message = str_replace('{payment_content_id}', $payment->content_id, $message);
            }

        }

        if (isset($resource)) {

            $message = str_replace('{resource_name}', $resource->name, $message);
            $message = str_replace('{resource_tag}', $resource->tag, $message);
            $message = str_replace('{resource_id}', $resource->id, $message);
            $message = str_replace('{resource_price}', $resource->price, $message);
            $message = str_replace('{resource_logo}', $resource->icon?->getPath() ?? 'https://img.groupez.dev/zmenu/logo.png', $message);
            $message = str_replace('{resource_download}', $resource->countDownload(), $message);
            $message = str_replace('{resource_link}', $resource->link('description'), $message);

            $author = $resource->user;
            if (isset($author)) {

                $message = str_replace('{resource_currency}', $author->paymentInfo?->currency->currency ?? 'eur', $message);
                $message = str_replace('{author_name}', $author->name, $message);
                $message = str_replace('{author_id}', $author->id, $message);

            }

        }

        if (isset($version)) {

            $message = str_replace('{resource_version}', $version->version, $message);
            $message = str_replace('{resource_version_name}', $version->title, $message);
            $message = str_replace('{resource_version_download}', $version->download, $message);

        }

        return str_replace('{color_random}', self::random_color(), $message);

    }

    static function random_color(): string
    {
        return self::random_color_part() . self::random_color_part() . self::random_color_part();
    }

    /**
     * @return string
     */
    static function random_color_part(): string
    {
        return str_pad(dechex(mt_rand(0, 255)), 2, '0', STR_PAD_LEFT);
    }

    /**
     * Afficher les discord webhooks de l'utilisateur
     *
     * @return \Illuminate\Contracts\Foundation\Application|Factory|View|Application
     */
    public function index(): Application|View|Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('resources.dashboard.discord.index', [
            'discords' => user()->webhooks,
            'variables' => self::REPLACEMENT_VARIABLES,
            'events' => self::EVENTS,
        ]);
    }

    /**
     * Créer un nouveau discord webhook
     *
     * @param Request $request
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $this->validate($request, [
            'url' => ['required', 'min:120'],
            'event' => 'required',
            'username' => ['max:36'],
            'avatar_url' => ['max:500'],
            'textarea' => ['max:2000'],

            'color.*' => ['required', 'max:14', 'min:7'],
            'title.*' => ['max:300'],
            'footer.*' => ['max:300'],
            'thumbnail.*' => ['max:500'],
            'url_embed.*' => ['max:500'],
            'description.*' => ['max:2000'],
        ]);

        $url = $request['url'];

        if (!$this->urlIsValid($url)) {
            return Redirect::back()->withErrors(['url' => __('resources.dashboard.discord.url_errors'),]);
        }

        $user = user();
        $counts = DiscordNotification::where('user_id', $user->id)->count();
        if ($counts >= $user->role->max_discord_webhook) {
            return Redirect::route('resources.dashboard.discord.index')->with('toast', createToast('error', __('resources.dashboard.discord.errors.limit.title'), __('resources.dashboard.discord.errors.limit.description')));
        }

        $discordWebhook = DiscordNotification::create(['user_id' => $user->id, 'url' => $url, 'content' => $request['textarea'], 'is_enable' => true, 'is_valid' => false, 'event' => $request['event'], 'username' => $request['username'], 'avatar_url' => $request['avatar_url'],]);

        $colors = $request['color'] ?? array();
        for ($i = 0; $i != count($colors); $i++) {
            DiscordEmbed::create([
                'discord_id' => $discordWebhook->id,
                'title' => $request['title'][$i],
                'url_embed' => $request['url_embed'][$i],
                'thumbnail' => $request['thumbnail'][$i],
                'footer' => $request['footer'][$i],
                'color' => $request['color'][$i],
                'description' => $request['description'][$i],
            ]);
        }

        userLog("Création du webhook discord $discordWebhook->id", UserLog::COLOR_SUCCESS, UserLog::ICON_DISCORD);

        $this->checkUrl($discordWebhook);

        return Redirect::route('resources.dashboard.discord.index')->with('toast', createToast('success', __('resources.dashboard.discord.success.title'), __('resources.dashboard.discord.success.description')));
    }

    /**
     * @param $url
     * @return bool
     */
    private function urlIsValid($url): bool
    {
        return (str_starts_with($url, 'https://discord.com/api/webhooks/')) || (str_starts_with($url, 'https://discordapp.com/api/webhooks/'));
    }

    /**
     * @param DiscordNotification $notification
     */
    private function checkUrl(DiscordNotification $notification)
    {
        $notification->update([
            'is_valid' => false,
        ]);

        rescue(function () use ($notification) {
            $user = new User();
            $user->id = 99999;
            $user->name = "AccountTest";
            $user->email = "test@zmenu.dev";

            $payment = new Payment();
            $payment->currency = 1;
            $payment->content_id = -1;
            $payment->gateway = 'stripe';
            $payment->price = 10;
            $payment->id = 88888;
            $payment->external_id = "pi_xxxxxxxxxxxxxxxx";

            $plugin = new Resource();
            $plugin->name = "zTest";
            $plugin->price = 10;
            $plugin->id = 77777;
            $plugin->user_id = 1;

            $version = new Version();
            $version->download = 99;
            $version->version = "1.0.1";
            $version->title = "Test version";

            $discord = DiscordWebhook::build($notification, $user, $payment, $plugin, $version);
            $url = $notification->url;
            CheckDiscordWebhook::dispatch($notification->id, $discord, $url);
        }, function () use ($notification) {
            $notification->update([
                'is_valid' => false,
            ]);
        });
    }

    /**
     * Créer un webhook discord
     *
     * @return \Illuminate\Contracts\Foundation\Application|Factory|View|Application|RedirectResponse
     */
    public function create(): Application|View|Factory|RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
        if (user()->role->isMember()) {
            return Redirect::route('resources.dashboard.discord.index')->with('toast', createToast('error', __('resources.dashboard.discord.error_permission.title'), __('resources.dashboard.discord.error_permission.description')));
        }
        return view('resources.dashboard.discord.create', ['events' => self::EVENTS,]);
    }

    /**
     * Éditer un webhook discord
     *
     * @param DiscordNotification $notification
     * @return View|Application|Factory|\Illuminate\Contracts\Foundation\Application
     */
    public function edit(DiscordNotification $notification): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('resources.dashboard.discord.edit', ['events' => self::EVENTS, 'discord' => $notification]);
    }

    /**
     * Supprimer un webhook discord
     *
     * @param DiscordNotification $notification
     * @return RedirectResponse
     */
    public function delete(DiscordNotification $notification): RedirectResponse
    {
        foreach ($notification->embeds as $embed) {
            $embed->delete();
        }
        $notification->delete();
        userLog("Suppression du webhook discord $notification->id", UserLog::COLOR_SUCCESS, UserLog::ICON_DISCORD);

        return Redirect::route('resources.dashboard.discord.index')->with('toast', createToast('success', __('resources.dashboard.discord.delete.title'), __('resources.dashboard.discord.delete.description')));
    }

    /**
     * Supprimer un webhook discord
     *
     * @param DiscordNotification $notification
     * @return RedirectResponse
     */
    public function test(DiscordNotification $notification): RedirectResponse
    {
        $this->checkUrl($notification);
        userLog("Envoie d'un test du webhook discord $notification->id", UserLog::COLOR_SUCCESS, UserLog::ICON_DISCORD);

        return Redirect::route('resources.dashboard.discord.index')->with('toast', createToast('success', __('resources.dashboard.discord.test.title'), __('resources.dashboard.discord.test.description')));
    }

    /**
     * Éditer un webhook discord
     *
     * @param Request $request
     * @param DiscordNotification $notification
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function update(Request $request, DiscordNotification $notification): RedirectResponse
    {
        $this->validate($request, [
            'url' => ['required', 'min:120'],
            'event' => 'required',
            'username' => ['max:36'],
            'avatar_url' => ['max:500'],
            'textarea' => ['max:2000'],

            'color.*' => ['required', 'max:7', 'min:7'],
            'title.*' => ['max:300'],
            'footer.*' => ['max:300'],
            'thumbnail.*' => ['max:500'],
            'url_embed.*' => ['max:500'],
            'description.*' => ['max:2000'],
        ]);

        $url = $request['url'];

        if (!$this->urlIsValid($url)) {
            return Redirect::back()->withErrors(['url' => __('resources.dashboard.discord.url_errors'),]);
        }

        $notification->update([
            'url' => $url,
            'content' => $request['textarea'],
            'event' => $request['event'],
            'username' => $request['username'],
            'avatar_url' => $request['avatar_url']
        ]);
        foreach ($notification->embeds as $embed) {
            $embed->delete();
        }

        $colors = $request['color'] ?? array();
        for ($i = 0; $i != count($colors); $i++) {
            DiscordEmbed::create([
                'discord_id' => $notification->id,
                'title' => $request['title'][$i],
                'url_embed' => $request['url_embed'][$i],
                'thumbnail' => $request['thumbnail'][$i],
                'footer' => $request['footer'][$i],
                'color' => $request['color'][$i],
                'description' => $request['description'][$i],
            ]);
        }

        userLog("Modification du webhook discord $notification->id", UserLog::COLOR_SUCCESS, UserLog::ICON_DISCORD);

        $this->checkUrl($notification);

        return Redirect::route('resources.dashboard.discord.index')->with('toast', createToast('success', __('resources.dashboard.discord.update.title'), __('resources.dashboard.discord.update.description')));
    }
}
