<?php
/**
 * Checkout Payment Section
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/payment.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 8.1.0
 */

defined('ABSPATH') || exit;

if (!wp_doing_ajax()) {
	do_action('woocommerce_review_order_before_payment');
}
?>
<?php
$deposite = "";
foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
	$_product = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
	$product_id = $_product->get_id();
	if ($product_id == 75) {
		$deposite = true;
	}
}

$cart_total = WC()->cart->get_total();
?>
<div id="payment" class="woocommerce-checkout-payment">
	<div class="payment_title">
		<?php if (!$deposite): ?>Checkout
		<?php else: ?>Deposit
		<?php endif; ?>
	</div>
	<div class="false_checkout">
		<?php if (!$deposite): ?>
			<?php if (is_user_logged_in()): ?>
				<div class="balance_pay">
					<div class="pay_title">Pay from balance</div>
					<div class="account_balance">
						Account balance:&nbsp;<span>
							<?php get_user_balance(); ?>
						</span>
					</div>
					<div class="pay_block">
						<div class="pay_btn btn-red balance">
							<?php wc_cart_totals_order_total_html(); ?>&nbsp;- Pay from balance
						</div>
						<div class="btn-gray top_up_btn"><a href="/service/usd/">Top up</a></div>
					</div>
				</div>
			<?php endif; ?>
		<?php else: ?>
			<div class="deposite_info">
				<div class="total_to_pay">Total to pay &nbsp;<span>
						<?php wc_cart_totals_order_total_html(); ?>
					</span></div>
				<div class="total_resive">Total to recieve
					<div class="bonus_total">
						<?php echo $cart_total; ?>
					</div>
					<div class="top_up_bonus">10% Top up bonus</div>
				</div>
			</div>
		<?php endif; ?>
		<div class="apple_pay">
			<div class="pay_title">Pay with Apple Pay</div>
			<div class="btn-apple"></div>
		</div>
		<!-- <div class="google_pay">
			<div class="pay_title">Pay with Google Pay</div>
			<div class="btn-google"></div>
		</div> -->
		<div class="card_pay">
			<div class="pay_title">Pay with credit / debit card <div class="payments_img">
					<img src="<?php echo get_template_directory_uri(); ?>/src/images/applapay.svg" alt="">
					<img src="<?php echo get_template_directory_uri(); ?>/src/images/mastersvg.svg" alt="">
					<img src="<?php echo get_template_directory_uri(); ?>/src/images/visa.svg" alt="">
					<img src="<?php echo get_template_directory_uri(); ?>/src/images/american.svg" alt="">
				</div>
			</div>
			<div class="card_form">
				<div class="form_input form_name">
					<input type="text" class="form-control" name="card_name" id="card_name"
						placeholder="Cardholder name">
				</div>
				<div class="form_input form_number">
					<input type="text" class="form-control" pattern="[0-9]*" name="cardnumber" id="card_number"
						placeholder="0000 0000 0000 0000">
				</div>
				<div class="form_input form_my">
					<input type="number" class="form-control" name="card_month" id="card_month" placeholder="MM"
						maxlength="2"
						oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">
					<div class="sep"></div>
					<input type="number" class="form-control" name="card_year" id="card_year" placeholder="YY"
						maxlength="2"
						oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">
				</div>
				<div class="form_input form_cv">
					<input type="number" class="form-control" name="card_cvv" id="card_cvv" placeholder="CVV"
						maxlength="3"
						oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">
				</div>
				<div class="form_input form_zip">
					<?php
					$fields = $checkout->get_checkout_fields('billing');
					foreach ($fields as $key => $field) {
						if ($field["label"] == "Email address") {
							break;
						}
						woocommerce_form_field($key, $field, $checkout->get_value($key));
					}
					?>
				</div>
				<div class="pay_btn btn-red">

					<?php wc_cart_totals_order_total_html(); ?>&nbsp;- pay with card
				</div>
			</div>
		</div>

		<div class="additional_info_pay">
			<p>By completing your order, you agree to the terms of services and
				privacy policy</p>
			<p>All prices are in USD. If you're paying with a different currency, the billed amount may vary due to
				exchange rates and potential additional fees.</p>
		</div>
	</div>
	<div class="real_checkout" style="display:none">
		<?php if (WC()->cart->needs_payment()): ?>
			<ul class="wc_payment_methods payment_methods methods">
				<?php
				if (!empty($available_gateways)) {
					foreach ($available_gateways as $gateway) {
						wc_get_template('checkout/payment-method.php', array('gateway' => $gateway));
					}
				} else {
					echo '<li>';
					wc_print_notice(apply_filters('woocommerce_no_available_payment_methods_message', WC()->customer->get_billing_country() ? esc_html__('Sorry, it seems that there are no available payment methods. Please contact us if you require assistance or wish to make alternate arrangements.', 'woocommerce') : esc_html__('Please fill in your details above to see available payment methods.', 'woocommerce')), 'notice'); // phpcs:ignore WooCommerce.Commenting.CommentHooks.MissingHookComment
					echo '</li>';
				}
				?>
			</ul>
		<?php endif; ?>
		<div class="form-row place-order">
			<noscript>
				<?php
				/* translators: $1 and $2 opening and closing emphasis tags respectively */
				printf(esc_html__('Since your browser does not support JavaScript, or it is disabled, please ensure you click the %1$sUpdate Totals%2$s button before placing your order. You may be charged more than the amount stated above if you fail to do so.', 'woocommerce'), '<em>', '</em>');
				?>
				<br /><button type="submit"
					class="button alt<?php echo esc_attr(wc_wp_theme_get_element_class_name('button') ? ' ' . wc_wp_theme_get_element_class_name('button') : ''); ?>"
					name="woocommerce_checkout_update_totals"
					value="<?php esc_attr_e('Update totals', 'woocommerce'); ?>">
					<?php esc_html_e('Update totals', 'woocommerce'); ?>
				</button>
			</noscript>

			<?php wc_get_template('checkout/terms.php'); ?>

			<?php do_action('woocommerce_review_order_before_submit'); ?>

			<?php echo apply_filters('woocommerce_order_button_html', '<button type="submit" class="button alt' . esc_attr(wc_wp_theme_get_element_class_name('button') ? ' ' . wc_wp_theme_get_element_class_name('button') : '') . '" name="woocommerce_checkout_place_order" id="place_order" value="' . esc_attr($order_button_text) . '" data-value="' . esc_attr($order_button_text) . '">' . esc_html($order_button_text) . '</button>'); // @codingStandardsIgnoreLine ?>

			<?php do_action('woocommerce_review_order_after_submit'); ?>

			<?php wp_nonce_field('woocommerce-process_checkout', 'woocommerce-process-checkout-nonce'); ?>
		</div>
	</div>
</div>

<?php
if (!wp_doing_ajax()) {
	do_action('woocommerce_review_order_after_payment');
}