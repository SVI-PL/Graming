<?php

namespace MyCheckout\Payments\Request\Source\Apm;

use MyCheckout\Common\PaymentSourceType;
use MyCheckout\Payments\BillingPlan;
use MyCheckout\Payments\Request\Source\AbstractRequestSource;

class RequestPayPalSource extends AbstractRequestSource
{
    public function __construct()
    {
        parent::__construct(PaymentSourceType::$paypal);
    }

    /**
     * @var BillingPlan
     */
    public $plan;
}
