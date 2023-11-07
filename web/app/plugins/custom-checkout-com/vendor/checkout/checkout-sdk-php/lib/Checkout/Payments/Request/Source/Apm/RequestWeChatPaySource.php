<?php

namespace MyCheckout\Payments\Request\Source\Apm;

use MyCheckout\Common\Address;
use MyCheckout\Common\PaymentSourceType;
use MyCheckout\Payments\Request\Source\AbstractRequestSource;

class RequestWeChatPaySource extends AbstractRequestSource
{
    /**
     * @var Address
     */
    public $billing_address;

    public function __construct()
    {
        parent::__construct(PaymentSourceType::$wechatpay);
    }
}
