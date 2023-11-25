<?php
/**
 * Login Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-login.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 7.0.1
 */

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}
do_action('woocommerce_before_customer_login_form'); ?>

<div class="account-wrapper">
	<?php if ($_SERVER['REQUEST_URI'] !== "/my-account/?register"): ?>
		<div class="login-area">
			<div class="login_left">
				<div class="login_title">Login</div>
				<form class="woocommerce-form woocommerce-form-login" method="post">
					<?php do_action('woocommerce_login_form_start'); ?>

					<div class="form_input form_email">
						<label for="username" class="form-label">Email</label>
						<input type="text" class="form--control" name="username" id="username" autocomplete="username"
							placeholder="Your Email"
							value="<?php echo (!empty($_POST['username'])) ? esc_attr(wp_unslash($_POST['username'])) : ''; ?>" />
					</div>
					<div class="form_input form_pass">
						<label for="password" class="form-label">Password</label>
						<input class="form--control" type="password" name="password" id="password"
							autocomplete="current-password" placeholder="Your Password" />
					</div>
					<?php do_action('woocommerce_login_form'); ?>
					<?php wp_nonce_field('woocommerce-login', 'woocommerce-login-nonce'); ?>
					<a href="<?php echo esc_url(wp_lostpassword_url()); ?>" class="text--base">Forgot Password ?</a>
					<button type="submit"
						class="submit-btn btn-red woocommerce-form-login__submit<?php echo esc_attr(wc_wp_theme_get_element_class_name('button') ? ' ' . wc_wp_theme_get_element_class_name('button') : ''); ?>"
						name="login" value="<?php esc_attr_e('Sign in Now', 'woocommerce'); ?>">Sign in Now</button>

					<?php do_action('woocommerce_login_form_end'); ?>

				</form>
			</div>
			<div class="login_right">
				<div class="signup_promo_text">
					Did you know that by signing up, you can get a <span>25% off promo code?</span>
				</div>
				<div class="log_in_bg"></div>
				<div class="btn-red"><a href="/my-account/?register">Click here to sign up!</a></div>
			</div>

		</div>

	<?php else: ?>

		<div class="login-area">
			<div class="login_left">
				<div class="login_title">Sign up</div>
				<form method="post" class="woocommerce-form woocommerce-form-register" <?php do_action('woocommerce_register_form_tag'); ?>>
					<?php do_action('woocommerce_register_form_start'); ?>
					<div class="form_input form_email">
						<label class="form-label required" for="email">E-Mail</label>
						<input type="email" class="form-control form--control checkUser" name="email" id="reg_email"
							autocomplete="email" placeholder="Your Email" />
					</div>
					<div class="form_input form_pass">
						<label for="password" class="form-label">Password</label>
						<input class="form--control" type="password" name="password" id="password"
							placeholder="Your Password" />
					</div>
					<div class="form_input form_pass">
						<label for="password" class="form-label">Confirm Password</label>
						<input class="form--control" type="password" name="password-confirm" id="password-confirm"
							placeholder="Confirm Password" />
					</div>
					<div class="mail_send">
						<input type="checkbox" id="agree" name="agree" checked="checked"> <label for="agree">Send me special
							promotions and discounts</label>
					</div>
					<div class="privacy">
						<input type="checkbox" id="privacy" name="privacy"> <label for="privacy">I agree to the <a
								href="">Privacy Policy</a>, <a href="">Public Offering Agreement</a>, <a href="">Terms of
								Use</a></label>
					</div>
					<div class="form-group">
						<?php do_action('woocommerce_register_form'); ?>
						<?php wp_nonce_field('woocommerce-register', 'woocommerce-register-nonce'); ?>
						<button type="submit" class="submit-btn btn-red woocommerce-form-register__submit" name="register"
							value="<?php esc_attr_e('Register', 'woocommerce'); ?>">
							Sign Up Now
						</button>
					</div>
				</form>
			</div>
			<div class="login_right">
				<div class="signup_promo_text">
					<span>Welcome to Graming!</span> <br>Do you already have an account on Gramy?
				</div>
				<div class="log_in_bg"></div>
				<div class="btn-red"><a href="/my-account/">Log in</a></div>
			</div>
		</div>
		<?php do_action('woocommerce_register_form_end'); ?>

		</form>
	<?php endif; ?>
</div>
<?php do_action('woocommerce_after_customer_login_form'); ?>