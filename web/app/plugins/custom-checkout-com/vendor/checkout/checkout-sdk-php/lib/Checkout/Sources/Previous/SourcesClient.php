<?php

namespace MyCheckout\Sources\Previous;

use MyCheckout\ApiClient;
use MyCheckout\AuthorizationType;
use MyCheckout\CheckoutApiException;
use MyCheckout\CheckoutConfiguration;
use MyCheckout\Client;

class SourcesClient extends Client
{

    public function __construct(ApiClient $apiClient, CheckoutConfiguration $configuration)
    {
        parent::__construct($apiClient, $configuration, AuthorizationType::$secretKey);
    }

    /**
     * @param SepaSourceRequest $sepaSourceRequest
     * @return array
     * @throws CheckoutApiException
     */
    public function createSepaSource(SepaSourceRequest $sepaSourceRequest)
    {
        return $this->apiClient->post("sources", $sepaSourceRequest, $this->sdkAuthorization());
    }

}
