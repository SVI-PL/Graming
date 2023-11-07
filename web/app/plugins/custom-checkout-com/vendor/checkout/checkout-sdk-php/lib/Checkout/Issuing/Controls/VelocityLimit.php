<?php

namespace MyCheckout\Issuing\Controls;

class VelocityLimit
{
    /**
     * @var int
     */
    public $amount_limit;

    /**
     * @var VelocityWindow
     */
    public $velocity_window;

    /**
     * @var array of string
     */
    public $mcc_list;
}
