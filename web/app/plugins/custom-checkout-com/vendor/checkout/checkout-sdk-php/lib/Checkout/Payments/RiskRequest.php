<?php

namespace MyCheckout\Payments;

class RiskRequest
{
    /**
     * @var bool
     */
    public $enabled;

    /**
     * @var string
     */
    public $device_session_id;
}
