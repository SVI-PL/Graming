<?php

namespace MyCheckout\Payments\Previous;

use MyCheckout\Common\CustomerRequest;
use MyCheckout\Payments\BillingDescriptor;
use MyCheckout\Payments\PaymentRecipient;
use MyCheckout\Payments\Previous\Source\AbstractRequestSource;
use MyCheckout\Payments\ProcessingSettings;
use MyCheckout\Payments\RiskRequest;
use MyCheckout\Payments\ShippingDetails;
use MyCheckout\Payments\ThreeDsRequest;
use DateTime;

class PaymentRequest
{
    /**
     * @var AbstractRequestSource
     */
    public $source;

    /**
     * @var int
     */
    public $amount;

    /**
     * @var string value of Currency
     */
    public $currency;

    /**
     * @var string value of PaymentType
     */
    public $payment_type;

    /**
     * @var bool
     */
    public $merchant_initiated;

    /**
     * @var string
     */
    public $reference;

    /**
     * @var string
     */
    public $description;

    /**
     * @var bool
     */
    public $capture;

    /**
     * @var DateTime
     */
    public $capture_on;

    /**
     * @var CustomerRequest
     */
    public $customer;

    /**
     * @var BillingDescriptor
     */
    public $billing_descriptor;

    /**
     * @var ShippingDetails
     */
    public $shipping;

    /**
     * @var string
     */
    public $previous_payment_id;

    /**
     * @var RiskRequest
     */
    public $risk;

    /**
     * @var string
     */
    public $success_url;

    /**
     * @var string
     */
    public $failure_url;

    /**
     * @var string
     */
    public $payment_ip;

    /**
     * @var ThreeDsRequest
     */
    public $three_ds;

    /**
     * @var PaymentRecipient
     */
    public $recipient;

    /**
     * @var array
     */
    public $metadata;

    /**
     * @var ProcessingSettings
     */
    public $processing;
}
