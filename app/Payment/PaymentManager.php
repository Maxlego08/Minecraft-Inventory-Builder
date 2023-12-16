<?php


namespace App\Payment;


use App\Models\Payment\Gift;
use App\Models\Payment\GiftHistory;
use App\Models\Payment\Payment;
use App\Models\Resource\Resource;
use App\Payment\Method\PaypalMethod;
use App\Payment\Method\StripeMethod;
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

        // Si le gift.js est valide, alors on va l'utiliser et modifier le prix
        if ($this->isValid($resource, $gift)) {
            $price = $resource->price - (($resource->price * $gift->reduction) / 100);
            $payment->update(['price' => $price]);
        }

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
     * Vérifier si un gift.js est bien valide
     *
     * @param Resource $resource
     * @param Gift|null $gift
     * @return bool
     */
    public function isValid(Resource $resource, Gift $gift = null): bool
    {
        // Si le gift.js est null, on ne fait rien
        if ($gift === null) return false;

        // Si le gift.js n'est pas actif, on ne fait rien
        if (!$gift->active) return false;

        // Si la resource n'est pas la bonne, on ne fait rien
        if ($gift->resource_id != $resource->id) return false;

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

}
