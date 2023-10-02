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

// function redirect_cart_to_checkout() {
//     // Проверяем, находимся ли мы на странице корзины
//     if ( is_cart() && ! is_wc_endpoint_url( 'order-pay' ) ) {
//         $checkout_url = wc_get_checkout_url();
//         wp_safe_redirect( $checkout_url );
//         exit;
//     }
// }
// add_action( 'template_redirect', 'redirect_cart_to_checkout' );

 
function fields_filter( $fields ) {
 
	// оставляем эти поля
	// unset( $fields[ 'billing' ][ 'billing_first_name' ] ); // имя
	// unset( $fields[ 'billing' ][ 'billing_last_name' ] ); // фамилия
	// unset( $fields[ 'billing' ][ 'billing_phone' ] ); // телефон
	// unset( $fields[ 'billing' ][ 'billing_email' ] ); // емайл
 
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

