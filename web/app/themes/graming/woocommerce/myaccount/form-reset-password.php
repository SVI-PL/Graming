<?php
/**
 * Lost password reset form.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-reset-password.php.
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

do_action('woocommerce_before_reset_password_form');
?>

<form method="post" class="woocommerce-ResetPassword lost_reset_password">
	<div class="custom_block">
		<div class="block_title">Reset password</div>
		<div class="form_content">
			<div class="form_input form_pass">
				<label for="password" class="form-label">
					<?php esc_html_e('New password', 'woocommerce'); ?>
				</label>
				<input type="password" class="woocommerce-Input woocommerce-Input--text input-text" name="password_1"
					id="password_1" autocomplete="new-password" />
			</div>
			<div class="form_input form_pass">
				<label for="password" class="form-label">
					<?php esc_html_e('Re-enter new password', 'woocommerce'); ?>
				</label>
				<input type="password" class="woocommerce-Input woocommerce-Input--text input-text" name="password_2"
					id="password_2" autocomplete="new-password" />
			</div>
			<input type="hidden" name="reset_key" value="<?php echo esc_attr($args['key']); ?>" />
			<input type="hidden" name="reset_login" value="<?php echo esc_attr($args['login']); ?>" />
			<?php do_action('woocommerce_resetpassword_form'); ?>
			<input type="hidden" name="wc_reset_password" value="true" />
			<button type="submit" class="submit-btn btn-red"
				value="<?php esc_attr_e('Save', 'woocommerce'); ?>">
				<?php esc_attr_e('Save', 'woocommerce'); ?>
			</button>
			<?php wp_nonce_field('reset_password', 'woocommerce-reset-password-nonce'); ?>
		</div>
	</div>
</form>
<?php
do_action('woocommerce_after_reset_password_form');

