<?php

namespace MyCheckout\Payments\Request\Source\Apm;

use MyCheckout\Common\PaymentSourceType;
use MyCheckout\Payments\Request\Source\AbstractRequestSource;

class RequestIdealSource extends AbstractRequestSource
{
    public function __construct()
    {
        parent::__construct(PaymentSourceType::$ideal);
    }

    /**
     * @var string
     */
    public $bic;

    /**
     * @var string
     */
    public $description;

    /**
     * @var string
     */
    public $language;
}
