<?php

namespace MyCheckout\Previous;

use MyCheckout\ApiClient;
use MyCheckout\Apm\CheckoutApmApi;
use MyCheckout\AuthorizationType;
use MyCheckout\CheckoutConfiguration;
use MyCheckout\Customers\CustomersClient;
use MyCheckout\Disputes\DisputesClient;
use MyCheckout\Events\Previous\EventsClient;
use MyCheckout\Instruments\Previous\InstrumentsClient;
use MyCheckout\Payments\Hosted\HostedPaymentsClient;
use MyCheckout\Payments\Links\PaymentLinksClient;
use MyCheckout\Payments\Previous\PaymentsClient;
use MyCheckout\Reconciliation\Previous\ReconciliationClient;
use MyCheckout\Risk\RiskClient;
use MyCheckout\Sources\Previous\SourcesClient;
use MyCheckout\Tokens\TokensClient;
use MyCheckout\Webhooks\Previous\WebhooksClient;

final class CheckoutApi extends CheckoutApmApi
{
    private $sourcesClient;
    private $tokensClient;
    private $instrumentsClient;
    private $webhooksClient;
    private $eventsClient;
    private $paymentsClient;
    private $customersClient;
    private $disputesClient;
    private $paymentLinksClient;
    private $hostedPaymentsClient;
    private $riskClient;
    private $reconciliationClient;

    public function __construct(ApiClient $apiClient, CheckoutConfiguration $configuration)
    {
        parent::__construct($apiClient, $configuration);
        $this->sourcesClient = new SourcesClient($apiClient, $configuration);
        $this->tokensClient = new TokensClient($apiClient, $configuration);
        $this->instrumentsClient = new InstrumentsClient($apiClient, $configuration);
        $this->webhooksClient = new WebhooksClient($apiClient, $configuration);
        $this->eventsClient = new EventsClient($apiClient, $configuration);
        $this->paymentsClient = new PaymentsClient($apiClient, $configuration);
        $this->customersClient = new CustomersClient($apiClient, $configuration, AuthorizationType::$secretKey);
        $this->disputesClient = new DisputesClient($apiClient, $configuration, AuthorizationType::$secretKey);
        $this->paymentLinksClient = new PaymentLinksClient($apiClient, $configuration);
        $this->hostedPaymentsClient = new HostedPaymentsClient($apiClient, $configuration);
        $this->riskClient = new RiskClient($apiClient, $configuration);
        $this->reconciliationClient = new ReconciliationClient($apiClient, $configuration);
    }

    /**
     * @return SourcesClient
     */
    public function getSourcesClient()
    {
        return $this->sourcesClient;
    }

    /**
     * @return TokensClient
     */
    public function getTokensClient()
    {
        return $this->tokensClient;
    }

    /**
     * @return InstrumentsClient
     */
    public function getInstrumentsClient()
    {
        return $this->instrumentsClient;
    }

    /**
     * @return WebhooksClient
     */
    public function getWebhooksClient()
    {
        return $this->webhooksClient;
    }

    /**
     * @return EventsClient
     */
    public function getEventsClient()
    {
        return $this->eventsClient;
    }

    /**
     * @return PaymentsClient
     */
    public function getPaymentsClient()
    {
        return $this->paymentsClient;
    }

    /**
     * @return CustomersClient
     */
    public function getCustomersClient()
    {
        return $this->customersClient;
    }

    /**
     * @return DisputesClient
     */
    public function getDisputesClient()
    {
        return $this->disputesClient;
    }

    /**
     * @return PaymentLinksClient
     */
    public function getPaymentLinksClient()
    {
        return $this->paymentLinksClient;
    }

    /**
     * @return HostedPaymentsClient
     */
    public function getHostedPaymentsClient()
    {
        return $this->hostedPaymentsClient;
    }

    /**
     * @return RiskClient
     */
    public function getRiskClient()
    {
        return $this->riskClient;
    }

    /**
     * @return ReconciliationClient
     */
    public function getReconciliationClient()
    {
        return $this->reconciliationClient;
    }
}
