<?php

namespace MyCheckout\Issuing\Cards\Create;

use MyCheckout\Common\Address;

class ShippingInstructions
{
    /**
     * @var string
     */
    public $recipient_address;

    /**
     * @var Address
     */
    public $shipping_address;

    /**
     * @var string
     */
    public $additional_comment;
}
