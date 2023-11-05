<?php
use Checkout\CheckoutApiException;
use Checkout\CheckoutAuthorizationException;
use Checkout\CheckoutSdk;
use Checkout\Common\Address;
use Checkout\Common\Country;
use Checkout\Common\Currency;
use Checkout\Common\CustomerRequest;
use Checkout\Common\Phone;
use Checkout\Environment;
use Checkout\Payments\Request\PaymentRequest;
use Checkout\Payments\Request\Source\RequestCardSource;
use Checkout\Payments\Sender\PaymentIndividualSender;

//API Keys
$api = CheckoutSdk::builder()->staticKeys()
    ->environment(Environment::sandbox())
    ->secretKey(pf_checkout_com()->get_option('test_private_key'))
    ->build();

$phone = new Phone();
$phone->country_code = "+1";
$phone->number = "415 555 2671";

$address = new Address();
$address->address_line1 = "CheckoutSdk.com";
$address->address_line2 = "90 Tottenham Court Road";
$address->city = "London";
$address->state = "London";
$address->zip = "W1T 4TJ";
$address->country = Country::$GB;

$requestCardSource = new RequestCardSource();
$requestCardSource->name = "Name";
$requestCardSource->number = "4544249167673670";
$requestCardSource->expiry_year = 2030;
$requestCardSource->expiry_month = 12;
$requestCardSource->cvv = "100";
$requestCardSource->billing_address = $address;
$requestCardSource->phone = $phone;

$customerRequest = new CustomerRequest();
$customerRequest->email = "email@docs.checkout.com";
$customerRequest->name = "Customer";


$paymentIndividualSender = new PaymentIndividualSender();
$paymentIndividualSender->fist_name = "FirstName";
$paymentIndividualSender->last_name = "LastName";
$paymentIndividualSender->address = $address;

$request = new PaymentRequest();
$request->processing_channel_id = "44064430909949989440622222222";
$request->source = $requestCardSource;
$request->capture = true;
$request->reference = "reference";
$request->amount = 10;
$request->currency = Currency::$USD;
$request->customer = $customerRequest;
$request->sender = $paymentIndividualSender;

try {
    $response = $api->getPaymentsClient()->requestPayment($request);

} catch (CheckoutApiException $e) {
    $error_details = $e->error_details;
    $http_status_code = isset($e->http_metadata) ? $e->http_metadata->getStatusCode() : null;
} catch (CheckoutAuthorizationException $e) {
}