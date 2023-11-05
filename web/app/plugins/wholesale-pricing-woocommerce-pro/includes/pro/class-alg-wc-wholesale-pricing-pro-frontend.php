<?php
/**
 * Product Price by Quantity for WooCommerce - Pro - Frontend Class
 *
 * @version 3.3.0
 * @since   2.8.0
 *
 * @author  Algoritmika Ltd.
 */

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Alg_WC_Wholesale_Pricing_Pro_Frontend' ) ) :

class Alg_WC_Wholesale_Pricing_Pro_Frontend {

	/**
	 * Constructor.
	 *
	 * @version 3.0.0
	 * @since   2.8.0
	 */
	function __construct() {

		// Single product page info
		if ( 'yes' === get_option( 'alg_wc_wholesale_pricing_show_info_on_single_product_page', 'no' ) ) {
			add_action(
					apply_filters( 'alg_wc_wholesale_pricing_info_single_product_page_hook',
						get_option( 'alg_wc_wholesale_pricing_show_info_single_hook', 'woocommerce_single_product_summary' ) ),
					array( $this, 'discount_table_single' ),
					apply_filters( 'alg_wc_wholesale_pricing_info_single_product_page_priority',
						get_option( 'alg_wc_wholesale_pricing_show_info_single_hook_priority', 25 ) )
				);
			add_filter( 'woocommerce_available_variation', array( $this, 'discount_table_single_variation' ), PHP_INT_MAX, 3 );
			if ( 'yes' === get_option( 'alg_wc_wholesale_pricing_info_on_single_product_hide_variable', 'no' ) ) {
				add_action( 'wp_footer', array( $this, 'discount_table_single_variable_script' ) );
			}
		}

		// Shop page
		if ( 'yes' === get_option( 'alg_wc_wholesale_pricing_show_info_loop', 'no' ) ) {
			add_action(
					apply_filters( 'alg_wc_wholesale_pricing_info_loop_hook',
						get_option( 'alg_wc_wholesale_pricing_show_info_loop_hook', 'woocommerce_after_shop_loop_item' ) ),
					array( $this, 'discount_table_loop' ),
					apply_filters( 'alg_wc_wholesale_pricing_info_loop_priority',
						get_option( 'alg_wc_wholesale_pricing_show_info_loop_hook_priority', 9 ) )
				);
		}

		// Cart items: Item subtotal
		if ( 'yes' === get_option( 'alg_wc_wholesale_pricing_show_info_on_cart_subtotal', 'no' ) ) {
			add_filter( 'woocommerce_cart_item_subtotal', array( $this, 'cart_item_subtotal' ), PHP_INT_MAX, 3 );
		}

		// Cart & Checkout totals
		if ( 'yes' === get_option( 'alg_wc_wholesale_pricing_info_cart_totals_enabled', 'no' ) ) {
			$postions = get_option( 'alg_wc_wholesale_pricing_info_cart_totals_positions',
				array( 'woocommerce_cart_totals_before_order_total', 'woocommerce_review_order_before_order_total' ) );
			foreach ( $postions as $position ) {
				add_filter( $position, array( $this, 'cart_totals' ), PHP_INT_MAX );
			}
		}

		// Replace price: Single product page
		if ( 'yes' === get_option( 'alg_wc_wholesale_pricing_replace_price_on_single_enabled', 'no' ) ) {
			add_filter( 'woocommerce_get_price_html', array( $this, 'replace_price_single' ), PHP_INT_MAX, 2 );
		}

		// Replace price: Shop page
		if ( 'yes' === get_option( 'alg_wc_wholesale_pricing_replace_price_on_loop_enabled', 'no' ) ) {
			add_filter( 'woocommerce_get_price_html', array( $this, 'replace_price_loop' ), PHP_INT_MAX, 2 );
		}

	}

	/**
	 * get_core.
	 *
	 * @version 2.8.1
	 * @since   2.8.1
	 */
	function get_core() {
		if ( ! isset( $this->core ) ) {
			$this->core = alg_wc_wholesale_pricing()->core;
		}
		return $this->core;
	}

	/**
	 * replace_price_single.
	 *
	 * @version 2.2.2
	 * @since   2.2.2
	 */
	function replace_price_single( $price_html, $product ) {
		return ( is_product() ? $this->replace_price( $price_html, $product, 'single' ) : $price_html );
	}

	/**
	 * replace_price_loop.
	 *
	 * @version 2.2.2
	 * @since   2.2.2
	 *
	 * @todo    (dev) `! is_product()`?
	 */
	function replace_price_loop( $price_html, $product ) {
		return ( ! is_product() ? $this->replace_price( $price_html, $product, 'loop' ) : $price_html );
	}

	/**
	 * replace_price.
	 *
	 * @version 3.0.0
	 * @since   2.2.2
	 *
	 * @todo    (dev) `false !== strpos( $template, '%product_id%' )`?
	 */
	function replace_price( $price_html, $product, $single_or_loop ) {
		$template = ( 'single' === $single_or_loop ?
			get_option( 'alg_wc_wholesale_pricing_replace_price_on_single_template', '[alg_wc_product_ppq_data field="price" level_num="1" product_id="%product_id%"]' ) :
			get_option( 'alg_wc_wholesale_pricing_replace_price_on_loop_template',   '[alg_wc_product_ppq_data field="price" level_num="1" product_id="%product_id%"]' )
		);
		if ( false !== strpos( $template, '%product_id%' ) ) {
			$template = str_replace( '%product_id%', $product->get_id(), $template );
		}
		$result = do_shortcode( $template );
		return ( '' !== $result ? $result : $price_html );
	}

	/**
	 * cart_totals.
	 *
	 * @version 3.3.0
	 * @since   3.0.0
	 *
	 * @todo    (dev) implement as shortcode?
	 */
	function cart_totals() {

		// Get total cart product price by quantity discount
		$total_discount = 0;
		foreach ( WC()->cart->get_cart() as $cart_item ) {
			if ( isset( $cart_item['alg_wc_wholesale_pricing'] ) ) {
				if ( ( $product_id = $this->get_core()->get_item_product_id( $cart_item ) ) ) {
					$quantity = $this->get_core()->get_total_quantity( WC()->cart, $cart_item );
					if (
						false !== ( $discount = $this->get_core()->get_discount_by_quantity( $quantity, $product_id ) ) &&
						isset( $cart_item['alg_wc_wholesale_pricing_old'], $cart_item['alg_wc_wholesale_pricing'] ) &&
						$cart_item['alg_wc_wholesale_pricing_old'] !== $cart_item['alg_wc_wholesale_pricing']
					) {
						$total_discount += ( $cart_item['alg_wc_wholesale_pricing_old'] - $cart_item['alg_wc_wholesale_pricing'] ) * $cart_item['quantity'];
					}
				}
			}
		}

		// Output
		if ( 0 != $total_discount ) {
			$template = get_option( 'alg_wc_wholesale_pricing_info_cart_totals_template',
				'<tr class="wholesale-pricing-total-discount"><th>Discount</th><td data-title="Discount">%total_cart_discount%</td></tr>' );
			$template = do_shortcode( $template );
			echo str_replace( '%total_cart_discount%', wc_price( $total_discount * -1 ), $template );
		}

	}

	/**
	 * cart_item_subtotal.
	 *
	 * @version 3.3.0
	 * @since   2.0.0
	 */
	function cart_item_subtotal( $price_html, $cart_item, $cart_item_key ) {
		$template = get_option( 'alg_wc_wholesale_pricing_show_info_on_cart_format_subtotal', '<del>%old_price_total%</del> %new_price_total%<br>' .
			sprintf( __( 'You save: %s', 'wholesale-pricing-woocommerce' ), '<span style="color:red">%discount_total%</span>' ) );
		$template = do_shortcode( $template );
		return $this->get_core()->frontend->add_discount_info_to_cart_page( $price_html, $cart_item, $cart_item_key, $template );
	}

	/**
	 * discount_table_single.
	 *
	 * @version 3.0.0
	 * @since   2.0.0
	 *
	 * @todo    (feature) template per product?
	 * @todo    (dev) variable: if min variation == max variation and "per variation" is disabled, we can display table here (i.e. instead of in variation description)
	 */
	function discount_table_single() {
		global $product;
		if ( $product ) {
			$template = ( ! $product->is_type( 'variable' ) ?
				get_option( 'alg_wc_wholesale_pricing_info_on_single_product',          '[alg_wc_product_ppq_table]' ) :
				get_option( 'alg_wc_wholesale_pricing_info_on_single_product_variable', '' ) );
			echo do_shortcode( $template );
		}
	}

	/**
	 * discount_table_loop.
	 *
	 * @version 3.0.0
	 * @since   2.8.0
	 *
	 * @todo    (feature) template per product?
	 */
	function discount_table_loop() {
		global $product;
		if ( $product ) {
			echo do_shortcode( get_option( 'alg_wc_wholesale_pricing_info_loop', '[alg_wc_product_ppq_table]' ) );
		}
	}

	/**
	 * discount_table_single_variation.
	 *
	 * @version 3.0.0
	 * @since   2.0.0
	 *
	 * @todo    (feature) template per product?
	 */
	function discount_table_single_variation( $data, $product, $variation ) {
		$template = get_option( 'alg_wc_wholesale_pricing_info_on_single_product_variation', '[alg_wc_product_ppq_table product_id="%variation_id%"]' );
		$template = str_replace( '%variation_id%', $variation->get_id(), $template );
		$data['variation_description'] .= do_shortcode( $template );
		return $data;
	}

	/**
	 * discount_table_single_variable_script.
	 *
	 * @version 3.0.0
	 * @since   2.2.4
	 *
	 * @todo    [!] (dev) `alg_wc_product_wholesale_pricing_table` to `alg_wc_product_ppq_table`?
	 * @todo    (dev) move to a separate JS file?
	 */
	function discount_table_single_variable_script() {
		?><script>
			jQuery( document ).on( 'show_variation', function() {
				jQuery( '.alg_wc_product_wholesale_pricing_table.alg_wc_whpr_no_product_id' ).hide();
			} );
			jQuery( document ).on( 'hide_variation', function() {
				jQuery( '.alg_wc_product_wholesale_pricing_table.alg_wc_whpr_no_product_id' ).show();
			} );
		</script><?php
	}

}

endif;

return new Alg_WC_Wholesale_Pricing_Pro_Frontend();
