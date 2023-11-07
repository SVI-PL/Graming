<?php

namespace MyCheckout\Sessions;

use MyCheckout\Common\ChallengeIndicatorType;
use MyCheckout\Sessions\Channel\ChannelData;
use MyCheckout\Sessions\Completion\CompletionInfo;
use MyCheckout\Sessions\Source\SessionSource;

class SessionRequest
{
    /**
     * @var SessionSource
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
     * @var string
     */
    public $processing_channel_id;

    /**
     * @var SessionMarketplaceData
     */
    public $marketplace;

    /**
     * @var string value of AuthenticationType
     */
    public $authentication_type;

    /**
     * @var string value of Category
     */
    public $authentication_category;

    /**
     * @var CardholderAccountInfo
     */
    public $account_info;

    /**
     * @var ChallengeIndicatorType
     */
    public $challenge_indicator;

    /**
     * @var SessionsBillingDescriptor
     */
    public $billing_descriptor;

    /**
     * @var string
     */
    public $reference;

    /**
     * @var MerchantRiskInfo
     */
    public $merchant_risk_info;

    /**
     * @var string
     */
    public $prior_transaction_reference;

    /**
     * @var string value of TransactionType
     */
    public $transaction_type;

    /**
     * @var SessionAddress
     */
    public $shipping_address;

    /**
     * @var bool
     */
    public $shipping_address_matches_billing;

    /**
     * @var CompletionInfo
     */
    public $completion;

    /**
     * @var ChannelData
     */
    public $channel_data;

    /**
     * @var Recurring
     */
    public $recurring;

    /**
     * @var Installment
     */
    public $installment;
}
