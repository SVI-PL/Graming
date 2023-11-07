<?php

namespace MyCheckout\Payments\Hosted;

use MyCheckout\ApiClient;
use MyCheckout\AuthorizationType;
use MyCheckout\CheckoutApiException;
use MyCheckout\CheckoutConfiguration;
use MyCheckout\Client;

class HostedPaymentsClient extends Client
{

    const HOSTED_PAYMENTS = "hosted-payments";

    public function __construct(ApiClient $apiClient, CheckoutConfiguration $configuration)
    {
        parent::__construct($apiClient, $configuration, AuthorizationType::$secretKey);
    }

    /**
     * @param $id
     * @return array
     * @throws CheckoutApiException
     */
    public function getHostedPaymentsPageDetails($id)
    {
        return $this->apiClient->get($this->buildPath(self::HOSTED_PAYMENTS, $id), $this->sdkAuthorization());
    }

    /**
     * @param HostedPaymentsSessionRequest $hostedPaymentRequest
     * @return array
     * @throws CheckoutApiException
     */
    public function createHostedPaymentsPageSession(HostedPaymentsSessionRequest $hostedPaymentRequest)
    {
        return $this->apiClient->post(self::HOSTED_PAYMENTS, $hostedPaymentRequest, $this->sdkAuthorization());
    }

}
