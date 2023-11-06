<?php
//GET discount price
function price_display_by_qty($quantity, $_product_id)
{
	$PBQ = new Alg_WC_Wholesale_Pricing_Frontend();

	$product = wc_get_product($_product_id);
	$product_id = $PBQ->get_core()->get_product_id($product);
	if ($product_id) {
		// Get placeholders
		$old_price_single = wc_get_price_to_display($product);
		$discount = ($PBQ->get_core()->is_enabled($product_id) ? $PBQ->get_core()->get_discount_by_quantity($quantity, $product_id) : 0);
		$discount_type = $PBQ->get_core()->get_discount_type($product_id, $quantity);
		if (false !== $discount) {
			switch ($discount_type) {
				case 'price_directly':
					$new_price_single = wc_get_price_to_display($product, array('price' => $discount));
					break;
				case 'percent':
					$new_price_single = wc_get_price_to_display($product) * (1 - $discount / 100);
					break;
				default: // 'fixed'
					$new_price_single = wc_get_price_to_display($product, array('price' => ($product->get_price() - $discount)));
					break;
			}
		} else {
			$new_price_single = $old_price_single;
		}
		$placeholders = $PBQ->get_placeholders(
			array(
				'old_price_single' => $old_price_single,
				'new_price_single' => $new_price_single,
				'discount' => $discount,
				'discount_type' => $discount_type,
				'quantity' => $quantity,
				'total_quantity' => false,
				'product' => $product,
			)
		);
		// Handle deprecated placeholders
		$placeholders['%price_single%'] = $placeholders['%old_price_single%'];
		$placeholders['%price%'] = $placeholders['%old_price_total%'];
		$placeholders['%new_price%'] = $placeholders['%new_price_total%'];
		return array($placeholders['%new_price%'], $placeholders['%price%']);
	}
}

//Select product on checkout
function custom_checkout_dropdown($product_id)
{
	$product = wc_get_product($product_id);

	if ($product && $product->is_type('simple')) {
		$quantity_options = get_field('quantity_options', $product_id);

		foreach ($quantity_options as $option) {
			$option_value = $option['quantity'];
			$product_price = price_display_by_qty($option_value, $product->get_id());
			?>
			<div class="cart_item">
				<div class="product-name">
					<?php echo $product->get_name(); ?>&nbsp;<strong class="product-quantity">×&nbsp;
						<?php echo $option_value; ?>
					</strong>
				</div>
				<div class="product-total">
					<div class="new_price">
						<?php echo $product_price[0]; ?>
					</div>
				</div>
			</div>
			<?php
		}
	}
}

//Add custom quantity block
function woocommerce_custom_quantity()
{
	if (is_product()) {
		global $product;
		if ($product->is_type('simple')) {
			$custom_fields = get_field('quantity_options', $product->get_id());
			echo '<div class="discount_blocks">';
			if (!empty($custom_fields)) {
				foreach ($custom_fields as $field) {
					$quantity = $field['quantity'];
					$discount = $field['discount'];
					echo '<div class="discount_block">
					<div class="product_quantity">' . $quantity . '</div>
					<div class="product_discount">' . $discount . ' off</div>
					</div>';
				}
			}
			echo '</div>';
		}
	}
}

//Custom buy btn
function woocommerce_custom_buy_now()
{
	global $product;
	echo '<div class="custom_buy btn-red"><p class="price">' . $product->get_price_html() . '</p><span>&nbsp;- buy now</span></div>';
}

//Upsale render
function upsale_checkout($product_id)
{
	$product = wc_get_product($product_id);

	if ($product) {
		$quantity_options = get_field('quantity_options', $product_id);

		foreach ($quantity_options as $option) {
			$option_value = $option['quantity'];
			$product_price = price_display_by_qty($option_value, $product->get_id());

			if ($option_value && $product_price) {
				?>
				<div class="upsale-product">
					<div class="icon"></div>
					<div class="content">
						<div class="title">
							<?php echo get_the_title($product->get_id()) . "x" . $option_value; ?>
						</div>
						<div class="price">
							<div class="old">
								<?php echo $product_price["1"]; ?>
							</div>
							<div class="new">
								<?php echo $product_price["0"]; ?>
							</div>
							<div class="save">Save 25%</div>
						</div>
					</div>
					<a href="<?php echo esc_url(wc_get_cart_url()) . '?add-to-cart=' . $product->get_id() . '&quantity=' . $option_value ?>" class="add-upsale"></a>
				</div>
				<?php
			}
		}
	} else {
		echo 'no items';
	}
}