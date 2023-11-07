<?php

namespace MyCheckout\Accounts;

class InstrumentDetailsFasterPayments implements InstrumentDetails
{
    /**
     * @var string
     */
    public $account_number;

    /**
     * @var string
     */
    public $bank_code;
}
