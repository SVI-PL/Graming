<?php

namespace MyCheckout\Instruments\Create;

use MyCheckout\Common\Phone;

class CreateCustomerInstrumentRequest
{
    /**
     * @var string
     */
    public $id;

    /**
     * @var string
     */
    public $email;

    /**
     * @var string
     */
    public $name;

    /**
     * @var Phone
     */
    public $phone;

    /**
     * @var bool
     */
    public $default;
}
