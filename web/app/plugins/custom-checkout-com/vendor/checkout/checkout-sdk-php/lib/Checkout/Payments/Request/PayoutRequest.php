<?php

namespace MyCheckout\Payments\Request;

use MyCheckout\Payments\Destination\PaymentRequestDestination;
use MyCheckout\Payments\Request\Source\PayoutRequestSource;
use MyCheckout\Payments\Sender\PaymentSender;

class PayoutRequest
{

    /**
     * @var PayoutRequestSource
     */
    public $source;

    /**
     * @var PaymentRequestDestination
     */
    public $destination;

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
     * @var PayoutBillingDescriptor
     */
    public $billing_descriptor;

    /**
     * @var PaymentSender
     */
    public $sender;

    /**
     * @var PaymentInstruction
     */
    public $instruction;

    /**
     * @var string
     */
    public $processing_channel_id;
}
