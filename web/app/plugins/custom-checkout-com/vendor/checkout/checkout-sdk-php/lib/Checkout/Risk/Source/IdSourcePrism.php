<?php

namespace MyCheckout\Risk\Source;

use MyCheckout\Common\PaymentSourceType;

class IdSourcePrism extends RiskPaymentRequestSource
{
    /**
     * @var string
     */
    public $id;

    /**
     * @var string
     */
    public $cvv;

    public function __construct()
    {
        parent::__construct(PaymentSourceType::$id);
    }
}
