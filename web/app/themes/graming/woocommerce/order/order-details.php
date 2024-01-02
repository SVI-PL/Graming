<?php
/**
 * Order details
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/order/order-details.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 7.8.0
 */

defined('ABSPATH') || exit;

$order = wc_get_order($order_id); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited

if (!$order) {
	return;
}

$order_items = $order->get_items();
$show_purchase_note = $order->has_status(apply_filters('woocommerce_purchase_note_order_statuses', array('completed', 'processing')));
$item_name = "";
$item_id = "";
$order_num = "";
foreach ($order_items as $item) {
	$item_id = $item["product_id"];
	$item_name = $item["name"];
	$order_num = $item["order_id"];
}
$order = wc_get_order($order_num);
$totals = $order->get_order_item_totals();
?>
<div class="account-order-view">
	<div class="buy_now_acc">
		<div class="back_btn btn-gray">Back</div>
		<?php if (is_user_logged_in()): ?>
			<div class="btn-red"><a href="/service/usd/">Deposit Now</a></div>
		<?php endif; ?>
	</div>
	<div class="account-orders">
		<div class="acc_title">
			<?php echo $item_id == 75 ? "Deposit" : "Order"; ?>
			<span>
				<?php echo " №" . $order_num; ?>
			</span>
			<time datetime="<?php echo esc_attr($order->get_date_created()->date('c')); ?>">
				<?php echo esc_html(wc_format_datetime($order->get_date_created())); ?>
			</time>
		</div>
		<div class="order_bottom">
			<div class="order_status <?php echo esc_html(wc_get_order_status_name($order->get_status())); ?>">
				<?php $status = esc_html(wc_get_order_status_name($order->get_status()));
				if ($status == "On hold") {
					echo "Payment In Process";
				} elseif ($status == "Suspected Fraud") {
					echo "Payment Declined by Your Bank";
				} else {
					echo $status;
				} ?>
			</div>
			<?php if ($status == "On hold"): ?>
				<div class="text_status">Reload this page or track your order on our panel for the latest delivery status.
				</div>
			<?php elseif ($status == "Suspected Fraud"): ?>
				<div class="text_status">Please contact us via email at support@graming.com for further instructions. If
					you've been charged for the order, your bank may have temporarily held the funds, and they will be
					refunded in approximately 2 weeks.
				</div>
			<?php endif; ?>
			<div class="order_summ">
				<div class="text">Order summary</div>
				<div class="price">
					<?php echo $totals["cart_subtotal"]["value"]; ?>
					<?php echo $item_name; ?>
				</div>
				<div class="payment">
					<div class="metod">
						<?php echo $totals["payment_method"]["value"]; ?>
					</div>
					<div class="total">
						<?php echo $totals["order_total"]["value"]; ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>