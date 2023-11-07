<?php

namespace MyCheckout\Payments\Request\Source;

use MyCheckout\Common\Address;
use MyCheckout\Common\PaymentSourceType;
use MyCheckout\Common\Phone;

class RequestTokenSource extends AbstractRequestSource
{

    public function __construct()
    {
        parent::__construct(PaymentSourceType::$token);
    }

    /**
     * @var string
     */
    public $token;

    /**
     * @var Address
     */
    public $billing_address;

    /**
     * @var Phone
     */
    public $phone;

    /**
     * @var bool
     */
    public $stored;

    /**
     * @var bool
     */
    public $store_for_future_use;
}
