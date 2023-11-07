<?php

namespace MyCheckout\Payments\Hosted;

use MyCheckout\Common\CustomerRequest;
use MyCheckout\Common\MarketplaceData;
use MyCheckout\Payments\BillingDescriptor;
use MyCheckout\Payments\BillingInformation;
use MyCheckout\Payments\PaymentRecipient;
use MyCheckout\Payments\ProcessingSettings;
use MyCheckout\Payments\RiskRequest;
use MyCheckout\Payments\ShippingDetails;
use MyCheckout\Payments\ThreeDsRequest;
use DateTime;

class HostedPaymentsSessionRequest
{
    /**
     * @var int
     */
    public $amount;

    /**
     * @var string value of Currency
     */
    public $currency;

    /**
     * @var string
     */
    public $reference;

    /**
     * @var string
     */
    public $description;

    /**
     * @var CustomerRequest
     */
    public $customer;

    /**
     * @var ShippingDetails
     */
    public $shipping;

    /**
     * @var BillingInformation
     */
    public $billing;

    /**
     * @var PaymentRecipient
     */
    public $recipient;

    /**
     * @var ProcessingSettings
     */
    public $processing;

    /**
     * @var array of Product
     */
    public $products;

    /**
     * @var array
     */
    public $metadata;

    /**
     * @var ThreeDsRequest
     */
    public $three_ds;

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
    public $cancel_url;

    /**
     * @var string
     */
    public $failure_url;

    /**
     * @var string
     */
    public $locale;

    /**
     * @var bool
     */
    public $capture;

    /**
     * @var DateTime
     */
    public $capture_on;

    /**
     * @var string value of PaymentType
     */
    public $payment_type;

    /**
     * @var string
     */
    public $payment_ip;

    /**
     * @var BillingDescriptor
     */
    public $billing_descriptor;

    /**
     * @var string value of PaymentSourceType
     */
    public $allow_payment_methods;

    //Not available on previous

    /**
     * @var string
     */
    public $processing_channel_id;

    /**
     * @var array values of AmountAllocations
     */
    public $amount_allocations;
}
