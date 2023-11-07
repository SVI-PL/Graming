<?php

namespace MyCheckout\Payments\Request;

use MyCheckout\Common\CustomerRequest;
use MyCheckout\Common\MarketplaceData;
use MyCheckout\Payments\BillingDescriptor;
use MyCheckout\Payments\Request\Source\AbstractRequestSource;
use MyCheckout\Payments\Sender\PaymentSender;
use MyCheckout\Payments\PaymentRecipient;
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
     * @var string value of AuthorizationType
     */
    public $authorization_type;

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
     * @var ThreeDsRequest
     */
    public $three_ds;

    /**
     * @var string
     */
    public $processing_channel_id;

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
     * @var PaymentSender
     */
    public $sender;

    /**
     * @var PaymentRecipient
     */
    public $recipient;

    /**
     * @deprecated This property will be removed in the future, and should be used {@link amount_allocations} instead
     * @var MarketplaceData
     */
    public $marketplace;

    /**
     * @var array values of AmountAllocations
     */
    public $amount_allocations;

    /**
     * @var ProcessingSettings
     */
    public $processing;

    /**
     * @var array
     */
    public $metadata;

    /**
     * @var array of Checkout\Payments\Product
     */
    public $items;
}
