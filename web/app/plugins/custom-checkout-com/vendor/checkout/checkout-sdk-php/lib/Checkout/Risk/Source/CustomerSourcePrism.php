<?php

namespace MyCheckout\Risk\Source;

use MyCheckout\Common\PaymentSourceType;

class CustomerSourcePrism extends RiskPaymentRequestSource
{
    /**
     * @var string
     */
    public $id;

    public function __construct()
    {
        parent::__construct(PaymentSourceType::$customer);
    }
}
