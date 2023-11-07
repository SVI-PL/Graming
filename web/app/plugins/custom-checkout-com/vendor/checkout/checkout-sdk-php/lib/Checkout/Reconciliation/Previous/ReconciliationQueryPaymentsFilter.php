<?php

namespace MyCheckout\Reconciliation\Previous;

use MyCheckout\Common\QueryFilterDateRange;

class ReconciliationQueryPaymentsFilter extends QueryFilterDateRange
{
    /**
     * @var int
     */
    public $limit;

    /**
     * @var string
     */
    public $reference;
}
