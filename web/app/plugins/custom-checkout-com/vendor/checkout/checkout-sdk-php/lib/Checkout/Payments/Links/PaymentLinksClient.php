<?php

namespace MyCheckout\Payments\Links;

use MyCheckout\ApiClient;
use MyCheckout\AuthorizationType;
use MyCheckout\CheckoutApiException;
use MyCheckout\CheckoutConfiguration;
use MyCheckout\Client;

class PaymentLinksClient extends Client
{

    const PAYMENT_LINKS = "payment-links";

    public function __construct(ApiClient $apiClient, CheckoutConfiguration $configuration)
    {
        parent::__construct($apiClient, $configuration, AuthorizationType::$secretKey);
    }

    /**
     * @param $id
     * @return array
     * @throws CheckoutApiException
     */
    public function getPaymentLink($id)
    {
        return $this->apiClient->get($this->buildPath(self::PAYMENT_LINKS, $id), $this->sdkAuthorization());
    }

    /**
     * @param PaymentLinkRequest $paymentLinkRequest
     * @return array
     * @throws CheckoutApiException
     */
    public function createPaymentLink(PaymentLinkRequest $paymentLinkRequest)
    {
        return $this->apiClient->post(self::PAYMENT_LINKS, $paymentLinkRequest, $this->sdkAuthorization());
    }

}
