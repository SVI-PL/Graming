<?php

namespace MyCheckout\Sessions;

use MyCheckout\AuthorizationType;
use MyCheckout\CheckoutAuthorizationException;
use MyCheckout\SdkAuthorization;
use MyCheckout\SdkCredentialsInterface;

final class SessionSecretSdkCredentials implements SdkCredentialsInterface
{
    public $secret;

    public function __construct($secret)
    {
        $this->secret = $secret;
    }

    /**
     * @param $authorizationType
     * @return SdkAuthorization
     * @throws CheckoutAuthorizationException
     */
    public function getAuthorization($authorizationType)
    {
        if ($authorizationType == AuthorizationType::$custom) {
            return new SdkAuthorization(AuthorizationType::$custom, $this->secret);
        }
        throw CheckoutAuthorizationException::invalidAuthorization($authorizationType);
    }
}
