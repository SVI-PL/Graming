<?php

namespace MyCheckout\Payments\Request\Source\Apm;

use MyCheckout\Common\PaymentSourceType;
use MyCheckout\Payments\Request\Source\AbstractRequestSource;

class RequestMbwaySource extends AbstractRequestSource
{
    public function __construct()
    {
        parent::__construct(PaymentSourceType::$mbway);
    }
}
