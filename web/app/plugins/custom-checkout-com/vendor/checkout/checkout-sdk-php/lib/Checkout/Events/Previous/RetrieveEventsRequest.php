<?php

namespace MyCheckout\Events\Previous;

use MyCheckout\Common\AbstractQueryFilter;

class RetrieveEventsRequest extends AbstractQueryFilter
{
    /**
     * @var string
     */
    public $payment_id;

    /**
     * @var string
     */
    public $charge_id;

    /**
     * @var string
     */
    public $track_id;

    /**
     * @var string
     */
    public $reference;

    /**
     * @var int
     */
    public $skip;

    /**
     * @var int
     */
    public $limit;
}
