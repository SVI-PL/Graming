<?php

namespace MyCheckout\Metadata;

use MyCheckout\ApiClient;
use MyCheckout\AuthorizationType;
use MyCheckout\CheckoutApiException;
use MyCheckout\CheckoutConfiguration;
use MyCheckout\Client;
use MyCheckout\Metadata\Card\CardMetadataRequest;

class MetadataClient extends Client
{
    public function __construct(ApiClient $apiClient, CheckoutConfiguration $configuration)
    {
        parent::__construct($apiClient, $configuration, AuthorizationType::$secretKeyOrOAuth);
    }

    /**
     * @param CardMetadataRequest $cardMetadataRequest
     * @return array
     * @throws CheckoutApiException
     */
    public function requestCardMetadata(CardMetadataRequest $cardMetadataRequest)
    {
        return $this->apiClient->post(
            "metadata/card",
            $cardMetadataRequest,
            $this->sdkAuthorization()
        );
    }

}
