<?php

namespace MyCheckout\Transfers;

use MyCheckout\ApiClient;
use MyCheckout\AuthorizationType;
use MyCheckout\CheckoutApiException;
use MyCheckout\CheckoutConfiguration;
use MyCheckout\Client;

class TransfersClient extends Client
{
    const TRANSFERS_PATH = "transfers";

    public function __construct(ApiClient $apiClient, CheckoutConfiguration $configuration)
    {
        parent::__construct($apiClient, $configuration, AuthorizationType::$secretKeyOrOAuth);
    }

    /**
     * @param CreateTransferRequest $transferRequest
     * @param string|null $idempotencyKey
     * @return array
     * @throws CheckoutApiException
     */
    public function initiateTransferOfFunds(CreateTransferRequest $transferRequest, $idempotencyKey = null)
    {
        return $this->apiClient->post(
            self::TRANSFERS_PATH,
            $transferRequest,
            $this->sdkAuthorization(),
            $idempotencyKey
        );
    }

    /**
     * @param $transferId string
     * @return array
     * @throws CheckoutApiException
     */
    public function retrieveATransfer($transferId)
    {
        return $this->apiClient->get(
            $this->buildPath(self::TRANSFERS_PATH, $transferId),
            $this->sdkAuthorization()
        );
    }
}
