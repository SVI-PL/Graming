<?php
/**
 * Product Price by Quantity for WooCommerce - Pro Class
 *
 * @version 3.4.0
 * @since   1.2.0
 *
 * @author  Algoritmika Ltd.
 */

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Alg_WC_Wholesale_Pricing_Pro' ) ) :

class Alg_WC_Wholesale_Pricing_Pro {

	/**
	 * core.
	 *
	 * @since   3.4.0
	 */
	public $core;

	/**
	 * is_enabled_per_term.
	 *
	 * @since   3.4.0
	 */
	public $is_enabled_per_term;

	/**
	 * dropdown.
	 *
	 * @since   3.4.0
	 */
	public $dropdown;

	/**
	 * total_qty.
	 *
	 * @since   3.4.0
	 */
	public $total_qty;

	/**
	 * Constructor.
	 *
	 * @version 2.8.0
	 * @since   1.2.0
	 *
	 * @todo    (dev) "Formula" (i.e. alternative way of setting product price by quantity); include `user_id`, `membership_plan` etc.
	 * @todo    (dev) weight, etc. instead of qty?
	 * @todo    (dev) per term: custom (e.g. "brand")
	 * @todo    (dev) add "per user" options (i.e. vs "per user role")
	 * @todo    (dev) rename the plugin to, e.g., "Price by Quantity for WooCommerce"?
	 */
	function __construct() {

		// Properties
		$this->is_enabled_per_term = array();

		// Hooks
		add_filter( 'alg_wc_wholesale_pricing_settings',                        array( $this, 'settings' ), 10, 3 );
		add_action( 'alg_wc_wholesale_pricing_core_loaded',                     array( $this, 'core_loaded' ) );
		add_action( 'alg_wc_wholesale_pricing_is_enabled_per_term',             array( $this, 'is_enabled_per_term' ), 10, 2 );
		add_action( 'alg_wc_wholesale_pricing_get_product_options_product_ids', array( $this, 'get_product_options_product_ids' ), 10, 2 );

	}

	/**
	 * core_loaded.
	 *
	 * @version 2.8.0
	 * @since   2.0.0
	 */
	function core_loaded( $core ) {
		$this->core = $core;
		if ( 'yes' === get_option( 'alg_wc_wholesale_pricing_enabled', 'yes' ) ) {

			// Shortcodes
			require_once( 'class-alg-wc-wholesale-pricing-pro-shortcodes.php' );

			// Dropdown
			if ( 'yes' === get_option( 'alg_wc_wholesale_pricing_dropdown_enabled', 'no' ) ) {
				$this->dropdown = require_once( 'class-alg-wc-wholesale-pricing-pro-dropdown.php' );
			}

			// Per term settings
			require_once( 'settings/class-alg-wc-wholesale-pricing-settings-per-term.php' );

			// Info
			require_once( 'class-alg-wc-wholesale-pricing-pro-frontend.php' );

			// Total qty
			$this->total_qty = get_option( 'alg_wc_wholesale_pricing_use_total_cart_quantity', 'no' );
			if ( ! in_array( $this->total_qty, array( 'yes', 'no' ) ) ) {
				add_action( 'alg_wc_wholesale_pricing_get_total_quantity', array( $this, 'get_total_quantity' ), 10, 3 );
			}

		}
	}

	/**
	 * get_total_quantity.
	 *
	 * @version 2.3.0
	 * @since   2.3.0
	 */
	function get_total_quantity( $qty, $cart, $item ) {
		$result = 0;
		if ( '_product_cat' === $this->total_qty ) {
			$term_ids = wc_get_product_cat_ids( $item['product_id'] );
		} elseif ( '_product_tag' === $this->total_qty ) {
			$term_ids = wc_get_product_term_ids( $item['product_id'], 'product_tag' );
		}
		foreach ( $cart->get_cart() as $_item ) {
			$do_add = false;
			if ( $_item['product_id'] === $item['product_id'] ) {
				// works for all `$this->total_qty` cases, i.e. `_parent`, `_product_cat`, `_product_tag`
				$do_add = true;
			} elseif ( in_array( $this->total_qty, array( '_product_cat', '_product_tag' ) ) ) {
				$_term_ids = ( '_product_cat' === $this->total_qty ? wc_get_product_cat_ids( $_item['product_id'] ) : wc_get_product_term_ids( $_item['product_id'], 'product_tag' ) );
				$intersect = array_intersect( $term_ids, $_term_ids );
				$do_add    = ! empty( $intersect );
			}
			if ( $do_add ) {
				$result += $_item['quantity'];
			}
		}
		return $result;
	}

	/**
	 * get_product_options_product_ids.
	 *
	 * @version 2.0.0
	 * @since   2.0.0
	 *
	 * @todo    (dev) finish moving to Pro
	 * @todo    (dev) `$this->core->is_children && $product->is_type( 'variable' )`
	 */
	function get_product_options_product_ids( $product_ids, $product ) {
		if ( $this->core->is_children ) {
			$children_ids = $product->get_children();
			if ( ! empty( $children_ids ) ) {
				return $children_ids;
			}
		}
		return $product_ids;
	}

	/**
	 * is_enabled_per_term.
	 *
	 * @version 3.4.0
	 * @since   2.0.0
	 *
	 * @todo    (dev) finish moving to Pro
	 * @todo    (dev) cache `$this->per_product_term_enabled[ $taxonomy ]` option (i.e., `get_option( "alg_wc_wholesale_pricing_per_{$taxonomy}_enabled", 'no' )`)
	 */
	function is_enabled_per_term( $value, $product_id ) {
		if ( isset( $this->is_enabled_per_term[ $product_id ] ) ) {
			return $this->is_enabled_per_term[ $product_id ];
		}
		foreach ( array( 'product_cat', 'product_tag' ) as $taxonomy ) {
			if ( 'yes' === get_option( "alg_wc_wholesale_pricing_per_{$taxonomy}_enabled", 'no' ) ) {
				$terms = ( 0 != ( $parent_id = wp_get_post_parent_id( $product_id ) ) ? get_the_terms( $parent_id, $taxonomy ) : get_the_terms( $product_id, $taxonomy ) );
				if ( $terms && ! is_wp_error( $terms ) ) {
					foreach ( $terms as $term ) {
						if (
							'yes' === get_term_meta( $term->term_id, '_' . 'alg_wc_wholesale_pricing_per_' . 'term' . '_enabled', true ) &&
							$this->core->has_levels( 'per_term', $term->term_id )
						) {
							$this->is_enabled_per_term[ $product_id ] = $term->term_id;
							return $this->is_enabled_per_term[ $product_id ];
						}
					}
				}
			}
		}
		$this->is_enabled_per_term[ $product_id ] = false;
		return $this->is_enabled_per_term[ $product_id ];
	}

	/**
	 * settings.
	 *
	 * @version 2.0.0
	 * @since   1.2.0
	 */
	function settings( $value, $type = '', $args = array() ) {
		return '';
	}

}

endif;

return new Alg_WC_Wholesale_Pricing_Pro();
