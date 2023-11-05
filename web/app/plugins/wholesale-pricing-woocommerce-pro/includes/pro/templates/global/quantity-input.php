<?php
/**
 * Product quantity inputs - Dropdown
 *
 * @version 3.3.0
 * @since   2.4.0
 *
 * @see     https://github.com/woocommerce/woocommerce/blob/5.2.2/templates/global/quantity-input.php
 *
 * @todo    (dev) fallback to the standard qty input in case if `empty( $select_options )`? NB: won't work for variable products!
 */

defined( 'ABSPATH' ) || exit;

if ( $max_value && $min_value === $max_value ) {
	?>
	<div class="quantity hidden">
		<input type="hidden" id="<?php echo esc_attr( $input_id ); ?>" class="qty" name="<?php echo esc_attr( $input_name ); ?>" value="<?php echo esc_attr( $min_value ); ?>" />
	</div>
	<?php
} else {
	/* translators: %s: Quantity. */
	$label = ! empty( $args['product_name'] ) ? sprintf( esc_html__( '%s quantity', 'woocommerce' ), wp_strip_all_tags( $args['product_name'] ) ) : esc_html__( 'Quantity', 'woocommerce' );
	?>
	<div class="quantity">
		<?php do_action( 'woocommerce_before_quantity_input_field' ); ?>
		<label class="screen-reader-text" for="<?php echo esc_attr( $input_id ); ?>"><?php echo esc_attr( $label ); ?></label>
		<?php
			$product = ( isset( $alg_wc_wh_pr_product ) && is_a( $alg_wc_wh_pr_product, 'WC_Product' ) ? $alg_wc_wh_pr_product : false );
			if ( $product && alg_wc_wholesale_pricing()->core->is_enabled( alg_wc_wholesale_pricing()->core->get_product_id( $product ) ) ) {
				// Dropdown
				$input_value    = ( is_product() ? ( isset( $_POST['quantity'] ) ? sanitize_text_field( $_POST['quantity'] ) : false ) : $input_value );
				$select_options = alg_wc_wholesale_pricing()->pro->dropdown->get_options( $product, $input_value, $min_value, $max_value, $step );
				$select_style   = ( '' === $select_options ? ' display:none;' : '' );
				echo '<div class="alg_wc_wh_pr_quantity">' . do_shortcode( get_option( 'alg_wc_wholesale_pricing_dropdown_before', '' ) );
				?>
				<select
					id="<?php echo esc_attr( $input_id ); ?>"
					class="<?php echo get_option( 'alg_wc_wholesale_pricing_dropdown_class', 'qty' ); ?>"
					style="<?php echo get_option( 'alg_wc_wholesale_pricing_dropdown_style', '' ) . $select_style; ?>"
					name="<?php echo esc_attr( $input_name ); ?>"
					title="<?php echo esc_attr_x( 'Qty', 'Product quantity input tooltip', 'woocommerce' ); ?>" >
						<?php echo $select_options; ?>
				</select>
				<?php
				echo do_shortcode( get_option( 'alg_wc_wholesale_pricing_dropdown_after', '' ) ) . '</div>';
			} else {
				// Default WooCommerce input
				?>
				<input
					type="number"
					id="<?php echo esc_attr( $input_id ); ?>"
					class="<?php echo esc_attr( join( ' ', (array) $classes ) ); ?>"
					step="<?php echo esc_attr( $step ); ?>"
					min="<?php echo esc_attr( $min_value ); ?>"
					max="<?php echo esc_attr( 0 < $max_value ? $max_value : '' ); ?>"
					name="<?php echo esc_attr( $input_name ); ?>"
					value="<?php echo esc_attr( $input_value ); ?>"
					title="<?php echo esc_attr_x( 'Qty', 'Product quantity input tooltip', 'woocommerce' ); ?>"
					size="4"
					placeholder="<?php echo esc_attr( $placeholder ); ?>"
					inputmode="<?php echo esc_attr( $inputmode ); ?>" />
				<?php
			}
		?>
		<?php do_action( 'woocommerce_after_quantity_input_field' ); ?>
	</div>
	<?php
}
