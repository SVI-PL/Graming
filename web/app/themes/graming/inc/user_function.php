<?php
// Устанавливаем баланс в $0 для новых пользователей при регистрации
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

	echo $order_count;
}

//Add passwors on registration
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
	$user_id = $user->ID;
	$user_email = $user->user_email;

	$url = 'https://a.klaviyo.com/api/events/';
	$data = [
		'data' => [
			'type' => 'event',
			'attributes' => [
				'profile' => [
					'data' => [
						'type' => 'profile',
						'attributes' => [
							'email' => $user_email,
							'external_id' => $user_id,
							'properties' => [
								'Password' => $password,
								'AutoReg' => 'No',
								'Marketing Checkbox' => 'No',
							],
						],

					],
				],

				'metric' => [
					'data' => [
						'type' => 'metric',
						'attributes' => [
							'name' => 'Registration form',
						],
					],
				],
				'properties' => [
				],
			],
		],
	];
	$body = json_encode($data);
	$klavio = new KlavioAPI;
	$klavio->post_klavio($url, $body);

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
	$user_id = $user->ID;
	$user_email = $user->user_email;
	$reset_url = url() . "?key=" . $key . "&id=" . $user_id;

	$url = 'https://a.klaviyo.com/api/events/';
	$data = [
		'data' => [
			'type' => 'event',
			'attributes' => [
				'profile' => [
					'data' => [
						'type' => 'profile',
						'attributes' => [
							'email' => $user_email,
							'external_id' => $user_id,
							'properties' => [
								'RECOVERY LINK' => $reset_url,
							],
						],

					],
				],

				'metric' => [
					'data' => [
						'type' => 'metric',
						'attributes' => [
							'name' => 'Reset password',
						],
					],
				],
				'properties' => [
					'RECOVERY LINK' => $reset_url,
				],
			],
		],
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
	$user_id = $user->ID;
	$user_email = $user->user_email;

	$url = 'https://a.klaviyo.com/api/events/';
	$data = [
		'data' => [
			'type' => 'event',
			'attributes' => [
				'profile' => [
					'data' => [
						'type' => 'profile',
						'attributes' => [
							'email' => $user_email,
							'external_id' => $user_id,
						],

					],
				],

				'metric' => [
					'data' => [
						'type' => 'metric',
						'attributes' => [
							'name' => 'User login',
						],
					],
				],
				'properties' => [
					'date' => date('Y-m-d H:i:s'),
				],
			],
		],
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

