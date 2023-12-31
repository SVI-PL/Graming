<?php

namespace MyCheckout\Payments\Previous\Source\Apm;

use MyCheckout\Common\PaymentSourceType;
use MyCheckout\Payments\Previous\Source\AbstractRequestSource;
use DateTime;

class RequestFawrySource extends AbstractRequestSource
{
    public function __construct()
    {
        parent::__construct(PaymentSourceType::$fawry);
    }

    /**
     * @var string
     */
    public $description;

    /**
     * @var string
     */
    public $customer_profile_id;

    /**
     * @var string
     */
    public $customer_mobile;

    /**
     * @var string
     */
    public $customer_email;

    /**
     * @var DateTime
     */
    public $expires_on;

    /**
     * @var array of FawryProduct
     */
    public $products;
}
