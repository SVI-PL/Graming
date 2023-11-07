<?php

namespace MyCheckout\Payments\Request\Source;

use MyCheckout\Common\PaymentSourceType;

class RequestIdSource extends AbstractRequestSource
{

    public function __construct()
    {
        parent::__construct(PaymentSourceType::$id);
    }

    /**
     * @var string
     */
    public $id;

    /**
     * @var string
     */
    public $cvv;

    /**
     * @var string
     */
    public $payment_method;

    /**
     * @var bool
     */
    public $stored;

    /**
     * @var bool
     */
    public $store_for_future_use;
}
