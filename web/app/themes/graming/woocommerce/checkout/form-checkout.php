<?php
/**
 * Checkout Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-checkout.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.5.0
 */

if (!defined('ABSPATH')) {
	exit;
}

do_action('woocommerce_before_checkout_form', $checkout);
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
?>
<div class="checkout_block">
	<form name="checkout" method="post" class="checkout woocommerce-checkout"
		action="<?php echo esc_url(wc_get_checkout_url()); ?>" enctype="multipart/form-data">
		<?php do_action('woocommerce_checkout_billing'); ?>
		<?php do_action('woocommerce_checkout_order_review'); ?>
		<div class="additiona_payment" <?php if ($deposite) {
			echo 'style="display:none"';
		} ?>>
			<!-- <div class="user_info">
						<div class="user_img">
							<img src="<?php //echo get_template_directory_uri() . '/src/images/user_img.png' ?>" alt="">
						</div>
						<div class="user_right">
							<div class="user_name">@partymaschine</div>
							<div class="change_user">Change username</div>
						</div>
					</div> -->
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
			<div class="total_to_pay">Total to pay
				<div class="total">
					<?php wc_cart_totals_order_total_html(); ?>
				</div>
			</div>
			<div class="additional_items">
				<?php
				$_product = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
				$product_id = $_product->get_id();
				$p_product = wc_get_product($product_id);
				$upsell_ids = $p_product->get_upsell_ids();
				foreach ($upsell_ids as $idx  => $upsell_id) {
					echo upsale_checkout($upsell_id);
				}
				?>
			</div>
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
			<div class="additional_info">
				<ul>
					<li><span>High quality</span> followers</li>
					<li><span>No password</span> required</li>
					<li><span>Fast Delivery</span>, up to 10 mins</li>
					<li><span>24/7</span> support</li>
				</ul>
			</div>
		</div>
</div>
</form>
</div>