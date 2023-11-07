<?php

namespace MyCheckout\Payments\Previous\Source\Apm;

use MyCheckout\Common\PaymentSourceType;
use MyCheckout\Payments\Previous\Source\AbstractRequestSource;

class RequestBenefitPaySource extends AbstractRequestSource
{
    public function __construct()
    {
        parent::__construct(PaymentSourceType::$benefitpay);
    }

    /**
     * @var string
     */
    public $integration_type;
}
