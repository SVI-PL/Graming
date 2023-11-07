<?php

namespace MyCheckout\Accounts;

use MyCheckout\Common\AbstractQueryFilter;

class PaymentInstrumentsQuery extends AbstractQueryFilter
{
    /**
     * @var string
     */
    public $status;
}
