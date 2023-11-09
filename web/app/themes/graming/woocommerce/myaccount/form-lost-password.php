<?php
/**
 * Lost password form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-lost-password.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 7.0.1
 */

defined('ABSPATH') || exit;

do_action('woocommerce_before_lost_password_form');
?>

<form method="post" class="woocommerce-LostPassword lost_reset_password">
	<div class="custom_block">
		<div class="block_title">Password Recovery</div>
		<div class="form_content">
			<div class="form_input form_email">
				<label for="user_login">
					<?php esc_html_e('Username or email', 'woocommerce'); ?>
				</label>
				<input class="woocommerce-Input woocommerce-Input--text input-text" type="text" name="user_login"
					id="user_login" autocomplete="username" placeholder="Username or email"/>
			</div>
			<?php do_action('woocommerce_lostpassword_form'); ?>
			<input type="hidden" name="wc_reset_password" value="true" />
			<button type="submit" class="submit-btn btn-red"
				value="<?php esc_attr_e('Reset password', 'woocommerce'); ?>">
				<?php esc_html_e('Reset password', 'woocommerce'); ?>
			</button>
			<?php wp_nonce_field('lost_password', 'woocommerce-lost-password-nonce'); ?>
		</div>
	</div>
</form>
<?php
do_action('woocommerce_after_lost_password_form');
