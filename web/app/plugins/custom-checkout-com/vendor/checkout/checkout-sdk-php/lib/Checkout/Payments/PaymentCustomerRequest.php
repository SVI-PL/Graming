<?php

namespace MyCheckout\Payments;

use MyCheckout\Common\CustomerRequest;

class PaymentCustomerRequest extends CustomerRequest
{
    /**
     * @var string
     */
    public $tax_number;
}
