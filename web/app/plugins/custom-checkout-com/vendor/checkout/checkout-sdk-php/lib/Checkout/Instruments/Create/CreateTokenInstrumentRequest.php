<?php

namespace MyCheckout\Instruments\Create;

use MyCheckout\Common\AccountHolder;
use MyCheckout\Common\InstrumentType;

class CreateTokenInstrumentRequest extends CreateInstrumentRequest
{

    public function __construct()
    {
        parent::__construct(InstrumentType::$token);
    }

    /**
     * @var string
     */
    public $token;

    /**
     * @var AccountHolder
     */
    public $account_holder;

    /**
     * @var CreateCustomerInstrumentRequest
     */
    public $customer;
}
