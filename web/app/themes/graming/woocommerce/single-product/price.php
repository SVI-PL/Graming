<?php
/**
 * Single Product Price
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/price.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.0.0
 */

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

global $product;

?>
<div class="price_block">
	<p class="<?php echo esc_attr(apply_filters('woocommerce_product_price_class', 'price')); ?>">
		<?php echo get_first_price($product->get_id()); ?>
	</p>
	<div class="payments_img">
		<img src="<?php echo get_template_directory_uri(); ?>/src/images/applapay.svg" alt="">
		<img src="<?php echo get_template_directory_uri(); ?>/src/images/mastersvg.svg" alt="">
		<img src="<?php echo get_template_directory_uri(); ?>/src/images/visa.svg" alt="">
		<img src="<?php echo get_template_directory_uri(); ?>/src/images/american.svg" alt="">
	</div>
</div>