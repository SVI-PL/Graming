<?php

namespace MyCheckout\Risk;

use MyCheckout\ApiClient;
use MyCheckout\AuthorizationType;
use MyCheckout\CheckoutApiException;
use MyCheckout\CheckoutConfiguration;
use MyCheckout\Client;
use MyCheckout\Risk\PreAuthentication\PreAuthenticationAssessmentRequest;
use MyCheckout\Risk\PreCapture\PreCaptureAssessmentRequest;

/**
 * @deprecated Risk endpoints are no longer supported officially, This module will be removed in a future release.
 */
class RiskClient extends Client
{
    const PRE_AUTHENTICATION_PATH = "risk/assessments/pre-authentication";
    const PRE_CAPTURE_PATH = "risk/assessments/pre-capture";

    public function __construct(ApiClient $apiClient, CheckoutConfiguration $configuration)
    {
        parent::__construct($apiClient, $configuration, AuthorizationType::$secretKey);
    }

    /**
     * @param PreAuthenticationAssessmentRequest $preAuthenticationAssessmentRequest
     * @return array
     * @throws CheckoutApiException
     */
    public function requestPreAuthenticationRiskScan(
        PreAuthenticationAssessmentRequest $preAuthenticationAssessmentRequest
    ) {
        return $this->apiClient->post(
            self::PRE_AUTHENTICATION_PATH,
            $preAuthenticationAssessmentRequest,
            $this->sdkAuthorization()
        );
    }

    /**
     * @param PreCaptureAssessmentRequest $preCaptureAssessmentRequest
     * @return array
     * @throws CheckoutApiException
     */
    public function requestPreCaptureRiskScan(PreCaptureAssessmentRequest $preCaptureAssessmentRequest)
    {
        return $this->apiClient->post(self::PRE_CAPTURE_PATH, $preCaptureAssessmentRequest, $this->sdkAuthorization());
    }
}
