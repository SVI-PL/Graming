<?php

namespace MyCheckout\Instruments\Update;

use MyCheckout\Common\AccountHolder;
use MyCheckout\Common\InstrumentType;

class UpdateCardInstrumentRequest extends UpdateInstrumentRequest
{
    public function __construct()
    {
        parent::__construct(InstrumentType::$card);
    }

    /**
     * @var int
     */
    public $expiry_month;

    /**
     * @var int
     */
    public $expiry_year;

    /**
     * @var string
     */
    public $name;

    /**
     * @var UpdateCustomerRequest
     */
    public $customer;

    /**
     * @var AccountHolder
     */
    public $account_holder;
}
