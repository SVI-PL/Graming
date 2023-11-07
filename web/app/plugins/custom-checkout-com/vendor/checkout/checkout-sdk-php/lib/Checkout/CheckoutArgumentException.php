<?php

namespace MyCheckout;

class CheckoutArgumentException extends CheckoutException
{

    public function __construct($message)
    {
        parent::__construct($message);
    }

}
