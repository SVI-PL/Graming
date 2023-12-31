<?php

namespace Checkout\Sessions\Source;

use Checkout\Sessions\SessionSourceType;

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
}
