<?php

namespace MyCheckout\Issuing\Testing;

use MyCheckout\Common\Currency;

class TransactionSimulation
{
    /**
     * @var string value of TransactionType
     */
    public $type;

    /**
     * @var int
     */
    public $amount;

    /**
     * @var string value of Currency
     */
    public $currency;

    /**
     * @var string value of TransactionMerchant
     */
    public $merchant;

    /**
     * @var string value of TransactionAuthorizationType
     */
    public $transaction;
}
