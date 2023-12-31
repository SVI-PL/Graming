<?php

namespace Checkout\Sessions\Source;

use Checkout\Sessions\SessionScheme;
use Checkout\Sessions\SessionSourceType;

class SessionCardSource extends SessionSource
{

    public function __construct()
    {
        parent::__construct(SessionSourceType::$card);
    }

    /**
     * @var string
     */
    public $number;

    /**
     * @var int
     */
    public $expiry_month;

    /**
     * @var int
     */
    public $expiry_year;

    /**
     * @var string
     */
    public $name;

    /**
     * @var SessionScheme
     */
    public $scheme;

    /**
     * @var bool
     */
    public $stored;
}
