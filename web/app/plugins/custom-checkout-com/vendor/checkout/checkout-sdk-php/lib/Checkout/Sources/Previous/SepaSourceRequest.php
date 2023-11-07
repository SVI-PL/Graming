<?php

namespace MyCheckout\Sources\Previous;

use MyCheckout\Common\Address;

class SepaSourceRequest extends SourceRequest
{
    /**
     * @var Address
     */
    public $billing_address;

    /**
     * @var SourceData
     */
    public $source_data;

    public function __construct()
    {
        parent::__construct(SourceType::$sepa);
    }
}
