<?php
/**
 * My Account Dashboard
 *
 * Shows the first intro screen on the account dashboard.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/dashboard.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 4.4.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>
<div class="info_panel">
	<div class="panel_header">
		<div class="header_text">
		Welcome to the Graming Panel! <br>
		Every time you deposit, Dino Gramy will generously add an <span>extra 10% top up bonus!</span>
		</div>
		<div class="header_btns">
			<div class="btn-black"><a href="/service/usd/">Top Up your Balance</a></div>
			<div class="btn-black"><a href="/my-account/services/">Make a new order</a></div>
		</div>
	</div>
	<div class="panel_bottom">
		<div class="balance">
			<div class="title">Balance</div>
			<div class="content"><?php get_user_balance(); ?></div>
		</div>
			
		<div class="orders">
			<div class="title">Total Orders</div>
			<div class="content"><?php echo get_user_order_count(); ?></div>
		</div>
			
		<div class="bonus">
			<div class="title">Bonus Received</div>
			<div class="content"><?php get_bonus_calc_amount(); ?></div>
		</div>
	</div>
</div>