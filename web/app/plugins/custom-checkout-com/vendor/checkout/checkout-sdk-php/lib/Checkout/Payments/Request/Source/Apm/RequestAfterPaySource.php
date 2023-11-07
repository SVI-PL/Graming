<?php

namespace MyCheckout\Payments\Request\Source\Apm;

use MyCheckout\Common\AccountHolder;
use MyCheckout\Common\PaymentSourceType;
use MyCheckout\Payments\Request\Source\AbstractRequestSource;

class RequestAfterPaySource extends AbstractRequestSource
{
    public function __construct()
    {
        parent::__construct(PaymentSourceType::$afterpay);
    }

    /**
     * @var AccountHolder
     */
    public $account_holder;
}
