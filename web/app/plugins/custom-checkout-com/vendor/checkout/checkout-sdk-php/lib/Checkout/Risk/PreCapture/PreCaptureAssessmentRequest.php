<?php

namespace MyCheckout\Risk\PreCapture;

use MyCheckout\Common\CustomerRequest;
use MyCheckout\Risk\Device;
use MyCheckout\Risk\RiskPayment;
use MyCheckout\Risk\RiskShippingDetails;
use MyCheckout\Risk\Source\RiskPaymentRequestSource;
use DateTime;

class PreCaptureAssessmentRequest
{
    /**
     * @var string
     */
    public $assessment_id;

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
     * @var int
     */
    public $amount;

    /**
     * @var string value of Currency
     */
    public $currency;

    /**
     * @var RiskPayment
     */
    public $payment;

    /**
     * @var RiskShippingDetails
     */
    public $shipping;

    /**
     * @var Device
     */
    public $device;

    /**
     * @var array
     */
    public $metadata;

    /**
     * @var AuthenticationResult
     */
    public $authentication_result;

    /**
     * @var AuthorizationResult
     */
    public $authorization_result;
}
