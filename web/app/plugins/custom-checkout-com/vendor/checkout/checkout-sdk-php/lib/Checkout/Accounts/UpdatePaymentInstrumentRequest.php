<?php

namespace MyCheckout\Accounts;

class UpdatePaymentInstrumentRequest
{
    /**
     * @var string
     */
    public $label;

    /**
     * @var bool
     */
    public $default;

    /**
     * @var Headers
     */
    public $headers;
}
