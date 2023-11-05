<?php
/**
 * Product Price by Quantity for WooCommerce - Pro - Shortcodes Class
 *
 * @version 3.5.1
 * @since   2.8.0
 *
 * @author  Algoritmika Ltd.
 */

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Alg_WC_Wholesale_Pricing_Pro_Shortcodes' ) ) :

class Alg_WC_Wholesale_Pricing_Pro_Shortcodes {

	/**
	 * Constructor.
	 *
	 * @version 3.0.0
	 * @since   2.8.0
	 */
	function __construct() {
		add_shortcode( 'alg_wc_wholesale_pricing_products_list', array( $this, 'wholesale_pricing_products_list' ) );
		add_shortcode( 'alg_wc_ppq_products_list',               array( $this, 'wholesale_pricing_products_list' ) );
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
	 * wholesale_pricing_products_list.
	 *
	 * E.g.: `[alg_wc_ppq_products_list columns="sku:SKU|name:Name|category:Category|price:Price|levels:from %level_min_qty% pcs.|meta:total_sales:Total sales"]`
	 *
	 * @version 3.5.1
	 * @since   2.6.0
	 *
	 * @see     https://github.com/woocommerce/woocommerce/wiki/wc_get_products-and-WC_Product_Query
	 *
	 * @todo    [!] (dev) `shortcode_atts`: `alg_wc_wholesale_pricing_products_list` to `alg_wc_ppq_products_list`?
	 * @todo    [!] (dev) `transient`: `alg_wc_wholesale_pricing_products_list_shortcode_` to `alg_wc_ppq_products_list_shortcode_`?
	 * @todo    [!] (fix) `$discount_type`: empty?
	 * @todo    [!] (dev) `$discount_type` + `alg_wc_wholesale_pricing_get_discount_type` filter?
	 * @todo    (dev) heading_format: `%level_max_qty%`
	 * @todo    (dev) heading_format: `%level_discount%` -> `%level_discount_value%`?
	 * @todo    (dev) remove `if ( ! $product->get_price() )`?
	 * @todo    (dev) transients: better `$transient_name`?
	 * @todo    (feature) transients: customizable expiration time
	 * @todo    (dev) organize atts properly
	 * @todo    (dev) `add_query_arg( 'quantity' )`: variable products?
	 * @todo    (dev) check if enabled for product
	 * @todo    (dev) variations
	 * @todo    (dev) `if ( ! $product->get_price() ) { ... }`
	 */
	function wholesale_pricing_products_list( $atts ) {

		// Maybe call old deprecated version instead
		if (
			! empty( $atts ) &&
			(
				isset( $atts['heading_format'] ) ||
				isset( $atts['row_sku'] )        ||
				isset( $atts['row_name'] )       ||
				isset( $atts['row_category'] )   ||
				isset( $atts['row_price'] )      ||
				isset( $atts['link_rows'] )      ||
				isset( $atts['custom_columns'] )
			)
		) {
			return $this->wholesale_pricing_products_list_v1( $atts );
		}

		// Shortcode atts
		$atts = shortcode_atts( array(
			'levels'         => false,
			'category_slug'  => false,
			'discount_type'  => false,
			'use_transients' => 'no',
			'limit'          => -1,
			'orderby'        => 'date',
			'order'          => 'DESC',
			'image_size'     => 'woocommerce_thumbnail',
			'columns'        => implode( '|', array(
				'sku'                         . ':' . __( 'SKU', 'wholesale-pricing-woocommerce' ),
				'name'                        . ':' . __( 'Name', 'wholesale-pricing-woocommerce' ),
				'category'                    . ':' . __( 'Category', 'wholesale-pricing-woocommerce' ),
				'price_with_add_to_cart_link' . ':' . __( 'Price', 'wholesale-pricing-woocommerce' ),
				'levels'                      . ':' . sprintf( __( 'from %s pcs.', 'wholesale-pricing-woocommerce' ), '%level_min_qty%' ),
			) ),
		), $atts, 'alg_wc_wholesale_pricing_products_list' );

		// Transients
		if ( 'yes' === $atts['use_transients'] ) {
			$atts['version'] = alg_wc_wholesale_pricing()->version;
			$transient_name  = 'alg_wc_wholesale_pricing_products_list_shortcode_' . md5( serialize( $atts ) );
			if ( $transient = get_transient( $transient_name ) ) {
				return $transient;
			}
		}

		// Get levels data & product query args
		$products_args = array( 'limit' => $atts['limit'], 'orderby' => $atts['orderby'], 'order' => $atts['order'] );
		$products_args = apply_filters( 'alg_wc_ppq_products_list_query_args', $products_args, $atts );
		$price_levels  = array();
		if ( false !== $atts['category_slug'] ) {

			// Get levels data: from category slug
			$products_args['category'] = array( $atts['category_slug'] );
			$term = get_term_by( 'slug', $atts['category_slug'], 'product_cat' );
			if ( $term ) {
				$price_levels = $this->get_core()->get_levels_data_array( false, $term->term_id, 'per_term', 'asc' );
			}

		} elseif ( false !== $atts['levels'] ) {

			// Get levels data: from attribute
			$levels = explode( '|', $atts['levels'] );
			foreach ( $levels as $level ) {
				$level_data = explode( ':', $level );
				if ( 2 == count( $level_data ) ) {
					$price_levels[] = array( 'quantity' => $level_data[0], 'discount' => $level_data[1] );
				}
			}

		}

		// Get discount type
		$discount_type = '';
		if ( false !== $atts['discount_type'] ) {
			$discount_type = $atts['discount_type'];
		}

		// Prepare columns data
		$columns = array_map( 'trim', explode( '|', $atts['columns'] ) );
		foreach ( $columns as &$column ) {
			$column_parts = array_map( 'trim', explode( ':', $column ) );
			if ( 2 === count( $column_parts ) ) {       // e.g. `price:Price`

				$column = array(
					'value' => $column_parts[0],
					'title' => $column_parts[1],
				);

			} elseif ( 3 === count( $column_parts ) ) { // e.g. `meta:total_sales:Total sales`

				$column = array(
					'value' => $column_parts[0],
					'data'  => $column_parts[1],
					'title' => $column_parts[2],
				);

			}
		}

		// Table heading
		$table_data = array();
		foreach ( $columns as $column_data ) {
			if ( 'levels' === $column_data['value'] || 'levels_with_add_to_cart_link' === $column_data['value'] ) {
				for ( $i = 1; $i <= count( $price_levels ); $i++ ) {
					$placeholders = array(
						'%level_min_qty%'  => $price_levels[ ( $i - 1 ) ]['quantity'],
						'%level_discount%' => $price_levels[ ( $i - 1 ) ]['discount'],
						'%level_num%'      => $i,
					);
					$heading[] = str_replace( array_keys( $placeholders ), $placeholders, $column_data['title'] );
				}
			} else {
				$heading[] = $column_data['title'];
			}
		}
		$table_data[] = $heading;

		// Products
		foreach ( wc_get_products( $products_args ) as $product ) {
			if ( ! $product->get_price() ) {
				continue;
			}
			$row = array();
			foreach ( $columns as $column_data ) {
				switch ( $column_data['value'] ) {

					// SKU
					case 'sku':
						$row[] = $product->get_sku();
						break;
					case 'sku_with_add_to_cart_link':
						$row[] = '<a href="' . $product->add_to_cart_url() . '">' . $product->get_sku() . '</a>';
						break;

					// Image
					case 'image':
						$row[] = $product->get_image( $atts['image_size'] );
						break;
					case 'image_with_add_to_cart_link':
						$row[] = '<a href="' . $product->add_to_cart_url() . '">' . $product->get_image( $atts['image_size'] ) . '</a>';
						break;
					case 'image_with_product_link':
						$row[] = '<a href="' . $product->get_permalink() . '">' . $product->get_image( $atts['image_size'] ) . '</a>';
						break;

					// Name
					case 'name':
						$row[] = $product->get_name();
						break;
					case 'name_with_add_to_cart_link':
						$row[] = '<a href="' . $product->add_to_cart_url() . '">' . $product->get_name() . '</a>';
						break;

					// Category
					case 'category':
						$row[] = strip_tags( wc_get_product_category_list( $product->get_id() ) );
						break;
					case 'category_with_add_to_cart_link':
						$row[] = '<a href="' . $product->add_to_cart_url() . '">' . strip_tags( wc_get_product_category_list( $product->get_id() ) ) . '</a>';
						break;

					// Price
					case 'price':
						$row[] = $product->get_price_html();
						break;
					case 'price_with_add_to_cart_link':
						$row[] = '<a href="' . $product->add_to_cart_url() . '">' . $product->get_price_html() . '</a>';
						break;
					case 'price_excl_tax':
						$row[] = wc_price( wc_get_price_excluding_tax( $product ) );
						break;
					case 'price_incl_tax':
						$row[] = wc_price( wc_get_price_including_tax( $product ) );
						break;

					// Levels
					case 'levels':
						foreach ( $price_levels as $price_level ) {
							$row[] = $this->get_core()->shortcodes->get_product_price( $product, $discount_type, $price_level['discount'], 'no', '%new_price_single%' );
						}
						break;
					case 'levels_with_add_to_cart_link':
						foreach ( $price_levels as $price_level ) {
							$row[] = '<a href="' . add_query_arg( 'quantity', $price_level['quantity'], $product->add_to_cart_url() ) . '">' .
								$this->get_core()->shortcodes->get_product_price( $product, $discount_type, $price_level['discount'], 'no', '%new_price_single%' ) . '</a>';
						}
						break;

					// Meta
					case 'meta':
						$row[] = get_post_meta( $product->get_id(), $column_data['data'], true );
						break;
					case 'meta_with_add_to_cart_link':
						$row[] = '<a href="' . $product->add_to_cart_url() . '">' . get_post_meta( $product->get_id(), $column_data['data'], true ) . '</a>';
						break;

					// Custom
					default:
						$row[] = apply_filters( 'alg_wc_ppq_products_list_custom_column', '', $column_data, $product, $atts );

				}
			}
			$table_data[] = apply_filters( 'alg_wc_ppq_products_list_row', $row, $product, $atts );
		}

		// Table HTML
		$result = $this->get_core()->shortcodes->get_table_html( $table_data, array( 'table_heading_type' => 'horizontal', 'table_class' => 'alg_wc_ppq_products_list' ) );

		// Transients
		if ( 'yes' === $atts['use_transients'] ) {
			set_transient( $transient_name, $result, MINUTE_IN_SECONDS * 10 );
		}

		return $result;
	}

	/**
	 * wholesale_pricing_products_list_v1.
	 *
	 * @deprecated 2.6.0
	 *
	 * @version 2.8.1
	 * @since   2.0.0
	 *
	 * @see     https://github.com/woocommerce/woocommerce/wiki/wc_get_products-and-WC_Product_Query
	 *
	 * @todo    [!] (dev) rename `row_sku` to `column_sku`, etc.?
	 * @todo    [!] (fix) `$discount_type`: empty?
	 * @todo    [!] (dev) `$discount_type` + `alg_wc_wholesale_pricing_get_discount_type` filter?
	 * @todo    (dev) heading_format: `%level_max_qty%`
	 * @todo    (dev) heading_format: `%level_discount%` -> `%level_discount_value%`?
	 * @todo    (dev) remove `if ( ! $product->get_price() )`?
	 * @todo    (dev) transients: better `$transient_name`?
	 * @todo    (feature) transients: customizable expiration time
	 * @todo    (dev) organize atts properly
	 * @todo    (dev) `add_query_arg( 'quantity' )`: variable products?
	 * @todo    (dev) check if enabled for product
	 * @todo    (dev) variations
	 * @todo    (dev) `if ( ! $product->get_price() ) { ... }`
	 */
	function wholesale_pricing_products_list_v1( $atts ) {
		// Shortcode atts
		$atts = shortcode_atts( array(
			'heading_format'        => sprintf( __( 'from %s pcs.', 'wholesale-pricing-woocommerce' ), '%level_min_qty%' ),
			'levels'                => false,
			'discount_type'         => false,
			'category_slug'         => false,
			'row_sku'               => __( 'SKU', 'wholesale-pricing-woocommerce' ),
			'row_name'              => __( 'Name', 'wholesale-pricing-woocommerce' ),
			'row_category'          => __( 'Category', 'wholesale-pricing-woocommerce' ),
			'row_price'             => __( 'Price', 'wholesale-pricing-woocommerce' ),
			'link_rows'             => 'price,levels',
			'custom_columns'        => '',
			'use_transients'        => 'no',
		), $atts, 'alg_wc_wholesale_pricing_products_list' );
		// Transients
		if ( 'yes' === $atts['use_transients'] ) {
			$transient_name = 'alg_wc_wholesale_pricing_products_list_shortcode_' . md5( serialize( $atts ) );
			if ( $transient = get_transient( $transient_name ) ) {
				return $transient;
			}
		}
		// Prepare atts
		$products_args = array( 'limit' => -1 );
		$custom_columns = ( '' !== $atts['custom_columns'] ? array_map( 'trim', explode( '|', $atts['custom_columns'] ) ) : false );
		if ( $custom_columns ) {
			$_custom_columns = array();
			foreach ( $custom_columns as $custom_column ) {
				$custom_column_parts = array_map( 'trim', explode( ':', $custom_column ) );
				$_custom_columns[ $custom_column_parts[0] ] = ( isset( $custom_column_parts[1] ) ? $custom_column_parts[1] : $custom_column_parts[0] );
			}
			$custom_columns = $_custom_columns;
		}
		// Get levels data
		$price_levels = array();
		if ( false !== $atts['category_slug'] ) {
			// Get levels data: from category slug
			$products_args['category'] = array( $atts['category_slug'] );
			$term = get_term_by( 'slug', $atts['category_slug'], 'product_cat' );
			if ( $term ) {
				$price_levels = $this->get_core()->get_levels_data_array( false, $term->term_id, 'per_term', 'asc' );
			}
		} elseif ( false !== $atts['levels'] ) {
			// Get levels data: from attribute
			$levels = explode( '|', $atts['levels'] );
			foreach ( $levels as $level ) {
				$level_data = explode( ':', $level );
				if ( 2 == count( $level_data ) ) {
					$price_levels[] = array( 'quantity' => $level_data[0], 'discount' => $level_data[1] );
				}
			}
		}
		// Get discount type
		$discount_type = '';
		if ( false !== $atts['discount_type'] ) {
			$discount_type = $atts['discount_type'];
		}
		// Table heading
		$table_data = array();
		$heading    = array();
		foreach ( array( 'row_sku', 'row_name', 'row_category', 'row_price' ) as $row_att ) {
			if ( '' !== $atts[ $row_att ] ) {
				$heading[] = $atts[ $row_att ];
			}
		}
		for ( $i = 1; $i <= count( $price_levels ); $i++ ) {
			$placeholders = array(
				'%level_min_qty%'  => $price_levels[ ( $i - 1 ) ]['quantity'],
				'%level_discount%' => $price_levels[ ( $i - 1 ) ]['discount'],
				'%level_num%'      => $i,
			);
			$heading[] = str_replace( array_keys( $placeholders ), $placeholders, $atts['heading_format'] );
		}
		if ( $custom_columns ) {
			foreach ( $custom_columns as $custom_column_id => $custom_column_title ) {
				$heading[] = $custom_column_title;
			}
		}
		$table_data[] = $heading;
		// Get products
		$link_rows = array_map( 'trim', explode( ',', $atts['link_rows'] ) );
		foreach ( wc_get_products( $products_args ) as $product ) {
			if ( ! $product->get_price() ) {
				continue;
			}
			$row = array();
			if ( '' !== $atts['row_sku'] ) {
				$product_sku = $product->get_sku();
				$row[] = ( in_array( 'sku', $link_rows ) ? '<a href="' . $product->add_to_cart_url() . '">' . $product_sku . '</a>' : $product_sku );
			}
			if ( '' !== $atts['row_name'] ) {
				$product_name = $product->get_name();
				$row[] = ( in_array( 'name', $link_rows ) ? '<a href="' . $product->add_to_cart_url() . '">' . $product_name . '</a>' : $product_name );
			}
			if ( '' !== $atts['row_category'] ) {
				$product_cats = strip_tags( wc_get_product_category_list( $product->get_id() ) );
				$row[] = ( in_array( 'category', $link_rows ) ? '<a href="' . $product->add_to_cart_url() . '">' . $product_cats . '</a>' : $product_cats );
			}
			if ( '' !== $atts['row_price'] ) {
				$product_price = $product->get_price_html();
				$row[] = ( in_array( 'price', $link_rows ) ? '<a href="' . $product->add_to_cart_url() . '">' . $product_price . '</a>' : $product_price );
			}
			foreach ( $price_levels as $price_level ) {
				$price = $this->get_core()->shortcodes->get_product_price( $product, $discount_type, $price_level['discount'], 'no', '%new_price_single%' );
				$row[] = ( in_array( 'levels', $link_rows ) ? '<a href="' . add_query_arg( 'quantity', $price_level['quantity'], $product->add_to_cart_url() ) . '">' . $price . '</a>' : $price );
			}
			if ( $custom_columns ) {
				foreach ( $custom_columns as $custom_column_id => $custom_column_title ) {
					$row[] = get_post_meta( $product->get_id(), $custom_column_id, true );
				}
			}
			$table_data[] = $row;
		}
		// Get table HTML
		$result = $this->get_core()->shortcodes->get_table_html( $table_data, array( 'table_heading_type' => 'horizontal' ) );
		// Transients
		if ( 'yes' === $atts['use_transients'] ) {
			set_transient( $transient_name, $result, MINUTE_IN_SECONDS * 10 );
		}
		return $result;
	}

}

endif;

return new Alg_WC_Wholesale_Pricing_Pro_Shortcodes();
