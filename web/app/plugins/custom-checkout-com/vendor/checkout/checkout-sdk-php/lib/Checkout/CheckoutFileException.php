<?php

namespace MyCheckout;

class CheckoutFileException extends CheckoutException
{

    public function __construct($message)
    {
        parent::__construct($message);
    }

}
