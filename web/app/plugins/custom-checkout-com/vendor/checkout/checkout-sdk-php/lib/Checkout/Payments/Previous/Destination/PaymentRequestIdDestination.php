<?php

namespace MyCheckout\Payments\Previous\Destination;

use MyCheckout\Payments\PaymentDestinationType;

class PaymentRequestIdDestination extends PaymentRequestDestination
{
    public function __construct()
    {
        parent::__construct(PaymentDestinationType::$id);
    }

    /**
     * @var string
     */
    public $id;

    /**
     * @var string
     */
    public $first_name;

    /**
     * @var string
     */
    public $last_name;
}
