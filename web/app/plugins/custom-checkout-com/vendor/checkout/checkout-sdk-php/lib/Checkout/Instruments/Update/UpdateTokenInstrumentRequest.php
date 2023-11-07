<?php

namespace MyCheckout\Instruments\Update;

use MyCheckout\Common\InstrumentType;

class UpdateTokenInstrumentRequest extends UpdateInstrumentRequest
{
    public function __construct()
    {
        parent::__construct(InstrumentType::$token);
    }

    /**
     * @var string
     */
    public $token;
}
