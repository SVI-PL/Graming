<?php

namespace Checkout\Payments;

use Checkout\Common\Address;
use Checkout\Common\Phone;

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
}
