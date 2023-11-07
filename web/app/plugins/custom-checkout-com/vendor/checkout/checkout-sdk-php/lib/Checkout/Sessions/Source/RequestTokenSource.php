<?php

namespace MyCheckout\Sessions\Source;

use MyCheckout\Sessions\SessionSourceType;

class RequestTokenSource extends SessionSource
{
    public function __construct()
    {
        parent::__construct(SessionSourceType::$token);
    }

    /**
     * @var string
     */
    public $token;

    /**
     * @var bool
     */
    public $store_for_future_use;
}
