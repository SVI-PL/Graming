<?php

namespace MyCheckout\Issuing\Cards\Create;

use MyCheckout\Issuing\CardType;

class PhysicalCardRequest extends CardRequest
{
    public function __construct()
    {
        parent::__construct(CardType::$physical);
    }

    /**
     * @var ShippingInstructions
     */
    public $shipping_instructions;
}
