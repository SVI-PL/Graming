<?php

namespace MyCheckout\Payments;

use MyCheckout\Common\AbstractQueryFilter;

class PaymentsQueryFilter extends AbstractQueryFilter
{
    /**
     * @var int
     */
    public $limit;

    /**
     * @var int
     */
    public $skip;

    /**
     * @var string
     */
    public $reference;
}
