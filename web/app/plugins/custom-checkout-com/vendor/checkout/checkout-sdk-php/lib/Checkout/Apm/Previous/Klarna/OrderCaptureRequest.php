<?php

namespace MyCheckout\Apm\Previous\Klarna;

use MyCheckout\Common\ShippingInfo;
use MyCheckout\Common\PaymentSourceType;

class OrderCaptureRequest
{
    public function __construct()
    {
        $this->type = PaymentSourceType::$klarna;
    }

    /**
     * @var string value of PaymentSourceType
     */
    public $type;

    /**
     * @var int
     */
    public $amount;

    /**
     * @var int
     */
    public $reference;

    /**
     * @var array
     */
    public $metadata;

    /**
     * @var Klarna
     */
    public $klarna;

    /**
     * @var ShippingInfo
     */
    public $shipping_info;

    /**
     * @var int
     */
    public $shipping_delay;
}
