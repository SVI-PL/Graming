<?php

namespace MyCheckout\Risk\PreAuthentication;

use MyCheckout\Common\CustomerRequest;
use MyCheckout\Risk\Device;
use MyCheckout\Risk\RiskPayment;
use MyCheckout\Risk\RiskShippingDetails;
use MyCheckout\Risk\Source\RiskPaymentRequestSource;
use DateTime;

class PreAuthenticationAssessmentRequest
{
    /**
     * @var DateTime
     */
    public $date;

    /**
     * @var RiskPaymentRequestSource
     */
    public $source;

    /**
     * @var CustomerRequest
     */
    public $customer;

    /**
     * @var RiskPayment
     */
    public $payment;

    /**
     * @var RiskShippingDetails
     */
    public $shipping;

    /**
     * @var string
     */
    public $reference;

    /**
     * @var string
     */
    public $description;

    /**
     * @var int
     */
    public $amount;

    /**
     * @var string value of Currency
     */
    public $currency;

    /**
     * @var Device
     */
    public $device;

    /**
     * @var array
     */
    public $metadata;
}
