<?php

namespace MyCheckout\Payments\Previous;

class CaptureRequest
{
    /**
     * @var int
     */
    public $amount;

    /**
     * @var string
     */
    public $reference;

    /**
     * @var array
     */
    public $metadata;
}
