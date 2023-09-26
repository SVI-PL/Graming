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
		<div class="signup-area account-area change-form">
			<div class="row m-0 flex-wrap-reverse">
				<div class="col-lg-6">
					<div class="register-form-area common-form-style bg-one create-account">
						<h4 class="title">Увійти у свій обліковий запис</h4>
						<form class="woocommerce-form woocommerce-form-login create-account-form register-form"
							method="post">
							<?php do_action('woocommerce_login_form_start'); ?>
							<div class="row justify-content-center">
								<div class="col-lg-12 mb-3">
									<label for="username" class="form-label">Ім'я користувача або Імейл</label>
									<input type="text" class="form--control" name="username" id="username"
										autocomplete="username"
										value="<?php echo (!empty($_POST['username'])) ? esc_attr(wp_unslash($_POST['username'])) : ''; ?>" />
								</div>
								<div class="col-lg-12 mb-3">
									<label for="password" class="form-label">Пароль</label>
									<input class="form--control" type="password" name="password" id="password"
										autocomplete="current-password" placeholder="Пароль" />
								</div>
								<?php do_action('woocommerce_login_form'); ?>
								<div class="col-lg-12">
								</div>
								<div class="col-lg-12 mb-3 text-center">
									<div class="checkbox-wrapper d-flex flex-wrap justify-content-between">
										<div class="checkbox-item">
											<input name="rememberme" type="checkbox" id="rememberme" value="forever">
											<label for="remember">Пам'ятати мене</label>
										</div>
										<?php wp_nonce_field('woocommerce-login', 'woocommerce-login-nonce'); ?>
										<a href="<?php echo esc_url(wp_lostpassword_url()); ?>" class="text--base">Забули
											пароль?</a>
									</div>
								</div>
								<div class="col-lg-12">
									<button type="submit"
										class="submit-btn w-100 button woocommerce-form-login__submit<?php echo esc_attr(wc_wp_theme_get_element_class_name('button') ? ' ' . wc_wp_theme_get_element_class_name('button') : ''); ?>"
										name="login" value="<?php esc_attr_e('Log in', 'woocommerce'); ?>">Увійти</button>
								</div>


								<?php do_action('woocommerce_login_form_end'); ?>
							</div>
						</form>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="change-catagory-area">
						<h4 class="title">Зареєструйся Зараз 👇🏻</h4>
						<p>Отримай 10 грн. На баланс 💸</p>
						<a href="<?php echo $_SERVER['REQUEST_URI'] . "?register"; ?>"
							class="btn--base-active account-control-button">Створити Акаунт</a>
					</div>
				</div>
			</div>
		</div>

	<?php else: ?>
		<div class="login-area account-area change-form">
			<div class="row m-0">
				<div class="col-lg-6 p-0">
					<div class="change-catagory-area">
						<h4 class="title">Вже є аккаунт?</h4>
						<a href="/my-account/"
							class="btn--base-active account-control-button">Натисніть тут 👈🏻</a>
					</div>
				</div>
				<div class="col-lg-6 ">
					<div class="register-form-area common-form-style bg-one create-account">
						<h4 class="title">Створити свій обліковий запис</h4>
						<form method="post" class="woocommerce-form woocommerce-form-register"
							<?php do_action('woocommerce_register_form_tag'); ?>>
							<?php do_action('woocommerce_register_form_start'); ?>

							<div class="row">
								<div class="col-md-6">
									<div class="form-group mb-3">
										<label class="form-label required" for="email">E-Mail</label>
										<input type="email" class="form-control form--control checkUser" name="email"
											id="reg_email" autocomplete="email"
											value="<?php echo (!empty($_POST['email'])) ? esc_attr(wp_unslash($_POST['email'])) : ''; ?>" />
									</div>
								</div>

								<div class="col-md-6">
									<div class="form-group mb-3">
										<label class="form-label required" for="mobile">Мобільний</label>
										<div class="input-group ">
											<span class="input-group-text mobile-code">+380</span>
											<input type="hidden" name="mobile_code" value="380" id="mobile_code">
											<input type="hidden" name="country_code" value="UA" id="country_code">
											<input type="number" name="mobile" value=""
												class="form-control form--control checkUser"
												placeholder="Ваш номер телефону" required="" id="mobile">
										</div>
										<small class="text--danger mobileExist"></small>
									</div>
								</div>
								<div class="col-md-12">
								</div>
							</div>

							<div class="form-group form-checkbox mb-3">
								<input type="checkbox" id="agree" name="agree" required="">
								<label for="agree">Я погоджуюсь з</label>
								<span class="text--base">
									<a href="/politika-konfidenciinosti/">Політика конфіденційності</a>, <a
										href="/dogovir-publicnoyi-oferti/">Договір публічної оферти</a>, <a
										href="/umovi-vikoristannia/">Умови використання</a>
								</span>
							</div>
							<div class="form-group mt-3">
								<?php do_action('woocommerce_register_form'); ?>
								<?php wp_nonce_field('woocommerce-register', 'woocommerce-register-nonce'); ?>
								<button type="submit"
									class="btn btn--base w-100 button<?php echo esc_attr(wc_wp_theme_get_element_class_name('button') ? ' ' . wc_wp_theme_get_element_class_name('button') : ''); ?> woocommerce-form-register__submit"
									name="register" value="<?php esc_attr_e('Register', 'woocommerce'); ?>">
									Зареєструватися
								</button>
							</div>
							<p class="mt-3">Вже є аккаунт? <a href="/my-account/" class="text--base"> Логін </a></p>
						</form>
					</div>
				</div>
			</div>
		</div>
		<?php do_action('woocommerce_register_form_end'); ?>

		</form>
	<?php endif; ?>
</div>
<?php do_action('woocommerce_after_customer_login_form'); ?>