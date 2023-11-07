<?php

namespace MyCheckout;

use MyCheckout\Apm\Ideal\IdealClient;

class CheckoutApmApi
{
    private $idealClient;

    public function __construct(ApiClient $apiClient, CheckoutConfiguration $configuration)
    {
        $this->idealClient = new IdealClient($apiClient, $configuration);
    }

    /**
     * @return IdealClient
     */
    public function getIdealClient()
    {
        return $this->idealClient;
    }
}
