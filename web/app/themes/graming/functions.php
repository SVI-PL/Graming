<?php
/**
 * Graming functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Graming
 */

if (!defined('_S_VERSION')) {
	define('_S_VERSION', '1.0.0');
}

// Sets up theme defaults and registers support for various WordPress features.
function graming_setup()
{
	add_theme_support('title-tag');
	//Add menu
	register_nav_menus(
		array(
			'menu-1' => esc_html__('Primary', 'graming'),
		)
	);

	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);
	add_theme_support('woocommerce');
}
add_action('after_setup_theme', 'graming_setup');


// Register widget area.
function graming_widgets_init()
{
	register_sidebar(
		array(
			'name' => esc_html__('Sidebar', 'graming'),
			'id' => 'sidebar-1',
			'description' => esc_html__('Add widgets here.', 'graming'),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget' => '</section>',
			'before_title' => '<h2 class="widget-title">',
			'after_title' => '</h2>',
		)
	);
}
add_action('widgets_init', 'graming_widgets_init');

/**
 * Enqueue scripts and styles.
 */
function graming_scripts()
{
	wp_enqueue_style('graming-style', get_stylesheet_uri(), array(), _S_VERSION);
	wp_enqueue_style('graming-main-style', get_template_directory_uri() . '/dist/main.css', array(), _S_VERSION);
	wp_enqueue_style('graming-slick-style', get_template_directory_uri() . '/assets/slick/slick.css', array(), _S_VERSION);

	wp_enqueue_script("jquery");
	wp_enqueue_script('graming-main-js', get_template_directory_uri() . '/dist/main.js', array(), _S_VERSION, true);
	wp_enqueue_script('graming-slick-js', get_template_directory_uri() . '/assets/slick/slick.js', array(), _S_VERSION, true);
}
add_action('wp_enqueue_scripts', 'graming_scripts');

function woocommerce_custom_quantity()
{
	if (is_product()) {
		global $product;
		if ($product->is_type('simple')) {
			$custom_fields = get_field('quantity_options', $product->get_id());
			echo '<div class="discount_blocks">';
			if ($custom_fields) {
				foreach ($custom_fields as $field) {
					$quantity = $field['quantity'];
					$discount = $field['discount'];
					echo '<div class="discount_block">
					<div class="product_quantity">' . $quantity . '</div>
					<div class="product_discount">' . $discount . ' off</div>
					</div>';
				}
			}
			echo '</div>';
		}
	}
}
function woocommerce_custom_buy_now(){
	global $product;
	echo '<div class="custom_buy btn-red"><p class="price">' . $product->get_price_html() . '</p><span>&nbsp;- buy now</span></div>';
}

// Удаляем вызываемое по умолчанию событие
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 10);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40);

//// Добавляем новое событие, меняя приоритет
add_action('woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 10);
add_action('woocommerce_single_product_summary', 'woocommerce_custom_quantity', 10);
add_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 20);
add_action('woocommerce_single_product_summary', 'woocommerce_custom_buy_now', 30);

 
function checkout_redirect( $redirect ) {
	return wc_get_checkout_url();
}
add_filter( 'woocommerce_add_to_cart_redirect', 'checkout_redirect' );
 
function fields_filter( $fields ) {
 
	// оставляем эти поля
	unset( $fields[ 'billing' ][ 'billing_first_name' ] ); // имя
	unset( $fields[ 'billing' ][ 'billing_last_name' ] ); // фамилия
	unset( $fields[ 'billing' ][ 'billing_phone' ] ); // телефон
	//unset( $fields[ 'billing' ][ 'billing_email' ] ); // емайл
 
	// удаляем все эти поля
	unset( $fields[ 'billing' ][ 'billing_company' ] ); // компания
	unset( $fields[ 'billing' ][ 'billing_country' ] ); // страна
	unset( $fields[ 'billing' ][ 'billing_address_1' ] ); // адрес 1
	unset( $fields[ 'billing' ][ 'billing_address_2' ] ); // адрес 2
	unset( $fields[ 'billing' ][ 'billing_city' ] ); // город
	unset( $fields[ 'billing' ][ 'billing_state' ] ); // регион, штат
	unset( $fields[ 'billing' ][ 'billing_postcode' ] ); // почтовый индекс
	unset( $fields[ 'order' ][ 'order_comments' ] ); // заметки к заказу
 
	return $fields;
 
}
add_filter( 'woocommerce_checkout_fields', 'fields_filter', 25 );

// function custom_woocommerce_checkout_remove_item( $product_name, $cart_item, $cart_item_key ) {
//     if ( is_checkout() ) {
//         $_product = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
//         $product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );
 
//         $remove_link = apply_filters( 'woocommerce_cart_item_remove_link', sprintf(
//             '<a href="%s" class="remove" aria-label="%s" data-product_id="%s" data-product_sku="%s">×</a>',
//             esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
//             __( 'Remove this item', 'woocommerce' ),
//             esc_attr( $product_id ),
//             esc_attr( $_product->get_sku() )
//         ), $cart_item_key );
 
//         return '<span>' . $remove_link . '</span> <span>' . $product_name . '</span>';
//     }
 
//     return $product_name;
// }
// add_filter( 'woocommerce_cart_item_name', 'custom_woocommerce_checkout_remove_item', 10, 3 );




function save_custom_checkout_field($order_id) {
    if (!empty($_POST['custom_link'])) {
        update_post_meta($order_id, 'Target Link', sanitize_text_field($_POST['custom_link']));
    }
}
add_action('woocommerce_checkout_update_order_meta', 'save_custom_checkout_field');


function display_custom_checkout_field_in_admin($order) {
    $custom_link = get_post_meta($order->get_id(), 'Target Link', true);
    
    if (!empty($custom_link)) {
        echo '<p><strong>' . __('Target Link') . ':</strong> ' . $custom_link . '</p>';
    }
}
add_action('woocommerce_admin_order_data_after_billing_address', 'display_custom_checkout_field_in_admin', 10, 1);