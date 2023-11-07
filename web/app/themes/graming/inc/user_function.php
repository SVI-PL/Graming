<?php
// Устанавливаем баланс в $10 для новых пользователей при регистрации
function add_balance_to_database($user_id)
{
    // $new_balance = 10.00;
    // $balance = new Balance();
    // $balance->add_user_balance($user_id, $new_balance);
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
function password_in_registration($customer_id) {
    if (isset($_POST['password']) && !empty($_POST['password'])) {
        $password = wc_clean($_POST['password']);
        update_user_meta($customer_id, 'password', $password);
    }
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
function custom_cart_redirect_to_home() {
    if (is_cart()) {
        wp_safe_redirect(home_url());
        exit;
    }
}
add_action('template_redirect', 'custom_cart_redirect_to_home');

//Redirect from shop to home
function custom_shop_redirect_to_home() {
    if (is_shop()) {
        wp_safe_redirect(home_url());
        exit;
    }
}
add_action('template_redirect', 'custom_shop_redirect_to_home');
