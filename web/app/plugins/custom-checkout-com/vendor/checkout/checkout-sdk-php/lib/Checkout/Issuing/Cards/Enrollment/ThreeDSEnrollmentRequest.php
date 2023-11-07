<?php

namespace MyCheckout\Issuing\Cards\Enrollment;

use MyCheckout\Common\Phone;

abstract class ThreeDSEnrollmentRequest
{
    /**
     * @var string
     */
    public $locale;

    /**
     * @var Phone
     */
    public $phone_number;
}
