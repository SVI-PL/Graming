<?php

namespace MyCheckout\Payments\Previous\Source\Apm;

use MyCheckout\Common\PaymentSourceType;
use MyCheckout\Payments\Previous\Source\AbstractRequestSource;

class RequestGiropaySource extends AbstractRequestSource
{
    public function __construct()
    {
        parent::__construct(PaymentSourceType::$giropay);
    }

    /**
     * @var string
     */
    public $purpose;

    /**
     * @var string
     */
    public $bic;

    /**
     * @var array
     */
    public $info_fields;
}
