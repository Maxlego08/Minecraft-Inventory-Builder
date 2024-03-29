<?php


namespace App\Payment;


use App\Jobs\DiscordWebhookNotification;
use App\Models\Discord\DiscordNotification;
use App\Models\Payment\Gift;
use App\Models\Payment\GiftHistory;
use App\Models\Payment\Payment;
use App\Models\Resource\Resource;
use App\Models\User\NameColor;
use App\Models\User\UserPaymentInfo;
use App\Payment\Events\PaymentCreate;
use App\Payment\Events\PaymentDispute;
use App\Payment\Method\PaypalMethod;
use App\Payment\Method\StripeMethod;
use App\Utils\Discord\DiscordWebhook;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class PaymentManager
{

    /**
     * @var Collection
     */
    protected Collection $paymentMethods;

    public function __construct()
    {
        $this->paymentMethods = collect([
            'stripe' => StripeMethod::class,
            'paypal' => PaypalMethod::class,
        ]);
    }

    /**
     * Process payment
     * @param Request $request
     * @param string $payment
     * @param string|null $paymentId
     * @return mixed
     */
    /*public function process(Request $request, string $payment, string $paymentId = null)
    {
        $method = $this->getMethodOrFail($payment);
        return $method->process($request, $paymentId);
    }*/

    /**
     * Permet de commencer un paiement
     *
     * @param Request $request
     * @param Resource $resource
     * @param string $paymentMethod
     * @param Payment $payment
     * @param Gift|null $gift
     * @return mixed
     */
    public function startPayment(Request $request, Resource $resource, string $paymentMethod, Payment $payment, Gift $gift = null): mixed
    {

        $method = $this->getMethodOrFail($paymentMethod);

        $paymentInfo = $resource->user->paymentInfo;
        $user = $request->user();
        $price = $resource->price;

        // Si le gift est valide, alors on va l'utiliser et modifier le prix
        if ($this->isValid(Resource::class, $resource->id, $gift)) {
            $price = $resource->price - (($resource->price * $gift->reduction) / 100);
            $payment->update(['price' => $price]);
        }

        event(new PaymentCreate($payment));

        return $method->startPayment($user, $paymentInfo, $payment, $price, $gift);
    }

    /**
     * Permet de commencer un paiement
     *
     * @param Request $request
     * @param float $price
     * @param Payment $payment
     * @param Gift|null $gift
     * @param string|null $contentType
     * @return mixed
     */
    public function startPaymentInterne(Request $request, float $price, Payment $payment, Gift $gift = null, string $contentType = null): mixed
    {

        $method = $this->getMethodOrFail('stripe');

        $paymentInfo = UserPaymentInfo::where('id', env('PAYMENT_INFO_ADMIN_ID'))->first();
        $user = $request->user();

        if (isset($gift) && isset($contentType) && $this->isValid($contentType, $payment->content_id, $gift)) {
            $price -= (($price * $gift->reduction) / 100);
            $payment->update(['price' => $price]);
        }

        event(new PaymentCreate($payment));

        return $method->startPayment($user, $paymentInfo, $payment, $price, $gift);
    }

    /**
     * @param string $payment
     * @return PaymentMethod
     */
    public function getMethodOrFail(string $payment): PaymentMethod
    {
        abort_if(!$this->paymentMethods->has($payment), 404, 'Payment method ' . $payment . ' was not found');
        return app($this->paymentMethods->get($payment));
    }

    /**
     * Vérifier si un gift est bien valide
     *
     * @param string $contentType
     * @param int $contentId
     * @param Gift|null $gift
     * @return bool
     */
    public function isValid(string $contentType, int $contentId, Gift $gift = null): bool
    {
        // Si le gift.js est null, on ne fait rien
        if ($gift === null) return false;

        // Si le gift.js n'est pas actif, on ne fait rien
        if (!$gift->active) return false;

        // Si la resource n'est pas la bonne, on ne fait rien
        if ($gift->giftable_id != $contentId) return false;

        // Si le type n'est pas le bon, alors on ne fait rien
        if ($gift->giftable_type != $contentType) return false;

        // Si le nombre d'utilisations a été atteint, on ne fait rien
        if ($gift->used >= $gift->max_use) return false;

        $user = user()->id;
        // Si l'utilisateur à déjà utilisé le gift.js, on ne fait rien
        if (!GiftHistory::canUse($gift, $user)) return false;

        // Sinon, le gift.js est valide
        return true;
    }

    public function process(Request $request, string $payment, ?string $paymentId)
    {
        $method = $this->getMethodOrFail($payment);
        return $method->process($request, $paymentId);
    }

    public function sendDiscordWebhook(Payment $payment, string $event): void
    {
        $user = $payment->user;
        $authorId = $payment->type == Payment::TYPE_RESOURCE ? $payment->resource->user_id : env('ADMIN_DISCORD_ID');

        $webhooks = DiscordNotification::where('event', $event)->where('user_id', $authorId)->where('is_valid', true)->get();
        foreach ($webhooks as $webhook) {
            DiscordWebhookNotification::dispatch(DiscordWebhook::build($webhook, $user, $payment), $webhook->url);
        }

    }

}
