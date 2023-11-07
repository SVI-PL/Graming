<?php

namespace MyCheckout\Payments\Request\Source\Apm;

use MyCheckout\Common\AccountHolder;
use MyCheckout\Common\PaymentSourceType;
use MyCheckout\Payments\Request\Source\AbstractRequestSource;

class RequestKlarnaSource extends AbstractRequestSource
{
    public function __construct()
    {
        parent::__construct(PaymentSourceType::$klarna);
    }

    /**
     * @var AccountHolder
     */
    public $account_holder;
}
