<?php
/**
 * Product Price by Quantity for WooCommerce - Per Term Settings
 *
 * @version 3.0.0
 * @since   2.0.0
 *
 * @author  Algoritmika Ltd.
 */

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Alg_WC_Wholesale_Pricing_Settings_Per_Term' ) ) :

class Alg_WC_Wholesale_Pricing_Settings_Per_Term extends Alg_WC_Wholesale_Pricing_Settings_Per_Item {

	/**
	 * Constructor.
	 *
	 * @version 2.0.0
	 * @since   2.0.0
	 */
	function __construct() {
		if ( 'yes' === get_option( 'alg_wc_wholesale_pricing_per_product_tag_enabled', 'no' ) ) {
			add_action( 'product_tag_edit_form_fields', array( $this, 'product_terms_add_fields' ),  PHP_INT_MAX );
			add_action( 'edit_product_tag',             array( $this, 'product_terms_save_fields' ), PHP_INT_MAX );
		}
		if ( 'yes' === get_option( 'alg_wc_wholesale_pricing_per_product_cat_enabled', 'no' ) ) {
			add_action( 'product_cat_edit_form_fields', array( $this, 'product_terms_add_fields' ),  PHP_INT_MAX );
			add_action( 'edit_product_cat',             array( $this, 'product_terms_save_fields' ), PHP_INT_MAX );
		}
	}

	/**
	 * product_terms_add_fields.
	 *
	 * @version 3.0.0
	 * @since   2.0.0
	 *
	 * @todo    [!] (dev) merge with `Alg_WC_Wholesale_Pricing_Settings_Per_Product::get_options_table()`?
	 * @todo    (dev) `wc_help_tip()`?
	 */
	function product_terms_add_fields( $term ) {
		$html  = '';
		$html .= '<tr class="form-field">' . '<th scope="row" valign="top" colspan="2">' .
			'<h2>' . __( 'Product Price by Quantity', 'wholesale-pricing-woocommerce' ) . '</h2>' . '</th>' . '</tr>';
		foreach ( $this->get_options( 'term', $term->term_id ) as $option ) {
			if ( 'title' === $option['type'] ) {
				$html .= '<tr class="form-field">' . '<th scope="row" valign="top" colspan="2">' . '<h3>' . $option['title'] . '</h3>' . '</th>' . '</tr>';
				continue;
			}
			$value = get_term_meta( $term->term_id, $option['meta_name'], true );
			if ( '' === $value ) {
				$value = $option['default'];
			}
			$css               = ( isset( $option['css'] ) ? ' style="' . $option['css'] . '"' : '' );
			$title             = ( isset( $option['title'] ) ? $option['title'] : '' );
			$custom_attributes = ( isset( $option['custom_attributes'] ) ? ' ' . $option['custom_attributes'] : '' );
			$tooltip           = ( isset( $option['tooltip'] ) ? '<p class="description">' . $option['tooltip'] . '</p>' : '' );
			if ( 'price' === $option['type'] ) {
				$option['type'] = 'number';
				$custom_attributes .= ' step="0.0001"';
			}
			$html .= '<tr class="form-field">' . '<th scope="row" valign="top"><label for="' . $option['meta_name'] . '">' . $title . '</label></th>' . '<td>';
			switch ( $option['type'] ) {
				case 'select':
					$options = '';
					foreach ( $option['options'] as $select_option_key => $select_option_value ) {
						$options .= '<option value="' . $select_option_key . '" ' . selected( $value, $select_option_key, false ) . '>' . $select_option_value . '</option>';
					}
					$html .= '<select' . $custom_attributes . $css . ' id="' . $option['meta_name'] . '" name="' . $option['meta_name'] . '">' . $options . '</select>';
					break;
				default: // 'text' etc.
					$html .= '<input' . $custom_attributes . $css . ' type="' . $option['type'] . '" name="' . $option['meta_name'] . '" id="' . $option['meta_name'] . '" value="' . $value . '">';
			}
			$html .= $tooltip . '</td>' . '</tr>';
		}
		$html .= '<input type="hidden" name="alg_wc_wholesale_pricing_edit_terms" value="1">';
		echo $html;
	}

	/**
	 * product_terms_save_fields.
	 *
	 * @version 2.0.0
	 * @since   2.0.0
	 *
	 * @todo    [!] (dev) merge with `Alg_WC_Wholesale_Pricing_Settings_Per_Product::save_options()`?
	 */
	function product_terms_save_fields( $term_id ) {
		if ( isset( $_POST['alg_wc_wholesale_pricing_edit_terms'] ) ) {
			foreach ( $this->get_options( 'term', $term_id ) as $option ) {
				if ( ! empty( $option['meta_name'] ) ) {
					update_term_meta( $term_id, $option['meta_name'], ( isset( $_POST[ $option['meta_name'] ] ) ? sanitize_text_field( $_POST[ $option['meta_name'] ] ) : $option['default'] ) );
				}
			}
		}
	}

}

endif;

return new Alg_WC_Wholesale_Pricing_Settings_Per_Term();
