<?php

namespace MyCheckout\Payments\Sender;

use MyCheckout\Common\AccountHolderIdentification;
use MyCheckout\Common\Address;

class PaymentCorporateSender extends PaymentSender
{
    public function __construct()
    {
        parent::__construct(PaymentSenderType::$corporate);
    }

    /**
     * @var string
     */
    public $company_name;

    /**
     * @var Address
     */
    public $address;

    /**
     * @var string
     */
    public $reference_type;

    /**
     * @var string
     */
    public $source_of_funds;

    /**
     * @var AccountHolderIdentification
     */
    public $identification;
}
