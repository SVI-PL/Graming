<?php

namespace Cryptomus\Woocommerce;

use Cryptomus\Api\Client;
use WC_Payment_Gateway;

final class Gateway extends WC_Payment_Gateway
{
    /**
     * @var string
     */
    public $id = 'cryptomus';
    /**
     * @var bool
     */
    public $has_fields = true;
    /**
     * @var string
     */
    public $title = 'Pay with Cryptomus';
    /**
     * @var string
     */
    public $method_title = 'Cryptomus';
    /**
     * @var string
     */
    public $method_description = "";
    /**
     * @var \Cryptomus\Api\Payment
     */
    public $payment;
    /**
     * @var string
     */
    public $merchant_uuid;
    /**
     * @var int|string
     */
    public $subtract;
    /**
     * @var string
     */
    private $payment_key;

    /**
     * @var string
     */
    private $logo_theme;

    public function __construct()
    {
        $this->title = $this->get_option('method_title') ?: $this->title;
        $this->method_description = "
        <p>1) Account Creation: Visit <a href='https://cryptomus.com/?utm_source=wordpress&utm_campaign=cms-install' target='_blank'>https://cryptomus.com/</a> and register for an account. Ensure to complete all verification and security processes.</p>
        <p>2) Merchant Account Setup: After registering, proceed to create a merchant account. Await moderation completion to receive the 'Active' status.
</p>
        <p>3) Configuration: Input your Merchant ID and API key from your Cryptomus account into the necessary fields, and adjust any additional settings as needed.
For assistance, reach out to support via Telegram at @cryptomussupport.</p>
        ";
        $this->description = $this->get_option('description');
        $this->form_fields = $this->adminFields();
        $this->init_settings();

        $this->payment_key = $this->get_option('payment_key');
        $this->merchant_uuid = $this->get_option('merchant_uuid');
        $this->logo_theme = $this->get_option('logo_theme') ?: 'light';

        $path = str_replace(ABSPATH, '', __DIR__) . "/images/logo_$this->logo_theme.svg";
        $this->icon = esc_url(get_option('cryptomus_method_image')) ?: site_url($path);
        $this->subtract = $this->get_option('subtract') ?: 0;
        $this->payment = Client::payment($this->payment_key, $this->merchant_uuid);

        add_action("woocommerce_update_options_payment_gateways_{$this->id}", array($this, 'process_admin_options'));
    }

    /**
     * @return array
     */
    public function adminFields()
    {
        return [
            'enabled' => [
                'title' => __('Enabled'),
                'type' => 'checkbox',
                'default' => 'no',
                'desc_tip' => true
            ],
            'payment_key' => [
                'title' => 'Payment API-key',
                'type' => 'text'
            ],
            'merchant_uuid' => [
                'title' => 'Merchant UUID',
                'type' => 'text'
            ],
            'method_title' => [
                'title' => 'Method title',
                'type' => 'text',
                'default' => 'Pay with Cryptomus'
            ],
            'description' => [
                'title' => 'Method description',
                'type' => 'text',
                'default' => 'Crypto payment system'
            ],
            'method_image' => [
                'title' => 'Method Image',
                'type' => 'file',
                'desc_tip' => true,
                'description' => 'Upload an image for the payment method',
            ],
            'logo_theme' => [
                'title' => 'Logo Theme',
                'type' => 'select',
                'options' => [
                    'light' => 'Light',
                    'dark' => 'Dark',
                ]
            ],
            'subtract' => [
                'title' => 'How much commission does the client pay (0-100%)',
                'type' => 'number',
                'default' => 0,
            ],
        ];
    }

    /**
     * @param $order_id
     * @return array
     */
    public function process_payment($order_id)
    {
        $order = wc_get_order($order_id);
        $order->update_status(PaymentStatus::WC_STATUS_PENDING);
        $order->save();

        wc_reduce_stock_levels($order_id);
        WC()->cart->empty_cart();

        try {
            $payment = $this->payment->create([
                'amount' => $order->get_total(),
                'currency' => $order->get_currency(),
                'order_id' => (string)$order_id,
                'url_return' => $this->get_return_url($order),
                'url_callback' => get_site_url(null, "wp-json/cryptomus-webhook/$this->merchant_uuid"),
                'is_payment_multiple' => true,
                'lifetime' => 7200,
                'subtract' => $this->subtract,
            ]);

            return ['result' => 'success', 'redirect' => $payment['url']];
        } catch (\Exception $e) {
            $order->update_status(PaymentStatus::WC_STATUS_FAIL);
            wc_increase_stock_levels($order);
            $order->save();
        }

        return ['result' => 'success', 'redirect' => $this->get_return_url($order)];
    }

    public function process_admin_options()
    {
        parent::process_admin_options();

        $uploaded_image = isset($_FILES['woocommerce_cryptomus_method_image']) ? $_FILES['woocommerce_cryptomus_method_image'] : null;

        if ($uploaded_image && isset($uploaded_image['tmp_name']) && !empty($uploaded_image['tmp_name'])) {
            require_once ABSPATH . 'wp-admin/includes/file.php';
            $upload_overrides = array('test_form' => false);
            $movefile = wp_handle_upload($uploaded_image, $upload_overrides);

            if ($movefile && !isset($movefile['error'])) {
                $image_url = $movefile['url'];
                update_option('cryptomus_method_image', $image_url); // Replace 'cryptomus_method_image' with your preferred option name
            }
        }
    }

    public function admin_options()
    {
        $image_url = get_option('cryptomus_method_image'); // Replace with your option name

        echo '<h2>' . esc_html($this->method_title) . '</h2>';
        echo '<div>' . $this->method_description . '</div>';

        if (!empty($image_url)) {
            echo '<h3>' . __('Method Image Preview', 'woocommerce') . '</h3>';
            echo '<img src="' . esc_url($image_url) . '" alt="Method Image" style="max-width: 100px; height: auto;" /><br />';
        }

        echo '<table class="form-table">';
        // Render other settings fields here...
        $this->generate_settings_html();
        echo '</table>';
    }
}
