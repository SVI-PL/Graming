<?php
/**
 * Edit account form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-edit-account.php.
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
$user_id = get_current_user_id();
$user = get_user_by('id', $user_id);
do_action('woocommerce_before_edit_account_form'); ?>

<form class="woocommerce-EditAccountForm edit-account" action="" method="post" <?php do_action('woocommerce_edit_account_form_tag'); ?>>

	<?php do_action('woocommerce_edit_account_form_start'); ?>
	<div class="acc_title">Account Settings </div>
	<div class="main_filds">

		<input type="hidden" class="woocommerce-Input woocommerce-Input--text input-text" name="account_first_name"
			id="account_first_name" autocomplete="given-name" value="John" />
		<input type="hidden" class="woocommerce-Input woocommerce-Input--text input-text" name="account_last_name"
			id="account_last_name" autocomplete="family-name" value="Doe" />

		<div class="form_input form_email">
			<label for="account_email">Account Email</label>
			<input type="email" class="woocommerce-Input woocommerce-Input--email input-text" name="account_email"
				id="account_email" autocomplete="email" value="<?php echo esc_attr($user->user_email); ?>" />
		</div>
		<div class="form_input form_email">
			<label for="account_display_name">Name</label>
			<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="account_display_name"
				id="account_display_name" value="<?php echo esc_attr($user->display_name); ?>" />
		</div>

	</div>
	<div class="change_pass">
		<div class="form_input form_pass">
		<label for="account_display_name">Change Account Password</label>
			<input type="text" class="woocommerce-Input woocommerce-Input--password input-text"
				name="password_current" placeholder="Current Password" id="password_current" autocomplete="off" />
		</div>
		<div class="form_input form_pass">
			<input type="text" class="woocommerce-Input woocommerce-Input--password input-text" name="password_1"
			placeholder="New Password" id="password_1" autocomplete="off" />
		</div>
		<div class="form_input form_pass">
			<input type="text" class="woocommerce-Input woocommerce-Input--password input-text" name="password_2"
			placeholder="Confirm New Password" id="password_2" autocomplete="off" />
		</div>
		<a href="<?php echo esc_url(wp_lostpassword_url()); ?>" class="text--base">Forgot Password ?</a>

		<?php do_action('woocommerce_edit_account_form'); ?>

		<?php wp_nonce_field('save_account_details', 'save-account-details-nonce'); ?>
		<button type="submit" class="submit-btn btn-red" name="save_account_details"
			value="<?php esc_attr_e('Save changes', 'woocommerce'); ?>">
			<?php esc_html_e('Save changes', 'woocommerce'); ?>
		</button>
	</div>
	<input type="hidden" name="action" value="save_account_details" />


	<?php do_action('woocommerce_edit_account_form_end'); ?>
</form>

<?php do_action('woocommerce_after_edit_account_form'); ?>