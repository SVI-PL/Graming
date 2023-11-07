<?php

namespace MyCheckout;

interface SdkCredentialsInterface
{
    public function getAuthorization($authorizationType);
}
