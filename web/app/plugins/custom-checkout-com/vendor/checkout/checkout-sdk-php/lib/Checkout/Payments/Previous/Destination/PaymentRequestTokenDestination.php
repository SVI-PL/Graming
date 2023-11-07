<?php

namespace MyCheckout\Payments\Previous\Destination;

use MyCheckout\Common\Address;
use MyCheckout\Common\Phone;
use MyCheckout\Payments\PaymentDestinationType;

class PaymentRequestTokenDestination extends PaymentRequestDestination
{
    public function __construct()
    {
        parent::__construct(PaymentDestinationType::$token);
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

    /**
     * @var Address
     */
    public $billing_address;

    /**
     * @var Phone
     */
    public $phone;
}
