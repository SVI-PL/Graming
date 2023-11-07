<?php

namespace MyCheckout\Apm;

use MyCheckout\ApiClient;
use MyCheckout\Apm\Ideal\IdealClient;
use MyCheckout\Apm\Previous\Klarna\KlarnaClient;
use MyCheckout\Apm\Previous\Sepa\SepaClient;
use MyCheckout\CheckoutConfiguration;

class CheckoutApmApi
{

    private $idealClient;
    private $klarnaClient;
    private $sepaClient;

    /**
     * @param ApiClient $apiClient
     * @param CheckoutConfiguration $configuration
     */
    public function __construct(ApiClient $apiClient, CheckoutConfiguration $configuration)
    {
        $this->idealClient = new IdealClient($apiClient, $configuration);
        $this->klarnaClient = new KlarnaClient($apiClient, $configuration);
        $this->sepaClient = new SepaClient($apiClient, $configuration);
    }

    /**
     * @return IdealClient
     */
    public function getIdealClient()
    {
        return $this->idealClient;
    }

    /**
     * @return KlarnaClient
     */
    public function getKlarnaClient()
    {
        return $this->klarnaClient;
    }

    /**
     * @return SepaClient
     */
    public function getSepaClient()
    {
        return $this->sepaClient;
    }
}
