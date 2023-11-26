<?php
/*
 * Plugin Name: Custom Checkout.com
 * Description: Card checkout
 * Author: svi
 * Author URI: https://milvus.agency
 * Version: 1.0.0
 */
require_once(dirname(__FILE__) . '/vendor/autoload.php');

use MyCheckout\CheckoutApiException;
use MyCheckout\CheckoutAuthorizationException;
use MyCheckout\CheckoutSdk;
use MyCheckout\Common\Address;
use MyCheckout\Common\Currency;
use MyCheckout\Common\CustomerRequest;
use MyCheckout\Environment;
use MyCheckout\Payments\Request\PaymentRequest;
use MyCheckout\Payments\Request\Source\RequestCardSource;
use MyCheckout\Payments\Sender\PaymentIndividualSender;

/*Exit if accessed directly*/
if (!defined('ABSPATH')) {
    exit;
}

function pf_checkout_com_register_gateway_class($gateways)
{
    $gateways[] = 'WC_Custom_Checkout_Gateway';
    return $gateways;
}
add_filter('woocommerce_payment_gateways', 'pf_checkout_com_register_gateway_class');

function pf_checkout_com()
{

    class WC_Custom_Checkout_Gateway extends WC_Payment_Gateway
    {


        public function __construct()
        {

            $this->id = 'custom_checkout';
            $this->icon = '';
            $this->has_fields = true;
            $this->method_title = 'Checkout.com API';
            $this->method_description = 'Checkout payment gateway';

            $this->supports = array(
                'products'
            );

            $this->init_form_fields();

            $this->init_settings();
            $this->title = $this->get_option('title');
            $this->description = $this->get_option('description');
            $this->enabled = $this->get_option('enabled');
            $this->testmode = 'yes' === $this->get_option('testmode');
            $this->private_key = $this->testmode ? $this->get_option('test_private_key') : $this->get_option('private_key');
            $this->publishable_key = $this->testmode ? $this->get_option('test_publishable_key') : $this->get_option('publishable_key');

            add_action('woocommerce_update_options_payment_gateways_' . $this->id, array($this, 'process_admin_options'));
        }

        public function init_form_fields()
        {

            $this->form_fields = array(
                'enabled' => array(
                    'title' => 'On/off',
                    'label' => 'Enable plugin',
                    'type' => 'checkbox',
                    'description' => '',
                    'default' => 'no'
                ),
                'title' => array(
                    'title' => 'Заголовок',
                    'type' => 'text',
                    'description' => 'Это то, что пользователь увидит как название метода оплаты на странице оформления заказа.',
                    'default' => 'Card payment',
                    'desc_tip' => true,
                ),
                'description' => array(
                    'title' => 'Описание',
                    'type' => 'textarea',
                    'description' => 'Описание этого метода оплаты, которое будет отображаться пользователю на странице оформления заказа.',
                    'default' => 'Custom payment',
                ),
                'testmode' => array(
                    'title' => 'Sandbox',
                    'label' => 'Enable sandbox',
                    'type' => 'checkbox',
                    'description' => 'Test payment gateway',
                    'default' => 'yes',
                    'desc_tip' => true,
                ),
                'test_publishable_key' => array(
                    'title' => 'Public key (sandbox)',
                    'type' => 'text'
                ),
                'test_private_key' => array(
                    'title' => 'Secret Key (sandbox)',
                    'type' => 'text',
                ),
                'publishable_key' => array(
                    'title' => 'Public key',
                    'type' => 'text'
                ),
                'private_key' => array(
                    'title' => 'Secret Key',
                    'type' => 'text'
                )
            );
        }

        public function payment_fields()
        {

        }

        public function validate_fields()
        {
            if (empty($_POST["billing_email"])) {
                wc_add_notice('You need add your Email!', 'error');
                return false;
            }
            if (empty($_POST["card_name"])) {
                wc_add_notice('Please add the Cardholders name', 'error');
                return false;
            }
            if (empty($_POST["cardnumber"])) {
                wc_add_notice('Please add the card number', 'error');
                return false;
            }
            if (empty($_POST["card_month"])) {
                wc_add_notice('Please add the card expiration month', 'error');
                return false;
            }
            if (empty($_POST["card_year"])) {
                wc_add_notice('Please add the card expiration year', 'error');
                return false;
            }
            if (empty($_POST["card_cvv"])) {
                wc_add_notice('Please add the card CVV number', 'error');
                return false;
            }
            if (empty($_POST["billing_email"])) {
                wc_add_notice('You need add your Email!', 'error');
                return false;
            }
            return true;

        }

        public function process_payment($order_id)
        {
            $card_number = str_replace(" ","",$_POST["cardnumber"]);
            $card_year = "20" . $_POST["card_year"];

            $order = wc_get_order($order_id);
            $env = Environment::production();

            $private_key = "sk_f7f9a069-dcc5-45d8-aa72-e60f605c9514";
            $publishable_key = "pk_66e19b3f-a431-44ff-823f-d773d960f6b9";

            //API Keys
            $api = CheckoutSdk::builder()
                ->staticKeys()
                ->environment($env)
                ->publicKey($publishable_key)
                ->secretKey($private_key)
                ->build();

            $address = new Address();
            $address->zip = $_POST["billing_postcode"];
            $address->State = $_POST["billing_country"];
            $address->country = $_POST["billing_country"];

            $requestCardSource = new RequestCardSource();
            $requestCardSource->number = (int) $card_number;
            $requestCardSource->expiry_year = $card_year;
            $requestCardSource->expiry_month = $_POST["card_month"];
            $requestCardSource->cvv = $_POST["card_cvv"];
            $requestCardSource->billing_address = $address;
            
            $customerRequest = new CustomerRequest();
            $customerRequest->email = $_POST["billing_email"];
            $customerRequest->name = "Customer";

            $paymentIndividualSender = new PaymentIndividualSender();
            $paymentIndividualSender->fist_name = "FirstName";
            $paymentIndividualSender->last_name = "LastName";
            $paymentIndividualSender->address = $address;

            $request = new PaymentRequest();
            $request->source = $requestCardSource;
            $request->capture = true;
            $request->reference = "reference";
            $request->amount = (float) $order->get_total() * 100;

            $request->currency = Currency::$USD;
            $request->customer = $customerRequest;
            $request->sender = $paymentIndividualSender;

            try {
                $response = $api->getPaymentsClient()->requestPayment($request);
                if ($response["approved"] == false) {
                    $resp_str = 'Status: ' . $response["status"] . '. Reason: ' . $response["response_summary"] . ' Code: ' . $response["response_code"];
                    wc_add_notice($resp_str, 'error');
                    return array(
                        'result' => 'error',
                    );
                }
            } catch (CheckoutApiException $e) {
                $error_details = $e->error_details;
                $http_status_code = isset($e->http_metadata) ? $e->http_metadata->getStatusCode() : null;
                var_dump($error_details);
                wc_add_notice('Error ' . $http_status_code, 'error');
                return array(
                    'result'   => 'error',
                );
            
            } catch (CheckoutAuthorizationException $e) {
                wc_add_notice('Error ' . $e, 'error');
                return array(
                    'result'   => 'error',
                );
            }

            $order->payment_complete();
            $order->update_status('processing');

            return array(
                'result' => 'success',
                'redirect' => $this->get_return_url($order),
            );
        }

    }

}

add_action('plugins_loaded', 'pf_checkout_com');