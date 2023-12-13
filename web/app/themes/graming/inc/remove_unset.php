<?php
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 10);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40);

add_action('woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 10);
add_action('woocommerce_single_product_summary', 'woocommerce_custom_quantity', 10);
add_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 20);
add_action('woocommerce_single_product_summary', 'woocommerce_custom_buy_now', 30);

//Unset billing fields
function fields_filter($fields)
{

	// оставляем эти поля
	unset($fields['billing']['billing_first_name']); // имя
	unset($fields['billing']['billing_last_name']); // фамилия
	unset($fields['billing']['billing_phone']); // телефон
	//unset( $fields[ 'billing' ][ 'billing_email' ] ); // емайл

	// удаляем все эти поля
	unset($fields['billing']['billing_company']); // компания
	// unset($fields['billing']['billing_country']); // страна
	unset($fields['billing']['billing_address_1']); // адрес 1
	unset($fields['billing']['billing_address_2']); // адрес 2
	unset($fields['billing']['billing_city']); // город
	unset($fields['billing']['billing_state']); // регион, штат
	// unset($fields['billing']['billing_postcode']); // почтовый индекс
	unset($fields['order']['order_comments']); // заметки к заказу

	return $fields;

}
add_filter('woocommerce_checkout_fields', 'fields_filter', 25);

add_filter('woocommerce_billing_fields', 'custom_billing_fields', 10, 1);

function custom_billing_fields($fields) {
    $fields['billing_postcode']['required'] = false;
    $fields['billing_postcode']['placeholder'] = 'ZIP code';
    $fields['billing_country']['required'] = false;

    return $fields;
}

//Disable the emoji's
function disable_emojis()
{
	remove_action('wp_head', 'print_emoji_detection_script', 7);
	remove_action('admin_print_scripts', 'print_emoji_detection_script');
	remove_action('wp_print_styles', 'print_emoji_styles');
	remove_action('admin_print_styles', 'print_emoji_styles');
	remove_filter('the_content_feed', 'wp_staticize_emoji');
	remove_filter('comment_text_rss', 'wp_staticize_emoji');
	remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
	add_filter('tiny_mce_plugins', 'disable_emojis_tinymce');
	add_filter('wp_resource_hints', 'disable_emojis_remove_dns_prefetch', 10, 2);
}
add_action('init', 'disable_emojis');

//Filter function used to remove the tinymce emoji plugin.
function disable_emojis_tinymce($plugins)
{
	if (is_array($plugins)) {
		return array_diff($plugins, array('wpemoji'));
	} else {
		return array();
	}
}

//Remove emoji CDN hostname from DNS prefetching hints.
function disable_emojis_remove_dns_prefetch($urls, $relation_type)
{
	if ('dns-prefetch' == $relation_type) {
		$emoji_svg_url = apply_filters('emoji_svg_url', 'https://s.w.org/images/core/emoji/2/svg/');
		$urls = array_diff($urls, array($emoji_svg_url));
	}
	return $urls;
}

add_filter('wpcf7_autop_or_not', '__return_false');

// Disable pass notify
function disable_password_change_notification() {
    return false;
}

add_filter('wp_password_change_notification', 'disable_password_change_notification');