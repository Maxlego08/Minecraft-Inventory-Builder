<?php

namespace App\Utils\Discord;

use App\Http\Controllers\Resource\DashboardDiscordController;
use App\Models\Discord\DiscordNotification;
use App\Models\Payment\Payment;
use App\Models\Resource\Resource;
use App\Models\Resource\Version;
use App\Models\User;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use InvalidArgumentException;

class DiscordWebhook implements Arrayable
{

    /**
     * The message contents (up to 2000 characters).
     *
     * @var string|null
     */
    protected $content;

    /**
     * Override the default username of the webhook.
     *
     * @var string|null
     */
    protected $username;

    /**
     * Override the default avatar of the webhook.
     *
     * @var string|null
     */
    protected $avatarUrl;

    /**
     * Whether or not this is a TTS message.
     *
     * @var bool|null
     */
    protected $tts;

    /**
     * Embedded rich content.
     *
     * @var array|null
     */
    protected $embeds = [];

    private function __construct(string $content = null)
    {
        $this->content = $content;
    }

    /**
     * @param DiscordNotification $notification
     * @param User|null $user
     * @param Payment|null $payment
     * @param Resource|null $resource
     * @param Version|null $version
     * @return DiscordWebhook
     */
    public static function build(DiscordNotification $notification, User $user = null, Payment $payment = null, Resource $resource = null, Version $version = null): DiscordWebhook
    {

        $message = $notification->content;
        if ($message != null)
            $message = DashboardDiscordController::replaceContent($message, $user, $payment, $resource, $version);

        $webhook = self::create($message);

        if ($notification->username != null)
            $webhook->username(DashboardDiscordController::replaceContent($notification->username, $user, $payment, $resource, $version));

        if ($notification->avatar_url != null)
            $webhook->avatarUrl(DashboardDiscordController::replaceContent($notification->avatar_url, $user, $payment, $resource, $version));

        /*if ($notification->enable_embed) {

            $embed = new Embed();

            if ($notification->title != null)
                $embed->title(DashboardDiscordController::replaceContent($notification->title, $user, $payment, $resource, $version));

            if ($notification->footer != null)
                $embed->footer(DashboardDiscordController::replaceContent($notification->footer, $user, $payment, $resource, $version));

            if ($notification->description != null)
                $embed->description(DashboardDiscordController::replaceContent($notification->description, $user, $payment, $resource, $version));

            if ($notification->thumbnail != null)
                $embed->thumbnail(DashboardDiscordController::replaceContent($notification->thumbnail, $user, $payment, $resource, $version));

            if ($notification->url_embed != null)
                $embed->url(DashboardDiscordController::replaceContent($notification->url_embed, $user, $payment, $resource, $version));

            if ($notification->color != null)
                $embed->color($notification->color);

            if ($embed->isValid()) {
                $webhook->addEmbed($embed);
            }
        }*/

        return $webhook;
    }

    /**
     * Create a new webhook instance.
     *
     * @param string|null $content
     * @return self
     */
    public static function create(string $content = null)
    {
        return new self($content);
    }

    /**
     * Set the message contents (up to 2000 characters).
     *
     * @param string|null $content
     * @return $this
     */
    public function content(?string $content)
    {
        if (Str::length($content) > 2000) {
            throw new InvalidArgumentException('Embed content is limited to 2000 characters');
        }

        $this->content = $content;

        return $this;
    }

    /**
     * Override the default username of the webhook.
     *
     * @param string|null $username
     * @return $this
     */
    public function username(?string $username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Override the default avatar of the webhook.
     *
     * @param string|null $avatarUrl
     * @return $this
     */
    public function avatarUrl(string $avatarUrl = null)
    {
        if (filter_var($avatarUrl, FILTER_VALIDATE_URL) === false) {
            throw new InvalidArgumentException('The avatar url must be a valid URL');
        }

        $this->avatarUrl = $avatarUrl;

        return $this;
    }

    /**
     * Set whether or not this is a TTS message.
     *
     * @param bool $tts
     * @return $this
     */
    public function tts(bool $tts = true)
    {
        $this->tts = $tts;

        return $this;
    }

    /**
     * Add an embed rich content.
     *
     * @param \App\Utils\Discord\Embed $embed
     * @return $this
     */
    public function addEmbed(Embed $embed)
    {
        $this->embeds[] = $embed;

        return $this;
    }

    /**
     * Send the webhook to Discord.
     *
     * @param string $url
     * @param bool $throw
     * @return \Illuminate\Http\Client\Response
     *
     * @throws \Illuminate\Http\Client\HttpClientException
     */
    public function send(string $url, bool $throw = true)
    {
        $response = Http::post($url, $this->toArray());

        return $throw ? $response->throw() : $response;
    }

    /**
     * {@inheritdoc}
     */
    public function toArray()
    {
        return [
            'content' => $this->content,
            'username' => $this->username,
            'avatar_url' => $this->avatarUrl,
            'tts' => $this->tts,
            'embeds' => array_map(function (Embed $embed) {
                return $embed->toArray();
            }, $this->embeds),
        ];
    }
}
