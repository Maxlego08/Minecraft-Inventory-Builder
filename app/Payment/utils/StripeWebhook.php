<?php

namespace App\Payment\utils;

use App\Models\User\UserPaymentInfo;
use Stripe\Exception\ApiErrorException;
use Stripe\StripeClient;

class StripeWebhook
{

    /**
     * @var StripeClient
     */
    private StripeClient $stripe;

    /**
     * @var string
     */
    private string $gatewayName = "stripe";

    private UserPaymentInfo $usePaymentInfo;

    /**
     *
     */
    public function __construct(UserPaymentInfo $paymentInfo)
    {
        $this->stripe = new StripeClient($paymentInfo->sk_live);
        $this->usePaymentInfo = $paymentInfo;
    }

    /**
     * Permet de créer le webhook de stripe
     *
     * @throws ApiErrorException
     */
    public function make(): void
    {
        if ($this->endpointIsAlreadyCreate())
            return;

        $this->deleteEndPointIfAlreadyExist();

        $response = $this->stripe->webhookEndpoints->create([
            // 'url' => $this->getRouteEndPoint(),
            'url' => 'https://mib.test/api/v1/stripe/notification',
            'enabled_events' => [
                'checkout.session.completed',
                'checkout.session.async_payment_succeeded',
                'checkout.session.async_payment_failed',
                'charge.dispute.created',
                'charge.refunded',
            ],
            'description' => 'Webhook for minecraft-inventory-builder.com'
        ]);

        $this->usePaymentInfo->update(['endpoint_secret' => $response->secret]);
    }

    /**
     * Permet de vérifier si le endpoint existe ou pas
     *
     * @return bool
     * @throws ApiErrorException
     */
    private function endpointIsAlreadyCreate(): bool
    {
        foreach ($this->stripe->webhookEndpoints->all() as $endpoint) {
            if ($endpoint->url === $this->getRouteEndPoint())
                return true;
        }
        return false;
    }

    /**
     * Permet de retourner la route
     * @return string
     */
    private function getRouteEndPoint(): string
    {
        return route('api.v1.notification', ['payment' => $this->gatewayName]);
    }

    /**
     * Permet de supprimer les routes en trop
     */
    private function deleteEndPointIfAlreadyExist(): void
    {
        try {
            foreach ($this->stripe->webhookEndpoints->all() as $endpoint) {
                if ($endpoint->url === $this->getRouteEndPoint())
                    $this->stripe->webhookEndpoints->delete($endpoint->id);
            }
        } catch (ApiErrorException $e) {
        }
    }

}
