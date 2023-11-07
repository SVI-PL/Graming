<?php

namespace MyCheckout\Issuing\Controls\Create;

use MyCheckout\Issuing\Controls\ControlType;
use MyCheckout\Issuing\Controls\MccLimit;

class MccCardControlRequest extends CardControlRequest
{
    public function __construct()
    {
        parent::__construct(ControlType::$mcc_limit);
    }

    /**
     * @var MccLimit
     */
    public $mcc_limit;
}
