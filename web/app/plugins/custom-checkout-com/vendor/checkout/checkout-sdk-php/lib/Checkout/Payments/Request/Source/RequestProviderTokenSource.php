<?php

namespace MyCheckout\Payments\Request\Source;

use MyCheckout\Common\AccountHolder;
use MyCheckout\Common\PaymentSourceType;

class RequestProviderTokenSource extends AbstractRequestSource
{

    public function __construct()
    {
        parent::__construct(PaymentSourceType::$provider_token);
    }

    /**
     * @var string
     */
    public $payment_method;

    /**
     * @var string
     */
    public $token;

    /**
     * @var AccountHolder
     */
    public $account_holder;
}
