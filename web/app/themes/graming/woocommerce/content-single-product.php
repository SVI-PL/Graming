<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.6.0
 */

defined('ABSPATH') || exit;

global $product;

/**
 * Hook: woocommerce_before_single_product.
 *
 * @hooked woocommerce_output_all_notices - 10
 */
do_action('woocommerce_before_single_product');

if (post_password_required()) {
	echo get_the_password_form(); // WPCS: XSS ok.
	return;
}
?>
<?php if ($product->get_id() !== 75): ?>
	<div class="single_product">

		<section class="single_prod_header">
			<div class="trustpilot">
				<img src="<?php echo get_template_directory_uri(); ?>/src/images/trustpilot.svg" alt="">
			</div>
			<div class="single_content">
				<?php do_action('woocommerce_single_product_summary'); ?>
			</div>
			<div class="single_additional">
				<div class="premium_block">
					<div class="premium_header">
						<?php echo get_field("premium_header"); ?>
					</div>
					<div class="premium_content">
						<?php echo get_field("premium_content"); ?>
					</div>
				</div>
				<div class="trusted_block">
					<div class="trust_img">
						<img src="<?php echo get_field("trusted_img")["url"]; ?>" alt="">
					</div>
					<div class="trust_title">
						<?php echo get_field("trusted_title"); ?>
					</div>
					<div class="trust_link">
						<a href="<?php echo get_field("trusted_link"); ?>">
							<?php echo get_field("trusted_link_title"); ?>
						</a>
					</div>
				</div>
			</div>
		</section>
		<section class="single_banner">
			<div class="banner_title">Did you know that by signing up, you can get
				<span>a 25% off promo code?</span>
			</div>
			<div class="banner-btn btn-red"><a href="/my-account/?register">Click Here To Sign Up!</a></div>
		</section>
		<section class="promo_block_wraper">
			<div class="promo_title">What's special about Gramy?</div>
			<div class="promo_descr">With Graming, you can boost your social presence to new heights, expand your reach in
				record time, and get your content recommended to others!</div>
			<div class="promo_blocks">
				<div class="promo_block">
					<div class="block_title">Instant Delivery Start</div>
					<div class="block_desc">Don’t wait for ages as on other platforms. After your purchase, we begin
						processing your order within the first few minutes.</div>
				</div>
				<div class="promo_block">
					<div class="block_title">Guaranteed Quality</div>
					<div class="block_desc">Experience instant engagement from real and premium quality accounts – no fakes
						involved. High-quality is our guarantee.</div>
				</div>
				<div class="promo_block">
					<div class="block_title">24/7 Experienced Support</div>
					<div class="block_desc">At Gramy, our experienced team is committed to providing top-notch support and
						the finest service whenever you require it.</div>
				</div>
			</div>
			<div class="promo_footer">
				<div class="footer_text">Over 2,000 unique daily clients choose Graming’s services</div>
				<div class="footer_img">
					<img src="<?php echo get_template_directory_uri(); ?>/src/images/promo_img.png" alt="Promo image">
				</div>
			</div>
		</section>
		<section class="testimonials" id="testimonial">
			<div class="testimonials_title">What our customers say</div>
			<div class="testimonials_header">
				<div class="header_left">
					<div class="header_img"><img src="<?php echo get_template_directory_uri(); ?>/src/images/5.svg" alt="">
					</div>
					<div class="header_wraper">
						<div class="header_title">Customers rate us <span>Superb</span></div>
						<div class="header_subtitle">5/5 - based on 566 reviews</div>
					</div>
				</div>
				<div class="header_right">
					<div class="testimonials_btn btn-red" id="add_review">Submit Your Review</div>
				</div>
			</div>
			<div class="testimonials_slider">
				<div class="testimonial_slider_wraper">
					<?php
					$slider_reviews = get_field("review_slider", "option");
					foreach ($slider_reviews as $review): ?>
						<div class="slick_slide">
							<div class="slider_inner">
								<div class="rating"><img src="<?php echo get_template_directory_uri(); ?>/src/images/rating.png"
										alt=""></div>
								<div class="name">
									<?php echo $review["name"]; ?>
								</div>
								<div class="text">
									<?php echo $review["text"]; ?>
								</div>
								<div class="slider_bottom">
									<div class="user_name">
										<?php echo $review["user_name"]; ?>
									</div>
									<div class="verify">Verified Purchase</div>
								</div>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
				<div class="slider_nav">
					<div class="slider-newprev"></div>
					<div class="slider-newnext"></div>
				</div>
			</div>
			<div class="add_review_form">
				<form action="" class="review_form">
					<div class="form_left">
						<div class="form_input form_email">
							<label class="form-label required" for="email">Your Name</label>
							<input type="text" name="your_name" id="your_name" placeholder="Your Name" />
						</div>
						<div class="form_input form_email">
							<label class="form-label required" for="email">E-Mail</label>
							<input type="email" class="form-control" name="email" id="email" autocomplete="email"
								placeholder="Your Email" />
						</div>
						<div class="form_input rating">
							<label class="form-label required">Rating</label>
							<img src="<?php echo get_template_directory_uri(); ?>/src/images/rating.svg" alt="">
						</div>
					</div>
					<div class="form_right">
						<div class="form_input form_text_area">
							<label class="form-label required" for="email">Your Review</label>
							<textarea name="review" id="review" placeholder="Your Review" rows="5" cols="33"></textarea>
						</div>
						<div class="submit_btn btn-red">Submit Now</div>
					</div>
				</form>
			</div>
		</section>
		<section class="tabs_section">
			<div class="title">Your Questions: <span>Answered</span></div>
			<div class="tabs_desc">At Gramy, we value our clients deeply and are dedicated to crafting an exceptional
				experience for you.</div>
			<div class="tabs_block">
				<div class="tab_wraper">
					<div class="tab_title">
						Why should I buy Graming's services?
						<div class="tab_dropdown"></div>
					</div>
					<div class="tab_content">
						At Graming, we offer more than just numbers. Purchasing our services not only boosts your followers,
						likes, and views but also strategically enhances your social media presence. Once you achieve
						substantial numbers, your content gains organic promotion through social media algorithms, providing
						a lasting impact on your visibility and engagement. Trust Graming to elevate your socials and unlock
						the potential of organic growth.
					</div>
				</div>
				<div class="tab_wraper">
					<div class="tab_title">
						What quality does Graming offer?
						<div class="tab_dropdown"></div>
					</div>
					<div class="tab_content">
						Graming takes pride in delivering the highest quality services in the market. We are proud to state
						that we provide real-looking likes, followers, and views sourced exclusively from our premium high
						quality accounts. Graming elevates your social media presence through genuine and top-tier
						engagement
					</div>
				</div>
				<div class="tab_wraper">
					<div class="tab_title">
						How can I register my personal account on Graming?
						<div class="tab_dropdown"></div>
					</div>
					<div class="tab_content">
						There are two ways to create your account:

						1) Click the "Sign Up" button in the menu to manually register.

						2) Alternatively, your personal account will be automatically created once you place your first
						order using the email address provided. Your password would be generated automatically and wouldn't
						be stored anywhere for security reasons. You can change your password anytime using the link in your
						registration email or by selecting 'Forgot Password?' - <a
							href="https://graming.com/my-account/">(click here)</a>

					</div>
				</div>
				<div class="tab_wraper">
					<div class="tab_title">
						How can I contact support?
						<div class="tab_dropdown"></div>
					</div>
					<div class="tab_content">
						You can reach our 24/7 support through the Graming Panel after making your first order and
						completing registration. Here is the link for our support - <a
							href="https://graming.com/my-account/support/">(click here)</a>
					</div>
				</div>
				<div class="tab_wraper">
					<div class="tab_title">
						How can I track my order?
						<div class="tab_dropdown"></div>
					</div>
					<div class="tab_content">
						Once you make an order on Graming, you'll be redirected to your order page for real-time tracking.
						Additionally, you can monitor the status of your previous orders in the Graming Panel through this
						link - <a href="https://graming.com/my-account/orders/">(click here)</a>
					</div>
				</div>
			</div>
		</section>
	</div>

	<section class="mini_checkout" id="checkout">
		<div class="checkout_top">
			<div class="back_btn btn-red">Back</div>
			<div class="live_on"><span>
					<?php echo rand(150, 350); ?>
				</span>&nbsp;- Live users on the website</div>
		</div>
		<div class="get_started">
			<div class="content_part">
				<div class="get_started_title">Get Started</div>
				<div class="woocommerce-billing-fields">
					<?php
					$insta_posts = [14];
					$insta_folowers = [173, 178];
					$product_id = $product->get_id();
					$insta_active = false;
					$insta_active_posts = false;
					$insta_active_folowers = false;
					if (in_array($product_id, $insta_folowers)) {
						$insta_active = true;
						$insta_active_folowers = true;
					}
					if (in_array($product_id, $insta_posts)) {
						$insta_active = true;
						$insta_active_posts = true;
					}
					?>
					<?php if ($insta_active == true): ?>
						<div class="input-account">
							<input type="text" name="insta_user" id="insta_user" placeholder="Instagram Username">
							<div class="send_user">
								<div class="text">Find</div>
								<div class="circle-container btn_load">
									<svg fill="none" class="circle-svg" viewBox="0 0 100 100"
										xmlns="http://www.w3.org/2000/svg">
										<circle class="circle" cx="50" cy="50" r="45" />
									</svg>
								</div>
							</div>
							<div
								class='user_pop <?php echo $insta_active_folowers ? "inst_active_folowers" : ""; ?> <?php echo $insta_active_posts ? "inst_active_posts" : ""; ?>'>
							</div>
						</div>
					<div class=" or_select">OR</div>
					<?php endif; ?>
					<div class="input-link">
						<input type="text" name="custom_link" id="custom_link" placeholder="https://...">
						<span>Please enter a valid link</span>
					</div>
					<div class="input-text">
						<input type="email" name="billing_email" id="billing_email" placeholder="email@gmail.com" value="<?php $user = wp_get_current_user();
						if (isset($user)) {
							echo esc_attr($user->user_email);
						} ?>" data-user-email="<?php if (isset($user)) {
							 echo esc_attr($user->user_email);
						 } ?>" autocomplete="email username">
						<span>Please enter a valid email</span>
					</div>
				</div>
				<div class="product_select">
					<div class="cart_item first">
						<div class="product-name">
							<strong class="product-quantity">&nbsp;</strong>
							<?php the_title(); ?>
							<?php echo "<span class='deals'>click for deals</span>"; ?>
						</div>
						<div class="product-total">
							<div class="new_price">
								<?php echo get_first_price($product->get_id()); ?>
							</div>
							<div class="arrow_down"></div>
						</div>
					</div>
					<div class="dropdown_products">
						<?php echo custom_checkout_dropdown($product->get_id()); ?>
					</div>
				</div>

				<div class="mail_send <?php if (is_user_logged_in()) {
					echo "hide";
				} ?>">
					<input type="checkbox" id="agree" name="agree" checked="checked"> <label for="agree">Send me special
						promotions and discounts</label>
				</div>
				<!-- <div class="privacy">
						<input type="checkbox" id="privacy" name="privacy"> <label for="privacy">I agree to the <a
								href="#">Privacy Policy</a>, <a href="#">Public Offering Agreement</a>, <a href="#">Terms of
								Use</a></label>
						<span>Check this box, and click to agree</span>
					</div> -->
				<div class="continue">
					<div class="continue_btn btn-red">Continue</div>
				</div>
			</div>
			<div class="get_started_img">
				<div class="select_posts">
					<div class="select_header">
						Select Posts
					</div>
					<div class="select_data">
						<div class="select_count">Select <span>1 post</span></div>
						<div class="sep"></div>
						<div class="item_count">
							<div class="product-quantity"></div>&nbsp;Likes
						</div>
					</div>
					<div class="imageBlocks"></div>
					<div class="circle-container photo_load">
						<svg fill="none" class="circle-svg" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
							<circle class="circle" cx="50" cy="50" r="45" />
						</svg>
					</div>
					<div class="submit_mob btn-red">Confirm</div>
				</div>

				<img src="<?php echo get_field("get_started_img"); ?>" alt="">
			</div>
		</div>
		<div class="trustpilot">
			<img src="<?php echo get_template_directory_uri(); ?>/src/images/trustpilot.svg" alt="">
		</div>
	</section>

	<?php do_action('woocommerce_after_single_product'); ?>
<?php else: ?>
	<div class="deposite_block">
		<div class="title">Deposit</div>
		<div class="content_block">
			<div class="form_input form_email">
				<label for="account_display_name">Deposit Amount</label>
				<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="deposit-amount"
					id="deposit-amount" placeholder="Enter the amount in USD" />
			</div>
			<div class="btn-red add_deposit">Continue</div>
		</div>
		<div class="prod_data">
			<?php do_action('woocommerce_single_product_summary'); ?>
		</div>
	</div>
<?php endif; ?>