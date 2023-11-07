<?php

namespace MyCheckout\Payments;

use MyCheckout\Common\Address;
use MyCheckout\Common\Phone;

class BillingInformation
{
    /**
     * @var Address
     */
    public $address;

    /**
     * @var Phone
     */
    public $phone;
}
