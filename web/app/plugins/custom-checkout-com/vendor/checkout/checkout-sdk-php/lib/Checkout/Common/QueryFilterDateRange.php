<?php

namespace MyCheckout\Common;

use DateTime;

class QueryFilterDateRange extends AbstractQueryFilter
{
    /**
     * @var DateTime
     */
    public $from;

    /**
     * @var DateTime
     */
    public $to;
}
