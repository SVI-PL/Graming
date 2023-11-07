<?php

namespace MyCheckout\Payments\Request\Source\Apm;

use MyCheckout\Common\Address;
use MyCheckout\Common\PaymentSourceType;
use MyCheckout\Payments\Request\Source\AbstractRequestSource;

class RequestTrustlySource extends AbstractRequestSource
{
    public function __construct()
    {
        parent::__construct(PaymentSourceType::$trustly);
    }

    /**
     * @var Address
     */
    public $billing_address;
}
