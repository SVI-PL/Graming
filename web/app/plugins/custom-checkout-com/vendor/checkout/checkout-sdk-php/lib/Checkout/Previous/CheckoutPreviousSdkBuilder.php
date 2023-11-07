<?php

namespace MyCheckout\Previous;

class CheckoutPreviousSdkBuilder
{

    public function staticKeys()
    {
        return new CheckoutStaticKeysPreviousSdkBuilder();
    }

}
