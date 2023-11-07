<?php

namespace MyCheckout\Tokens;

use MyCheckout\ApiClient;
use MyCheckout\AuthorizationType;
use MyCheckout\CheckoutApiException;
use MyCheckout\CheckoutConfiguration;
use MyCheckout\Client;

class TokensClient extends Client
{
    const TOKENS_PATH = "tokens";

    public function __construct(ApiClient $apiClient, CheckoutConfiguration $configuration)
    {
        parent::__construct($apiClient, $configuration, AuthorizationType::$publicKey);
    }

    /**
     * @param CardTokenRequest $cardTokenRequest
     * @return array
     * @throws CheckoutApiException
     */
    public function requestCardToken(CardTokenRequest $cardTokenRequest)
    {
        return $this->apiClient->post(self::TOKENS_PATH, $cardTokenRequest, $this->sdkAuthorization());
    }

    /**
     * @param WalletTokenRequest $walletTokenRequest
     * @return array
     * @throws CheckoutApiException
     */
    public function requestWalletToken(WalletTokenRequest $walletTokenRequest)
    {
        return $this->apiClient->post(self::TOKENS_PATH, $walletTokenRequest, $this->sdkAuthorization());
    }

}
