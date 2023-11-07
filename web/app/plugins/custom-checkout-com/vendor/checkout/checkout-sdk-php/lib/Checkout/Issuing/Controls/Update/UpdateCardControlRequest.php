<?php

namespace MyCheckout\Issuing\Controls\Update;

use MyCheckout\Issuing\Controls\MccLimit;
use MyCheckout\Issuing\Controls\VelocityLimit;

class UpdateCardControlRequest
{
    /**
     * @var string
     */
    public $description;

    /**
     * @var VelocityLimit
     */
    public $velocity_limit;

    /**
     * @var MccLimit
     */
    public $mcc_limit;
}
