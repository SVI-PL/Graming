<?php

namespace MyCheckout\Payments\Request\Source\Apm;

use MyCheckout\Common\PaymentSourceType;
use MyCheckout\Payments\Previous\Source\AbstractRequestSource;

class RequestKnetSource extends AbstractRequestSource
{
    public function __construct()
    {
        parent::__construct(PaymentSourceType::$knet);
    }

    /**
     * @var string
     */
    public $language;

    /**
     * @var string
     */
    public $user_defined_field1;

    /**
     * @var string
     */
    public $user_defined_field2;

    /**
     * @var string
     */
    public $user_defined_field3;

    /**
     * @var string
     */
    public $user_defined_field4;

    /**
     * @var string
     */
    public $user_defined_field5;

    /**
     * @var string
     */
    public $card_token;

    /**
     * @var string
     */
    public $ptlf;
}
