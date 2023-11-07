<?php

namespace MyCheckout\Payments;

use MyCheckout\Common\Address;
use MyCheckout\Common\Phone;

class ShippingDetails
{
    /**
     * @var Address
     */
    public $address;

    /**
     * @var Phone
     */
    public $phone;

    /**
     * @var string
     */
    public $from_address_zip;
}
