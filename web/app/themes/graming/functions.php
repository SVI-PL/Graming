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

require_once('inc/user_function.php');
require_once('inc/balance_class.php');
require_once('inc/order_flow.php');
require_once('inc/remove_unset.php');
require_once('inc/product_func.php');


// Sets up theme defaults and registers support for various WordPress features.
function graming_setup()
{
	add_theme_support('title-tag');
	//Add menu
	register_nav_menus(
		array(
			'menu-1' => esc_html__('Header menu', 'graming'),
			'menu-2' => esc_html__('Header mobile', 'graming'),
			'menu-3' => esc_html__('Header additional', 'graming'),
			'menu-5' => esc_html__('Footer Quick Link', 'graming'),
			'menu-6' => esc_html__('Footer Privacy And Terms', 'graming'),
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
	wp_enqueue_script('graming-mask-js', 'https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js', array(), _S_VERSION, true);

}
add_action('wp_enqueue_scripts', 'graming_scripts');

//My account menu
function custom_wc_account_menu_items($items)
{
	$items["dashboard"] = "Panel";
	$items["services"] = "Services";
	$items["support"] = "Support";
	$items["deposit"] = "Deposit History";
	$items["orders"] = "Orders History";
	$items["edit-account"] = "Account Settings";
	$items["payment-methods"] = "Billing";
	$items["top_up"] = "Top Up Now";

	unset($items["downloads"]);
	unset($items["edit-address"]);
	unset($items["customer-logout"]);

	$new_order = array(
		"dashboard" => $items["dashboard"],
		"services" => $items["services"],
		"support" => $items["support"],
		"deposit" => $items["deposit"],
		"orders" => $items["orders"],
		"edit-account" => $items["edit-account"],
		"payment-methods" => $items["payment-methods"],
		"top_up" => $items["top_up"],
	);
	return $new_order;
}

add_filter('woocommerce_account_menu_items', 'custom_wc_account_menu_items');
function customs_add_endpoint()
{
	add_rewrite_endpoint('services', EP_ROOT | EP_PAGES);
	add_rewrite_endpoint('deposit', EP_ROOT | EP_PAGES);
	add_rewrite_endpoint('support', EP_ROOT | EP_PAGES);
}
add_action('init', 'customs_add_endpoint');
function custom_services_query_vars($vars)
{
	$vars[] = 'services';
	$vars[] = 'deposit';
	$vars[] = 'support';

	return $vars;
}
add_filter('woocommerce_get_query_vars', 'custom_services_query_vars');
function services_endpoint_content()
{
	get_template_part('template-parts/services');
}
add_action('woocommerce_account_services_endpoint', 'services_endpoint_content');

function deposit_endpoint_content()
{
	get_template_part('template-parts/deposite');
}
add_action('woocommerce_account_deposit_endpoint', 'deposit_endpoint_content');
function support_endpoint_content()
{
	get_template_part('template-parts/support');
}
add_action('woocommerce_account_support_endpoint', 'support_endpoint_content');

function custom_top_up_endpoint_url($url, $endpoint, $value)
{
	if ($endpoint === 'top_up') {
		$custom_url = '/service/usd/';
		return $custom_url;
	}

	return $url;
}

add_filter('woocommerce_get_endpoint_url', 'custom_top_up_endpoint_url', 10, 3);

//Add option page
if (function_exists('acf_add_options_page')) {
	acf_add_options_page();
}

//Password req
function uawp_woocommerce_password( $strength ) {
    return 1;
}
add_filter( 'woocommerce_min_password_strength', 'uawp_woocommerce_password' );

