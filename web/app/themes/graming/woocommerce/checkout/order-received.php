<?php
/**
 * "Order received" message.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/thankyou.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 8.1.0
 *
 * @var WC_Order|false $order
 */

defined('ABSPATH') || exit;
?>

<div class="woocommerce-notice woocommerce-notice--success woocommerce-thankyou-order-received">
	<?php
	if (get_user_order_count() == 0): ?>
		<h2>Thanks and congrats with your first order on Gramy!</h2>
		<p><span>We have automatically created an account for your convenience</span>, you can set your unique password via
			this link - <a href="/my-account/edit-account/">Click Here</a></p>
	<?php else: ?>
		<h2>Thanks for your order on Gramy!</h2>
	<?php endif; ?>
</div>