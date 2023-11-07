<?php

namespace MyCheckout\Payments\Request\Source;

use MyCheckout\Common\PaymentSourceType;

class RequestCustomerSource extends AbstractRequestSource
{

    public function __construct()
    {
        parent::__construct(PaymentSourceType::$customer);
    }

    /**
     * @var string
     */
    public $id;
}
