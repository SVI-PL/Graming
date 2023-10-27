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
	wp_enqueue_script('graming-mask-js', 'https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js', array(), _S_VERSION, true);

}
add_action('wp_enqueue_scripts', 'graming_scripts');

function woocommerce_custom_quantity()
{
	if (is_product()) {
		global $product;
		if ($product->is_type('simple')) {
			$custom_fields = get_field('quantity_options', $product->get_id());
			echo '<div class="discount_blocks">';
			if (!empty($custom_fields)) {
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
function woocommerce_custom_buy_now()
{
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


function checkout_redirect($redirect)
{
	return wc_get_checkout_url();
}
add_filter('woocommerce_add_to_cart_redirect', 'checkout_redirect');

function fields_filter($fields)
{

	// оставляем эти поля
	unset($fields['billing']['billing_first_name']); // имя
	unset($fields['billing']['billing_last_name']); // фамилия
	unset($fields['billing']['billing_phone']); // телефон
	//unset( $fields[ 'billing' ][ 'billing_email' ] ); // емайл

	// удаляем все эти поля
	unset($fields['billing']['billing_company']); // компания
	unset($fields['billing']['billing_country']); // страна
	unset($fields['billing']['billing_address_1']); // адрес 1
	unset($fields['billing']['billing_address_2']); // адрес 2
	unset($fields['billing']['billing_city']); // город
	unset($fields['billing']['billing_state']); // регион, штат
	unset($fields['billing']['billing_postcode']); // почтовый индекс
	unset($fields['order']['order_comments']); // заметки к заказу

	return $fields;

}
add_filter('woocommerce_checkout_fields', 'fields_filter', 25);

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

function save_custom_checkout_field($order_id)
{
	if (!empty($_POST['custom_link'])) {
		update_post_meta($order_id, 'Target Link', sanitize_text_field($_POST['custom_link']));
	}
}
add_action('woocommerce_checkout_update_order_meta', 'save_custom_checkout_field');


function display_custom_checkout_field_in_admin($order)
{
	$custom_link = get_post_meta($order->get_id(), 'Target Link', true);

	if (!empty($custom_link)) {
		echo '<p><strong>' . __('Target Link') . ':</strong> ' . $custom_link . '</p>';
	}
}
add_action('woocommerce_admin_order_data_after_billing_address', 'display_custom_checkout_field_in_admin', 10, 1);

//GET discount price
function price_display_by_qty($quantity, $_product_id)
{
	$PBQ = new Alg_WC_Wholesale_Pricing_Frontend();

	$product = wc_get_product($_product_id);
	$product_id = $PBQ->get_core()->get_product_id($product);
	if ($product_id) {
		// Get placeholders
		$old_price_single = wc_get_price_to_display($product);
		$discount = ($PBQ->get_core()->is_enabled($product_id) ? $PBQ->get_core()->get_discount_by_quantity($quantity, $product_id) : 0);
		$discount_type = $PBQ->get_core()->get_discount_type($product_id, $quantity);
		if (false !== $discount) {
			switch ($discount_type) {
				case 'price_directly':
					$new_price_single = wc_get_price_to_display($product, array('price' => $discount));
					break;
				case 'percent':
					$new_price_single = wc_get_price_to_display($product) * (1 - $discount / 100);
					break;
				default: // 'fixed'
					$new_price_single = wc_get_price_to_display($product, array('price' => ($product->get_price() - $discount)));
					break;
			}
		} else {
			$new_price_single = $old_price_single;
		}
		$placeholders = $PBQ->get_placeholders(
			array(
				'old_price_single' => $old_price_single,
				'new_price_single' => $new_price_single,
				'discount' => $discount,
				'discount_type' => $discount_type,
				'quantity' => $quantity,
				'total_quantity' => false,
				'product' => $product,
			)
		);
		// Handle deprecated placeholders
		$placeholders['%price_single%'] = $placeholders['%old_price_single%'];
		$placeholders['%price%'] = $placeholders['%old_price_total%'];
		$placeholders['%new_price%'] = $placeholders['%new_price_total%'];
		return array($placeholders['%new_price%'], $placeholders['%price%']);
	}
}

//Select product on checkout
function custom_checkout_dropdown($product_id)
{
	$product = wc_get_product($product_id);

	if ($product && $product->is_type('simple')) {
		$quantity_options = get_field('quantity_options', $product_id);

		foreach ($quantity_options as $option) {
			$option_value = $option['quantity'];
			$product_price = price_display_by_qty($option_value, $product->get_id());
			//$add_to_cart_url = wc_get_cart_url() . '?add-to-cart=' . $product_id . '&quantity=' . $option_value; ?>
			<div class="cart_item">
				<div class="product-name">
					<?php echo $product->get_name(); ?>&nbsp;<strong class="product-quantity">×&nbsp;
						<?php echo $option_value; ?>
					</strong>
				</div>
				<div class="product-total">
					<div class="new_price">
						<?php echo $product_price[0]; ?>
					</div>
				</div>
			</div>
			<?php
		}
	}
}

add_filter('woocommerce_add_to_cart_validation', 'clear_cart_before_adding_product', 10, 3);

function clear_cart_before_adding_product($passed, $product_id, $quantity)
{
	if (!$passed) {
		return $passed;
	}
	$product = wc_get_product($product_id);
	$product_type = $product->get_type();

	foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
		$cart_product = $cart_item['data'];
		if ($cart_product->get_type() === $product_type) {
			WC()->cart->remove_cart_item($cart_item_key);
		}
	}

	return $passed;
}

function custom_checkout_fragments($fragments)
{
	ob_start();
	?>
	<div class="total_to_pay">Total to pay
		<div class="total">
			<?php echo WC()->cart->get_cart_total(); ?>
		</div>
	</div>
	<?php

	$fragments['.total_to_pay'] = ob_get_clean();

	ob_start();
	?>
	<div class="add_coupon">
		<div class="coupon_set">
			<?php foreach (WC()->cart->get_coupons() as $code => $coupon): ?>
				<div class="coupon_name">
					<?php wc_cart_totals_coupon_label($coupon); ?>
				</div>
				<div class="coupon_val">
					<?php wc_cart_totals_coupon_html($coupon); ?>
				</div>
			<?php endforeach; ?>
		</div>
		<div class="add_coupon_title">Add a coupon code</div>
		<div class="dropdown_coupon">
			<input type="text" name="coupon_duble" class="coupon_input" value="" placeholder="Enter code">
			<div class="btn_apply">Apply</div>
		</div>
	</div>
	<?php

	$fragments['.add_coupon'] = ob_get_clean();

	return $fragments;
}
add_filter('woocommerce_update_order_review_fragments', 'custom_checkout_fragments');

function create_user_account($order_id)
{
	$order = wc_get_order($order_id);
	$user_email = $order->get_billing_email();

	$user_id = email_exists($user_email);

	if (!$user_id) {
		$username = 'user_' . uniqid();
		$password = wp_generate_password();

		$user_id = wp_create_user($username, $password, $user_email);
		$order->set_customer_id($user_id);
		$order->save();
		$user = new WP_User($user_id);
		$user->set_role('customer');

		$user = get_user_by('id', $user_id);
		wp_set_current_user($user_id, $user->user_login);
		wp_set_auth_cookie($user_id);
		do_action('wp_login', $user->user_login(), $user);
	}
}
add_action('woocommerce_new_order', 'create_user_account');

//Disable the emoji's
function disable_emojis()
{
	remove_action('wp_head', 'print_emoji_detection_script', 7);
	remove_action('admin_print_scripts', 'print_emoji_detection_script');
	remove_action('wp_print_styles', 'print_emoji_styles');
	remove_action('admin_print_styles', 'print_emoji_styles');
	remove_filter('the_content_feed', 'wp_staticize_emoji');
	remove_filter('comment_text_rss', 'wp_staticize_emoji');
	remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
	add_filter('tiny_mce_plugins', 'disable_emojis_tinymce');
	add_filter('wp_resource_hints', 'disable_emojis_remove_dns_prefetch', 10, 2);
}
add_action('init', 'disable_emojis');

//Filter function used to remove the tinymce emoji plugin.
function disable_emojis_tinymce($plugins)
{
	if (is_array($plugins)) {
		return array_diff($plugins, array('wpemoji'));
	} else {
		return array();
	}
}

//Remove emoji CDN hostname from DNS prefetching hints.
function disable_emojis_remove_dns_prefetch($urls, $relation_type)
{
	if ('dns-prefetch' == $relation_type) {
		$emoji_svg_url = apply_filters('emoji_svg_url', 'https://s.w.org/images/core/emoji/2/svg/');
		$urls = array_diff($urls, array($emoji_svg_url));
	}
	return $urls;
}

// Устанавливаем баланс в $10 для новых пользователей при регистрации
// function add_balance_to_database($user_id)
// {
// 	$new_balance = 10.00;
// 	$balance = new Balance();
// 	$balance->add_user_balance($user_id, $new_balance);
// }

// add_action('woocommerce_created_customer', 'add_balance_to_database', 10, 1);

// Increase user balance
function increase_user_balance($order_id)
{

}
add_action('woocommerce_completed', 'increase_user_balance');

function my_custom_order_status_changed($order_id, $from_status, $to_status, $order)
{
	if ($to_status === 'processing') {
		$order = wc_get_order($order_id);
		$user_id = $order->get_customer_id();
		$items = $order->get_items();
		$balance = new Balance();
		$balance_increased = false;

		foreach ($items as $item) {
			$product_id = $item->get_product_id();
			$quantity = $item->get_quantity();

			if ($product_id == 75) {
				$current_balance = $balance->get_user_balance($user_id);
				$balance_increase = $quantity * 1.1;
				$new_balance = $current_balance + $balance_increase;

				$balance->update_user_balance($user_id, $new_balance);
				$balance_increased = true;
			}
		}

		if ($balance_increased) {
            $order->update_status('completed');
        }
	}
}
add_action('woocommerce_order_status_changed', 'my_custom_order_status_changed', 10, 4);

// Get user balance
function get_user_balance()
{
	$user_id = get_current_user_id();
	$balance = new Balance();
	echo "$" . $balance->get_user_balance($user_id);
}

//Get user email
function get_user_email()
{
	$user_info = get_userdata(get_current_user_id());
	$email = $user_info->user_email;
	return $email;
}

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

//User orders count
function get_user_order_count()
{
	$user_id = get_current_user_id();
	$order_count = wc_get_customer_order_count($user_id);

	echo $order_count;
}