<?php

namespace MyCheckout\Issuing\Cards\Create;

use MyCheckout\Issuing\CardType;

class VirtualCardRequest extends CardRequest
{
    public function __construct()
    {
        parent::__construct(CardType::$virtual);
    }

    /**
     * @var boolean
     */
    public $is_single_use;
}
