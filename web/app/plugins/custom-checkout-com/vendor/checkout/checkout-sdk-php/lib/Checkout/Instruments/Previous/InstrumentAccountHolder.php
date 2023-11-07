<?php

namespace MyCheckout\Instruments\Previous;

use MyCheckout\Common\Address;
use MyCheckout\Common\Phone;

class InstrumentAccountHolder
{
    /**
     * @var Address
     */
    public $billing_address;

    /**
     * @var Phone
     */
    public $phone;
}
