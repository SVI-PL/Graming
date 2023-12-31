<?php

namespace MyCheckout\Payments\Request\Source\Apm;

use MyCheckout\Common\PaymentSourceType;
use MyCheckout\Payments\Previous\Source\AbstractRequestSource;

class RequestP24Source extends AbstractRequestSource
{
    public function __construct()
    {
        parent::__construct(PaymentSourceType::$przelewy24);
    }

    /**
     * @var string values of Country
     */
    public $payment_country;

    /**
     * @var string
     */
    public $account_holder_name;

    /**
     * @var string
     */
    public $account_holder_email;

    /**
     * @var string
     */
    public $billing_descriptor;
}
