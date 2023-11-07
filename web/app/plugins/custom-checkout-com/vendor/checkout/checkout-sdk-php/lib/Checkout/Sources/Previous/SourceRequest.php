<?php

namespace MyCheckout\Sources\Previous;

use MyCheckout\Common\CustomerRequest;
use MyCheckout\Common\Phone;

abstract class SourceRequest
{
    /**
     * @var string value of SourceType
     */
    public $type;

    /**
     * @var string
     */
    public $reference;

    /**
     * @var Phone
     */
    public $phone;

    /**
     * @var CustomerRequest
     */
    public $customer;

    public function __construct($type)
    {
        $this->type = $type;
    }
}
