<?php

namespace MyCheckout\Payments\Sender;

class PaymentInstrumentSender extends PaymentSender
{
    public function __construct()
    {
        parent::__construct(PaymentSenderType::$instrument);
    }

}
