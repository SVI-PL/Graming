<?php
/**
 * Login form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/global/form-login.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     7.0.1
 */

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

if (is_user_logged_in()) {
	return;
}

?>
<form class="woocommerce-form woocommerce-form-login login login_on_checkout" method="post" <?php echo ($hidden) ? 'style="display:none;"' : ''; ?>>

	<?php do_action('woocommerce_login_form_start'); ?>
	<div class="checkout_login">
		<div class="form_input form_email">
			<label for="username" class="form-label">Email</label>
			<input type="text" class="form--control" name="username" id="username" autocomplete="username"
				placeholder="Your Email"
				value="<?php echo (!empty($_POST['username'])) ? esc_attr(wp_unslash($_POST['username'])) : ''; ?>" />
		</div>
		<div class="form_input form_pass">
			<label for="password" class="form-label">Password</label>
			<input class="form--control" type="password" name="password" id="password" autocomplete="current-password"
				placeholder="Your Password" />
		</div>
	</div>
	<?php do_action('woocommerce_login_form'); ?>

	<p class="form-row">
		<label class="woocommerce-form__label woocommerce-form__label-for-checkbox woocommerce-form-login__rememberme">
			<input class="woocommerce-form__input woocommerce-form__input-checkbox" name="rememberme" type="checkbox"
				id="rememberme" value="forever" /> <span>
				<?php esc_html_e('Remember me', 'woocommerce'); ?>
			</span>
		</label>
		<?php wp_nonce_field('woocommerce-login', 'woocommerce-login-nonce'); ?>
		<input type="hidden" name="redirect" value="<?php echo esc_url($redirect); ?>" />
		<button type="submit"
		class="submit-btn btn-red woocommerce-form-login__submit<?php echo esc_attr(wc_wp_theme_get_element_class_name('button') ? ' ' . wc_wp_theme_get_element_class_name('button') : ''); ?>"
		name="login" value="<?php esc_attr_e('Log in', 'woocommerce'); ?>">Log in</button>
	</p>
	<a href="<?php echo esc_url(wp_lostpassword_url()); ?>" class="text--base">Forgot Password ?</a>
	<?php do_action('woocommerce_login_form_end'); ?>

</form>