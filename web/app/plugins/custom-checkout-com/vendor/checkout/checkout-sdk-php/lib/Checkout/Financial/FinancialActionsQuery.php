<?php

namespace MyCheckout\Financial;

use MyCheckout\Common\AbstractQueryFilter;

class FinancialActionsQuery extends AbstractQueryFilter
{
    /**
     * @var string
     */
    public $payment_id;

    /**
     * @var string
     */
    public $action_id;

    /**
     * @var string
     */
    public $reference;

    /**
     * @var int
     */
    public $limit;

    /**
     * @var string
     */
    public $pagination_token;
}
