<?php

namespace MyCheckout\Payments\Request\Source;

class AbstractRequestSource
{
    /**
     * @var string value of PaymentSourceType
     */
    public $type;

    public function __construct($type)
    {
        $this->type = $type;
    }
}
