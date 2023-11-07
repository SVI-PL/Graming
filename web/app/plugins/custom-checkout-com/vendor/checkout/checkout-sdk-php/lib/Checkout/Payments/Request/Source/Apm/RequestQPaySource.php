<?php

namespace MyCheckout\Payments\Request\Source\Apm;

use MyCheckout\Common\PaymentSourceType;
use MyCheckout\Payments\Request\Source\AbstractRequestSource;

class RequestQPaySource extends AbstractRequestSource
{
    public function __construct()
    {
        parent::__construct(PaymentSourceType::$qpay);
    }

    /**
     * @var int
     */
    public $quantity;

    /**
     * @var string
     */
    public $description;

    /**
     * @var string
     */
    public $language;

    /**
     * @var string
     */
    public $national_id;
}
