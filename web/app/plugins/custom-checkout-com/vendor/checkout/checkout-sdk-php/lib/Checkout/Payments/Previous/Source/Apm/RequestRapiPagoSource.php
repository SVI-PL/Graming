<?php

namespace MyCheckout\Payments\Previous\Source\Apm;

use MyCheckout\Common\PaymentSourceType;
use MyCheckout\Payments\Payer;
use MyCheckout\Payments\Previous\Source\AbstractRequestSource;

class RequestRapiPagoSource extends AbstractRequestSource
{
    public function __construct()
    {
        parent::__construct(PaymentSourceType::$rapipago);
        $this->integration_type = IntegrationType::$redirect;
    }

    /**
     * @var string value of IntegrationType
     */
    public $integration_type;

    /**
     * @var string values of Country
     */
    public $country;

    /**
     * @var Payer
     */
    public $payer;

    /**
     * @var string
     */
    public $description;
}
