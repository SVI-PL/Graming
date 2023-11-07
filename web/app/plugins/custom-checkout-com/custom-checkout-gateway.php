<?php
/*
 * Plugin Name: Custom Checkout.com
 * Description: Card checkout
 * Author: svi
 * Author URI: https://milvus.agency
 * Version: 1.0.0
 */
require_once(dirname(__FILE__) . '/vendor/autoload.php');

use Checkout\CheckoutApiException;
use Checkout\CheckoutAuthorizationException;
use Checkout\CheckoutSdk;
use Checkout\Common\Address;
use Checkout\Common\Country;
use Checkout\Common\Currency;
use Checkout\Common\CustomerRequest;
use Checkout\Common\Phone;
use Checkout\Environment;
use Checkout\OAuthScope;
use Checkout\Payments\Request\PaymentRequest;
use Checkout\Payments\Request\Source\RequestCardSource;
use Checkout\Payments\Sender\Identification;
use Checkout\Payments\Sender\IdentificationType;
use Checkout\Payments\Sender\PaymentIndividualSender;

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
                    'default' => 'Оплатить картой',
                    'desc_tip' => true,
                ),
                'description' => array(
                    'title' => 'Описание',
                    'type' => 'textarea',
                    'description' => 'Описание этого метода оплаты, которое будет отображаться пользователю на странице оформления заказа.',
                    'default' => 'Оплатите при помощи карты легко и быстро.',
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
            if ($this->description) {
                if ($this->testmode) {
                    $this->description .= ' ТЕСТОВЫЙ РЕЖИМ АКТИВИРОВАН. В тестовом режиме вы можете использовать тестовые данные карт, указанные в <a href="#" target="_blank">документации</a>.';
                    $this->description = trim($this->description);
                }
                // описание закидываем в теги <p>
                echo wpautop(wp_kses_post($this->description));
            }

            // я использую функцию echo(), но по сути можете закрыть тег PHP и выводить прямо как HTML
            echo '<fieldset id="wc-' . $this->id . '-cc-form" class="wc-credit-card-form wc-payment-form" style="background:transparent;">';

            // чтобы разработчики плагинов могли сюда что-то добавить, но не обязательно
            do_action('woocommerce_credit_card_form_start', $this->id);

            // I recommend to use inique IDs, because other gateways could already use #ccNo, #expdate, #cvc
            echo '<div class="form-row form-row-wide"><label>Номер карты <span class="required">*</span></label>
                <input id="truemisha_ccNo" type="text" autocomplete="off">
                </div>
                <div class="form-row form-row-first">
                    <label>Срок действия <span class="required">*</span></label>
                    <input id="truemisha_expdate" type="text" autocomplete="off" placeholder="MM / ГГ">
                </div>
                <div class="form-row form-row-last">
                    <label>Код (CVC) <span class="required">*</span></label>
                    <input id="truemisha_cvv" type="password" autocomplete="off" placeholder="CVC">
                </div>
                <div class="clear"></div>';

            // чтобы разработчики плагинов могли сюда что-то добавить, но не обязательно
            do_action('woocommerce_credit_card_form_end', $this->id);

            echo '<div class="clear"></div></fieldset>';

        }

        public function validate_fields()
        {

            // if (empty($_POST['billing_first_name'])) {
            //     wc_add_notice('Имя обязательно для заполнения!', 'error');
            //     return false;
            // }
            return true;

        }

        public function process_payment($order_id)
        {
            //API Keys
            $api = CheckoutSdk::builder()
                ->staticKeys()
                ->environment(Environment::sandbox())
                ->publicKey("pk_sbox_pgomj4fn7birnukblss6pv3goa6")
                ->secretKey("sk_sbox_5vskqyk6hnz3rmqu3unmzk6v3en")
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
            $requestCardSource->name = "VISA";
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
            $request->source = $requestCardSource;
            $request->capture = true;
            $request->reference = "reference";
            $request->amount = 10;
            $request->currency = Currency::$USD;
            $request->customer = $customerRequest;
            $request->sender = $paymentIndividualSender;

            try {
                $response = $api->getPaymentsClient()->requestPayment($request);
                echo "<pre>";
                var_dump($response);
                echo "</pre>";
            } catch (CheckoutApiException $e) {
                $error_details = $e->error_details;
                $http_status_code = isset($e->http_metadata) ? $e->http_metadata->getStatusCode() : null;
            } catch (CheckoutAuthorizationException $e) {
            }

        }

    }
}

add_action('plugins_loaded', 'pf_checkout_com');