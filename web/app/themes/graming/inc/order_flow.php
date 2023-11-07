<?php

//Redirect from cart to checkout
function checkout_redirect($redirect)
{
	return wc_get_checkout_url();
}
add_filter('woocommerce_add_to_cart_redirect', 'checkout_redirect');

//Save custom field from order
function save_custom_checkout_field($order_id)
{
	if (!empty($_POST['custom_link'])) {
		update_post_meta($order_id, 'Target Link', sanitize_text_field($_POST['custom_link']));
	}
}
add_action('woocommerce_checkout_update_order_meta', 'save_custom_checkout_field');

//display custom field in order
function display_custom_checkout_field_in_admin($order)
{
	$custom_link = get_post_meta($order->get_id(), 'Target Link', true);
	$order_id = get_post_meta($order->get_id(), 'Order id', true);

	if (!empty($custom_link)) {
		echo '<p><strong>' . __('Target Link') . ':</strong> ' . $custom_link . '</p>';
	}
	if (!empty($order_id)) {
		echo '<p><strong>' . __('Order id') . ':</strong> ' . $order_id . '</p>';
	}
}
add_action('woocommerce_admin_order_data_after_billing_address', 'display_custom_checkout_field_in_admin', 10, 1);

//AJAX fragments update
function custom_checkout_fragments($fragments)
{
	ob_start();
	?>
	<div class="user_item">
		<div class="product_select">
			<?php
			foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
				$_product = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
				if ($_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters('woocommerce_checkout_cart_item_visible', true, $cart_item, $cart_item_key)) {
					?>
					<div
						class="<?php echo esc_attr(apply_filters('woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key)); ?>">
						<div class="product-name">
							<?php echo wp_kses_post(apply_filters('woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key)) . '&nbsp;'; ?>
							<?php echo apply_filters('woocommerce_checkout_cart_item_quantity', ' <strong class="product-quantity">' . sprintf('&times;&nbsp;%s', $cart_item['quantity']) . '</strong>', $cart_item, $cart_item_key); ?>
							<?php echo wc_get_formatted_cart_item_data($cart_item); ?>
						</div>
						<div class="product-total">
							<?php echo apply_filters('woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal($_product, $cart_item['quantity']), $cart_item, $cart_item_key); ?>
						</div>
					</div>
					<?php
				}
			}
			?>
		</div>
	</div>
	<?php
	$fragments['.user_item'] = ob_get_clean();

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

//Create account on order
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

//Order status changed to Processing
function my_custom_order_status_changed($order_id, $from_status, $to_status, $order)
{
	if ($to_status === 'processing') {

		//Order setting
		$order = wc_get_order($order_id);
		$link = get_post_meta($order->get_id(), 'Target Link', true);
		$user_id = $order->get_customer_id();
		$items = $order->get_items();
		$balance = new Balance();
		$balance_increased = false;
		$quantity = 0;
		$product_id = 0;

		//Item loop
		foreach ($items as $item) {
			$product_id = $item->get_product_id();
			$quantity += $item->get_quantity();
			break;
		}

		//API setting
		$api_url = get_field('api_endpoint', 'option');
		$api_key = get_field('api_key', 'option');
		$service_id = get_api_service_id($product_id, $quantity);

		//Update user balance
		if ($product_id == 75) {
			$current_balance = $balance->get_user_balance($user_id);
			$balance_increase = $quantity * 1.1;
			$new_balance = $current_balance + $balance_increase;

			$balance->update_user_balance($user_id, $new_balance);
			$balance_increased = true;

			//Order note
			if ($balance_increased) {
				$order->update_status('completed');
				$order->add_order_note('Balance increase');
			}
		}

		//API process
		if ($product_id != 75 && $product_id != 0) {
			if (!empty($service_id['error'])) {
				$order->update_status('cancelled');
				$order->add_order_note('Error in order: ' . $service_id['error']);
				return;
			}
			//Array to API
			$api_data = array(
				'key' => $api_key,
				'action' => 'add',
				'service' => $service_id,
				'link' => $link,
				'quantity' => $quantity
			);

			// POST-request to API
			$response = wp_safe_remote_post($api_url, array('body' => $api_data, ));

			if (!is_wp_error($response)) {
				$response_body = wp_remote_retrieve_body($response);
				$api_response = json_decode($response_body);

				if ($api_response) {
					update_post_meta($order_id, 'Order id', sanitize_text_field($api_response->order));
				}
			} else {
				error_log('API Request Error: ' . $response->get_error_message());
			}

			//Order note
			$order->add_order_note('Order in processing');
		}
	}
}
add_action('woocommerce_order_status_changed', 'my_custom_order_status_changed', 10, 4);

//Get API service ID
function get_api_service_id($product_id, $quantity)
{
	$services = get_field('services', 'option');
	if (!$services) {
		return array(
			'error' => 'No services',
		);
	}

	foreach ($services as $service) {
		$service_id = $service["service"];
		if ($product_id == $service_id) {
			foreach ($service["service_prop"] as $prop) {
				$service_quantity = $prop["service_quantity"];
				if ($quantity == $service_quantity) {
					$api_id = $prop["service_id"];
					return $api_id;
				}
			}
		}
	}
	return array(
		'error' => 'ID not found',
	);
}

//Update order status
function update_order_status($order_id)
{
	$order = wc_get_order($order_id);
	$api_id = get_post_meta($order->get_id(), 'Order id', true);
	if ($api_id) {
		//API setting
		$api_url = get_field('api_endpoint', 'option');
		$api_key = get_field('api_key', 'option');

		//Array to API
		$api_data = array(
			'key' => $api_key,
			'action' => 'status',
			'order' => $api_id,
		);

		// POST-request to API
		$response = wp_safe_remote_post($api_url, array('body' => $api_data, ));

		if (!is_wp_error($response)) {
			$response_body = wp_remote_retrieve_body($response);
			$api_response = json_decode($response_body);

			if ($api_response->status == 'Completed') {
				$order->update_status('completed');
				$order->add_order_note('Order successfully completed');
			}
		} else {
			error_log('API Request Error: ' . $response->get_error_message());
		}
	}
}

//Get Order status 
function get_api_order_status()
{
	$user_id = get_current_user_id();
	$customer_orders = wc_get_orders(
		array(
			'customer' => $user_id,
			'status' => array('wc-processing'),
			'return' => 'ids',
		)
	);
	foreach ($customer_orders as $order_id) {
		update_order_status($order_id);
	}
}

//Ajax add to card upsale product
function add_to_cart_ajax()
{
	if (isset($_POST['product_id']) && isset($_POST['quantity'])) {
		$product_id = intval($_POST['product_id']);
		$quantity = intval($_POST['quantity']);

		WC()->cart->add_to_cart($product_id, $quantity);
		wp_send_json_success();
	} else {
		wp_send_json_error();
	}
}
add_action('wp_ajax_add_to_cart', 'add_to_cart_ajax');
add_action('wp_ajax_nopriv_add_to_cart', 'add_to_cart_ajax');

//Update/Remove upsale product
function update_cart_item_quantity_ajax()
{
	if (isset($_POST['product_id']) && isset($_POST['quantity'])) {
		$product_id = intval($_POST['product_id']);
		$quantity = intval($_POST['quantity']);
		$cart_contests = WC()->cart->get_cart_contents();
		foreach ($cart_contests as $cart_id => $cart_item) {
			if ($cart_item["product_id"] == $product_id) {
				$new_quantity = $cart_item["quantity"] - $quantity;
				if ($new_quantity > 0) {
					WC()->cart->set_quantity($cart_item["key"], $new_quantity, true);
				} else {
					WC()->cart->remove_cart_item($cart_item["key"]);
				}
			}
		}
		wp_send_json_success();
	} else {
		wp_send_json_error();
	}
}

add_action('wp_ajax_update_cart_item_quantity', 'update_cart_item_quantity_ajax');
add_action('wp_ajax_nopriv_update_cart_item_quantity', 'update_cart_item_quantity_ajax');

//Clear cart via Ajax
function clear_cart_via_ajax()
{
	WC()->cart->empty_cart();
	wp_send_json_success();
}
add_action('wp_ajax_clear_cart', 'clear_cart_via_ajax');
add_action('wp_ajax_nopriv_clear_cart', 'clear_cart_via_ajax');