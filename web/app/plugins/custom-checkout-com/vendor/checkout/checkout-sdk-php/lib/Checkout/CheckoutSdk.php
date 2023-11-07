<?php

namespace MyCheckout;

class CheckoutSdk
{
    public static function builder()
    {
        return new CheckoutSdkBuilder();
    }
}
