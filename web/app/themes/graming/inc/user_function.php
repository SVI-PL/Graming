<?php
use Automattic\WooCommerce\Utilities\OrderUtil;
// set balance $0 for new reg
function add_balance_to_database($user_id)
{
	$new_balance = 0;
	$balance = new Balance();
	$balance->add_user_balance($user_id, $new_balance);
}
add_action('woocommerce_created_customer', 'add_balance_to_database', 10, 1);

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

//User orders count
function get_user_order_count()
{
	$user_id = get_current_user_id();
	$order_count = wc_get_customer_order_count($user_id);

	return $order_count;
}

//Add password on registration
function password_in_registration($customer_id)
{
	if (isset($_POST['password']) && !empty($_POST['password'])) {
		$password = wc_clean($_POST['password']);
		update_user_meta($customer_id, 'password', $password);
	}
	$marketing = "No";
	if (isset($_POST["agree"]) && $_POST["agree"] === "on") {
		$marketing = "Yes";
	}
	$user = get_user_by('id', $customer_id);
	$user_id = (string) $user->ID;
	$user_email = $user->user_email;

	$url = 'https://esputnik.com/api/v1/contact';
	$url2 = 'https://esputnik.com/api/v1/event';

	$data = [
		'channels' => [
			[
				'type' => 'email',
				'value' => $user_email,
			]
		],
		'id' => $user_id,
	];
	$data2 = [
		"params" => [
			[
				"name" => "email",
				"value" => $user_email
			],
			[
				"name" => "Password",
				"value" => $password
			],
			[
				"name" => "AutoReg",
				"value" => 'No'
			],
			[
				"name" => "Marketing Checkbox",
				"value" => $marketing
			]
		],
		"eventTypeKey" => 'Registration form'
	];

	$body = json_encode($data);
	$body2 = json_encode($data2);
	$klavio = new KlavioAPI;
	$klavio->post_klavio($url, $body);
	$klavio->post_klavio($url2, $body2);
}
add_action('woocommerce_created_customer', 'password_in_registration');

//Get calc bonus
function get_bonus_calc_amount()
{
	$user_id = get_current_user_id();
	$total_bonuses = 0;

	$customer_orders = wc_get_orders(
		array(
			'customer' => $user_id,
			'status' => 'completed',
			'limit' => -1,
		)
	);

	foreach ($customer_orders as $order_id) {
		$order = wc_get_order($order_id);
		$items = $order->get_items();
		foreach ($items as $item) {
			$product_id = $item->get_product_id();

			if ($product_id == 75) {
				$order_total = $order->get_total();
				$total_bonuses += $order_total;
			}
		}
	}
	$total_bonuses /= 10.0;

	echo "$" . $total_bonuses;
}

//Redirect from cart to home
function custom_cart_redirect_to_home()
{
	if (is_cart()) {
		wp_safe_redirect(home_url());
		exit;
	}
}
add_action('template_redirect', 'custom_cart_redirect_to_home');

//Redirect from shop to home
function custom_shop_redirect_to_home()
{
	if (is_shop()) {
		wp_safe_redirect(home_url());
		exit;
	}
}
add_action('template_redirect', 'custom_shop_redirect_to_home');

//Add reset pass event
function reset_pass_event($user_login, $key)
{
	$user = get_user_by('login', $user_login);
	$user_id = (string) $user->ID;
	$user_email = $user->user_email;
	$reset_url = url() . "?key=" . $key . "&id=" . $user_id;

	$url = 'https://esputnik.com/api/v1/event';

	$data = [
		"params" => [
			[
				"name" => "email",
				"value" => $user_email
			],
			[
				"name" => "RECOVERY LINK",
				"value" => $reset_url
			],
		],
		"eventTypeKey" => 'Reset password'
	];

	$body = json_encode($data);
	$klavio = new KlavioAPI;
	$klavio->post_klavio($url, $body);
}

add_action('retrieve_password_key', 'reset_pass_event', 10, 2);

//Post klavio after login
function user_login_event($user_login, $user)
{
	$user = get_user_by('login', $user_login);
	$user_id = (string) $user->ID;
	$user_email = $user->user_email;

	$url = 'https://esputnik.com/api/v1/event';

	$data = [
		"params" => [
			[
				"name" => "email",
				"value" => $user_email
			],
			[
				"name" => "date",
				"value" => date('Y-m-d H:i:s')
			]
		],
		"eventTypeKey" => 'User login'
	];

	$body = json_encode($data);
	$klavio = new KlavioAPI;
	$klavio->post_klavio($url, $body);
}
add_action('wp_login', 'user_login_event', 10, 2);

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

function wc_customer_bought_product_custom( $customer_email, $user_id, $product_id ) {
	global $wpdb;

	$result = apply_filters( 'woocommerce_pre_customer_bought_product', null, $customer_email, $user_id, $product_id );

	if ( null !== $result ) {
		return $result;
	}

	$transient_name    = 'wc_customer_bought_product_' . md5( $customer_email . $user_id );
	$transient_version = WC_Cache_Helper::get_transient_version( 'orders' );
	$transient_value   = get_transient( $transient_name );

	if ( isset( $transient_value['value'], $transient_value['version'] ) && $transient_value['version'] === $transient_version ) {
		$result = $transient_value['value'];
	} else {
		$customer_data = array( $user_id );

		if ( $user_id ) {
			$user = get_user_by( 'id', $user_id );

			if ( isset( $user->user_email ) ) {
				$customer_data[] = $user->user_email;
			}
		}

		if ( is_email( $customer_email ) ) {
			$customer_data[] = $customer_email;
		}

		$customer_data = array_map( 'esc_sql', array_filter( array_unique( $customer_data ) ) );
		$statuses      = array_map( 'esc_sql', array( 'processing', 'completed', 'on-hold', 'failed', "pending", 'cancelled', 'suspected-fraud') );

		if ( count( $customer_data ) === 0 ) {
			return false;
		}

		if ( OrderUtil::custom_orders_table_usage_is_enabled() ) {
			$statuses = array_map(
				function ( $status ) {
					return "wc-$status";
				},
				$statuses
			);
			$order_table = OrdersTableDataStore::get_orders_table_name();
			$user_id_clause = '';
			if ( $user_id ) {
				$user_id_clause = 'OR o.customer_id = ' . absint( $user_id );
			}
			$sql = "
SELECT im.meta_value FROM $order_table AS o
INNER JOIN {$wpdb->prefix}woocommerce_order_items AS i ON o.id = i.order_id
INNER JOIN {$wpdb->prefix}woocommerce_order_itemmeta AS im ON i.order_item_id = im.order_item_id
WHERE o.status IN ('" . implode( "','", $statuses ) . "')
AND im.meta_key IN ('_product_id', '_variation_id' )
AND im.meta_value != 0
AND ( o.billing_email IN ('" . implode( "','", $customer_data ) . "') $user_id_clause )
";
			$result = $wpdb->get_col( $sql );
		} else {
			$result = $wpdb->get_col(
				"
SELECT im.meta_value FROM {$wpdb->posts} AS p
INNER JOIN {$wpdb->postmeta} AS pm ON p.ID = pm.post_id
INNER JOIN {$wpdb->prefix}woocommerce_order_items AS i ON p.ID = i.order_id
INNER JOIN {$wpdb->prefix}woocommerce_order_itemmeta AS im ON i.order_item_id = im.order_item_id
WHERE p.post_status IN ( 'wc-" . implode( "','wc-", $statuses ) . "' )
AND pm.meta_key IN ( '_billing_email', '_customer_user' )
AND im.meta_key IN ( '_product_id', '_variation_id' )
AND im.meta_value != 0
AND pm.meta_value IN ( '" . implode( "','", $customer_data ) . "' )
		"
			); // WPCS: unprepared SQL ok.
		}
		$result = array_map( 'absint', $result );

		$transient_value = array(
			'version' => $transient_version,
			'value'   => $result,
		);

		set_transient( $transient_name, $transient_value, DAY_IN_SECONDS * 30 );
	}
	return in_array( absint( $product_id ), $result, true );
}