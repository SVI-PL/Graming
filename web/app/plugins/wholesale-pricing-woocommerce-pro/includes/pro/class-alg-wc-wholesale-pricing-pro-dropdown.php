<?php
/**
 * Product Price by Quantity for WooCommerce - Pro - Dropdown Class
 *
 * @version 3.4.2
 * @since   2.4.0
 *
 * @author  Algoritmika Ltd.
 */

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Alg_WC_Wholesale_Pricing_Pro_Dropdown' ) ) :

class Alg_WC_Wholesale_Pricing_Pro_Dropdown {

	/**
	 * Constructor.
	 *
	 * @version 2.4.1
	 * @since   2.4.0
	 *
	 * @todo    (dev) `alg_wc_wholesale_pricing_dropdown_class`: maybe `qty` class should be required?
	 * @todo    (dev) server-side qty validation
	 */
	function __construct() {
		add_filter( 'woocommerce_quantity_input_args', array( $this, 'add_product_to_quantity_input_args' ), PHP_INT_MAX, 2 );
		add_filter( 'wc_get_template',                 array( $this, 'replace_quantity_input_template' ),    PHP_INT_MAX, 5 );
		add_filter( 'woocommerce_available_variation', array( $this, 'add_variation_params' ),               PHP_INT_MAX, 3 );
		add_filter( 'wp_footer',                       array( $this, 'add_variation_script' ),               PHP_INT_MAX );
	}

	/**
	 * add_variation_script.
	 *
	 * @version 2.4.2
	 * @since   2.4.1
	 *
	 * @todo    [!] (dev) load on variable product page only
	 * @todo    [!] (dev) move to a JS file
	 * @todo    [!] (dev) check if `variation.alg_wc_wh_pr_select_options` is defined, and not empty?
	 * @todo    (dev) remove `div.alg_wc_wh_pr_quantity`?
	 */
	function add_variation_script() {
		if ( ! is_product() ) {
			return;
		}
		?>
		<script>
			jQuery( document.body ).on( 'show_variation', function( e, variation, purchasable ) {
				jQuery( 'select[name="quantity"]' ).empty().append( variation.alg_wc_wh_pr_select_options ).show();
				jQuery( 'div.alg_wc_wh_pr_quantity' ).show();
				jQuery( 'div.quantity' ).show();
			} );
			jQuery( document.body ).on( 'hide_variation', function( e ) {
				jQuery( 'select[name="quantity"]' ).empty().hide();
				jQuery( 'div.alg_wc_wh_pr_quantity' ).hide();
				jQuery( 'div.quantity' ).hide();
			} );
		</script>
		<?php
	}

	/**
	 * add_variation_params.
	 *
	 * @version 2.4.2
	 * @since   2.4.1
	 *
	 * @todo    (dev) maybe pass `levels_data` instead?
	 * @todo    (dev) `$step`?
	 */
	function add_variation_params( $params, $product, $variation ) {
		$input_value = ( isset( $_POST['quantity'], $_POST['variation_id'] ) && intval( $_POST['variation_id'] ) === $variation->get_id() ? sanitize_text_field( $_POST['quantity'] ) : false );
		$min_value   = ( isset( $params['min_qty'] ) ? $params['min_qty'] : false );
		$max_value   = ( isset( $params['max_qty'] ) ? $params['max_qty'] : false );
		$step        = false;
		$params['alg_wc_wh_pr_select_options'] = $this->get_options( $variation, $input_value, $min_value, $max_value, $step );
		return $params;
	}

	/**
	 * get_options.
	 *
	 * @version 3.4.2
	 * @since   2.4.0
	 *
	 * @todo    [!] (dev) recheck `rounding` (also in "Price Display by Qty", etc.)
	 * @todo    [!] (dev) placeholders: merge with `frontend::ajax_price_display_by_qty()`
	 */
	function get_options( $product, $input_value = false, $min_value = false, $max_value = false, $step = false ) {

		// Check product type
		if ( $product->is_type( array( 'variable' ) ) ) {
			return '';
		}

		// Get product ID
		$product_id = alg_wc_wholesale_pricing()->core->get_product_id( $product );

		// Levels data
		if ( '' === ( $custom_levels = get_option( 'alg_wc_wholesale_pricing_dropdown_custom_values', '' ) ) ) {
			$levels_data = alg_wc_wholesale_pricing()->core->get_levels_data( $product_id, false, 'asc' );
		} else {
			// Custom dropdown values
			$levels_data = array();
			$custom_levels = array_filter( array_map( 'trim', explode( ',', $custom_levels ) ) );
			$custom_levels = apply_filters( 'alg_wc_wholesale_pricing_dropdown_custom_levels', $custom_levels,
				array( 'product' => $product ) );
			foreach ( $custom_levels as $_qty ) {
				if ( is_numeric( $_qty ) ) {
					$levels_data[] = array(
							'quantity' => $_qty,
							'discount' => alg_wc_wholesale_pricing()->core->get_discount_by_quantity( $_qty, $product_id ),
						);
				}
			}
		}

		// Filter levels data
		$levels_data = apply_filters( 'alg_wc_wholesale_pricing_dropdown_levels_data_raw', $levels_data,
			array( 'product' => $product ) );

		// Check min value, max value and step
		if ( 'yes' === get_option( 'alg_wc_wholesale_pricing_dropdown_filter_values', 'no' ) ) {
			if ( ! empty( $min_value ) || ! empty( $max_value ) || ( ! empty( $step ) && $step > 1 ) ) {
				foreach ( $levels_data as $i => $level_data ) {
					if (
						( ! empty( $min_value ) && $level_data['quantity'] < $min_value ) ||
						( ! empty( $max_value ) && $level_data['quantity'] > $max_value ) ||
						( ( ! empty( $step ) && $step > 1 ) && 0 != ( $level_data['quantity'] % $step ) )
					) {
						unset( $levels_data[ $i ] );
					}
				}
			}
		}

		// Input value
		$input_value = apply_filters( 'alg_wc_wholesale_pricing_dropdown_input_value', $input_value,
			array( 'product' => $product, 'levels_data' => $levels_data ) );
		if ( ! empty( $input_value ) && ! in_array( $input_value, array_column( $levels_data, 'quantity' ) ) ) {
			// Add current value
			$levels_data[] = array(
				'quantity' => $input_value,
				'discount' => alg_wc_wholesale_pricing()->core->get_discount_by_quantity( $input_value, $product_id ),
			);
			usort( $levels_data, array( alg_wc_wholesale_pricing()->core, 'sort_levels_data_by_quantity_' . 'asc' ) );
		}

		// Filter final levels data
		$levels_data = apply_filters( 'alg_wc_wholesale_pricing_dropdown_levels_data', $levels_data,
			array( 'product' => $product, 'input_value' => $input_value ) );

		// Options
		$options = '';
		$label_template = get_option( 'alg_wc_wholesale_pricing_dropdown_label_template', '%qty%' );

		foreach ( $levels_data as $level_data ) {

			// Get placeholders for the label
			$old_price_single = wc_get_price_to_display( $product );
			$discount_type    = alg_wc_wholesale_pricing()->core->get_discount_type( $product_id, $level_data['quantity'] );
			if ( false !== $level_data['discount'] ) {
				switch ( $discount_type ) {
					case 'price_directly':
						$new_price_single = wc_get_price_to_display( $product, array( 'price' => $level_data['discount'] ) );
						break;
					case 'percent':
						$new_price_single = wc_get_price_to_display( $product ) * ( 1 - $level_data['discount'] / 100 );
						break;
					default: // 'fixed'
						$new_price_single = wc_get_price_to_display( $product, array( 'price' => ( $product->get_price() - $level_data['discount'] ) ) );
						break;
				}
			} else {
				$new_price_single = $old_price_single;
			}
			$placeholders = alg_wc_wholesale_pricing()->core->frontend->get_placeholders( array(
				'old_price_single' => $old_price_single,
				'new_price_single' => $new_price_single,
				'discount'         => $level_data['discount'],
				'discount_type'    => $discount_type,
				'quantity'         => $level_data['quantity'],
				'total_quantity'   => false,
				'product'          => $product,
			) );

			// Label
			$label = apply_filters( 'alg_wc_wholesale_pricing_dropdown_option_label', str_replace( array_keys( $placeholders ), $placeholders, $label_template ),
				array( 'placeholders' => $placeholders, 'label_template' => $label_template, 'product' => $product, 'levels_data' => $levels_data, 'level_data' => $level_data ) );

			// Style and class
			$style = apply_filters( 'alg_wc_wholesale_pricing_dropdown_option_style', '',
				array( 'placeholders' => $placeholders, 'product' => $product, 'levels_data' => $levels_data, 'level_data' => $level_data ) );
			$class = apply_filters( 'alg_wc_wholesale_pricing_dropdown_option_class', '',
				array( 'placeholders' => $placeholders, 'product' => $product, 'levels_data' => $levels_data, 'level_data' => $level_data ) );
			$style = ( '' !== $style ? ' style="' . $style . '"' : '' );
			$class = ( '' !== $class ? ' class="' . $class . '"' : '' );

			// Option
			$options .= '<option' . $style . $class . ' value="' . $level_data['quantity'] . '"' . selected( $level_data['quantity'], $input_value, false ) . '>' .
					$label .
				'</option>';

		}

		return $options;

	}

	/**
	 * add_product_to_quantity_input_args.
	 *
	 * @version 2.4.1
	 * @since   2.4.0
	 */
	function add_product_to_quantity_input_args( $args, $product ) {
		$args['alg_wc_wh_pr_product'] = wc_get_product( $product->get_id() );
		return $args;
	}

	/**
	 * replace_quantity_input_template.
	 *
	 * @version 2.4.0
	 * @since   2.4.0
	 */
	function replace_quantity_input_template( $located, $template_name, $args, $template_path, $default_path ) {
		return ( 'global/quantity-input.php' === $template_name ? alg_wc_wholesale_pricing()->plugin_path() . '/includes/pro/templates/global/quantity-input.php' : $located );
	}

}

endif;

return new Alg_WC_Wholesale_Pricing_Pro_Dropdown();
