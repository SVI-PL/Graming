<?php
/**
 * Checkout billing information form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-billing.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.6.0
 * @global WC_Checkout $checkout
 */

defined('ABSPATH') || exit;
$user = new WP_User(get_current_user_id());
?>
<div class="woocommerce-billing-fields">
    <div class="input-link"><input type="text" name="custom_link" id="custom_link" placeholder="https://..." value=""></div>
	<div class="input-text"><input type="email" name="billing_email" id="billing_email" placeholder="email@gmail.com" value="<?php if(isset($user)){echo esc_attr($user->user_email);} ?>" autocomplete="email username"></div>
</div>