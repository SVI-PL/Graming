<?php

namespace MyCheckout\Issuing\Controls\Create;

use MyCheckout\Issuing\Controls\ControlType;
use MyCheckout\Issuing\Controls\VelocityLimit;

class VelocityCardControlRequest extends CardControlRequest
{
    public function __construct()
    {
        parent::__construct(ControlType::$velocity_limit);
    }

    /**
     * @var VelocityLimit
     */
    public $velocity_limit;
}
