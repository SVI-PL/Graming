<?php
/*
Plugin Name: My Balance Payment
Version: 1.0
Author: SVI
Description: Плагин для оплаты с баланса пользователя.
*/

/*Exit if accessed directly*/
if (!defined('ABSPATH')) {
    exit;
}
function my_balance_gateway_class( $gateways ) {
	$gateways[] = 'My_Balance_Payment_Gateway';
	return $gateways;
}
add_filter( 'woocommerce_payment_gateways', 'my_balance_gateway_class' );

function pfb_activation()
{

    class My_Balance_Payment_Gateway extends WC_Payment_Gateway
    {
        public function __construct()
        {
            $this->id = 'my_balance_payment';
            $this->method_title = 'Оплата с баланса';
            $this->method_description = 'Оплата заказа с баланса пользователя';
            $this->supports = array('products');

            $this->init_form_fields();
            $this->init_settings();

            $this->title = $this->get_option('title');
            $this->description = $this->get_option('description');
            add_action('woocommerce_update_options_payment_gateways_' . $this->id, array($this, 'process_admin_options'));
        }

        public function init_form_fields()
        {
            $this->form_fields = array(
                'enabled' => array(
                    'title' => 'Включить/Выключить',
                    'type' => 'checkbox',
                    'label' => 'Включить оплату с баланса',
                    'default' => 'yes',
                ),
                'title' => array(
                    'title' => 'Заголовок',
                    'type' => 'text',
                    'description' => 'Заголовок опции оплаты с баланса на странице чекаута',
                    'default' => 'Оплата с баланса',
                ),
                'description' => array(
                    'title' => 'Описание',
                    'type' => 'textarea',
                    'description' => 'Описание опции оплаты с баланса на странице чекаута',
                    'default' => 'Оплатите заказ с вашего баланса.',
                ),
            );
        }

        public function process_payment($order_id) {
            $user_id = get_current_user_id();
            $order = wc_get_order($order_id);
            $order_amount = $order->get_total();

            $balance_updated = Balance::subtract_user_balance($user_id, $order_amount);
        
            if ($balance_updated) {
                $order->payment_complete();
                $order->update_status('processing');
        
                return array(
                    'result'   => 'success',
                    'redirect' => $this->get_return_url($order),
                );
            } else {
                wc_add_notice('Insufficient balance to complete the order. Please click "Top Up" to make a deposit and proceed.', 'error');
                return array(
                    'result'   => 'error',
                );
            }
        }
        
    }

    function add_my_balance_payment_gateway($methods)
    {
        $methods[] = 'My_Balance_Payment_Gateway';
        return $methods;
    }

    add_filter('woocommerce_payment_gateways', 'add_my_balance_payment_gateway');
}
add_action('plugins_loaded', 'pfb_activation');