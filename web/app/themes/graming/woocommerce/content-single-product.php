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
				<?php
				do_action('woocommerce_single_product_summary');
				?>
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
					<div class="trust_link"><a href="<?php echo get_field("trusted_link"); ?>">
							<?php echo get_field("trusted_link_title"); ?>
						</a></div>
				</div>
			</div>
		</section>
		<section class="single_banner">
			<div class="banner_title">DId you know you can register and get promocode for first
				<span>purchase of 10%?</span>
			</div>
			<div class="banner-btn btn-red"><a href="/my-account/?register">Click here to sign up!</a></div>
		</section>
		<section class="promo_block_wraper">
			<div class="promo_title">Ready to buy Instagram likes?</div>
			<div class="promo_descr">Buying likes for your Instagram posts is the best way to reach a wideraudience,
				encourage engagement, and ensure greater success.</div>
			<div class="promo_blocks">
				<div class="promo_block">
					<div class="block_title">Instant Delivery Guaranteed</div>
					<div class="block_desc">Don't wait to get your likes. Orders typically process within minutes of
						purchase</div>
				</div>
				<div class="promo_block">
					<div class="block_title">100% Real Likes</div>
					<div class="block_desc">High-quality likes delivered instantly from real users with real accounts (no
						bots or fake accounts). We guarantee a quality service.</div>
				</div>
				<div class="promo_block">
					<div class="block_title">24/7 Customer Support</div>
					<div class="block_desc">Graming's experienced staff prides itself on providing the best service
						possible.</div>
				</div>
			</div>
			<div class="promo_footer">
				<div class="footer_text">More than 1,000 Customers trust us every day to deliver real Instagram likes.</div>
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
						<div class="header_subtitle">5/5 - based on 54 reviews</div>
					</div>
				</div>
				<div class="header_right">
					<div class="testimonials_btn btn-red" id="add_review">Submit Your Review</div>
				</div>
			</div>
			<div class="testimonials_slider">
				<div class="testimonial_slider_wraper">
					<div class="slick_slide">
						<div class="slider_inner">
							<div class="rating"><img src="<?php echo get_template_directory_uri(); ?>/src/images/rating.png"
									alt=""></div>
							<div class="name">awesome support</div>
							<div class="text">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor
								incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud
								exercitation
								ullamco laboris nisi ut aliquip ex ea commodo consequat. </div>
							<div class="slider_bottom">
								<div class="user_name">Jake Paul</div>
								<div class="verify">Verified Purchase</div>
							</div>
						</div>
					</div>
					<div class="slick_slide">
						<div class="slider_inner">
							<div class="rating"><img src="<?php echo get_template_directory_uri(); ?>/src/images/rating.png"
									alt=""></div>
							<div class="name">awesome support</div>
							<div class="text">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor
								incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud
								exercitation
								ullamco laboris nisi ut aliquip ex ea commodo consequat. </div>
							<div class="slider_bottom">
								<div class="user_name">Jake Paul</div>
								<div class="verify">Verified Purchase</div>
							</div>
						</div>
					</div>
					<div class="slick_slide">
						<div class="slider_inner">
							<div class="rating"><img src="<?php echo get_template_directory_uri(); ?>/src/images/rating.png"
									alt=""></div>
							<div class="name">awesome support</div>
							<div class="text">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor
								incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud
								exercitation
								ullamco laboris nisi ut aliquip ex ea commodo consequat. </div>
							<div class="slider_bottom">
								<div class="user_name">Jake Paul</div>
								<div class="verify">Verified Purchase</div>
							</div>
						</div>
					</div>
				</div>
				<div class="slider_nav">
					<div class="slider-newprev"></div>
					<div class="slider-newnext"></div>
				</div>
			</div>
		</section>
		<section class="tabs_section">
			<div class="title">Buy Instagram Likes with <span>Graming</span></div>
			<div class="tabs_desc">Over 12,000 daily customers trust us as the best site to deliver real Instagram likes
			</div>
			<div class="tabs_block">
				<div class="tab_wraper">
					<div class="tab_title">
						Why SHOULD I BUY INSTAGRAM LIKES?
						<div class="tab_dropdown"></div>
					</div>
					<div class="tab_content">
						Instagram likes aren't just a vanity metric — the number of likes you get directly affects
						Instagram's core algorithm. The more likes and engagement your content has, the more people you're
						going to reach.

						Buying likes is the single best way of boosting your presence on social media — earning you more
						recognition, more followers, and ultimately, more conversions.

						The more likes a photo or video receives, the higher the chance of reaching the explore page —
						opening you up to millions of new viewers.

						Likes also serve as social proof for viewers that see your content. When a photo has a high number
						of likes, they're more likely to engage with it further. Buying likes is a good way to catalyze this
						interaction — boosting the organic engagement your content is capable of throughout its lifetime.

						You can also <a href="#">buy Instagram followers</a> at Graming.
					</div>
				</div>
				<div class="tab_wraper">
					<div class="tab_title">
						Which PACKAGE SHOULD I CHOOSE?
						<div class="tab_dropdown"></div>
					</div>
					<div class="tab_content">
						Instagram likes aren't just a vanity metric — the number of likes you get directly affects
						Instagram's core algorithm. The more likes and engagement your content has, the more people you're
						going to reach.

						Buying likes is the single best way of boosting your presence on social media — earning you more
						recognition, more followers, and ultimately, more conversions.

						The more likes a photo or video receives, the higher the chance of reaching the explore page —
						opening you up to millions of new viewers.

						Likes also serve as social proof for viewers that see your content. When a photo has a high number
						of likes, they're more likely to engage with it further. Buying likes is a good way to catalyze this
						interaction — boosting the organic engagement your content is capable of throughout its lifetime.

						You can also <a href="#">buy Instagram followers</a> at Graming.
					</div>
				</div>
				<div class="tab_wraper">
					<div class="tab_title">
						What INFORMATION DO I NEED TO PROVIDE?
						<div class="tab_dropdown"></div>
					</div>
					<div class="tab_content">
						Instagram likes aren't just a vanity metric — the number of likes you get directly affects
						Instagram's core algorithm. The more likes and engagement your content has, the more people you're
						going to reach.

						Buying likes is the single best way of boosting your presence on social media — earning you more
						recognition, more followers, and ultimately, more conversions.

						The more likes a photo or video receives, the higher the chance of reaching the explore page —
						opening you up to millions of new viewers.

						Likes also serve as social proof for viewers that see your content. When a photo has a high number
						of likes, they're more likely to engage with it further. Buying likes is a good way to catalyze this
						interaction — boosting the organic engagement your content is capable of throughout its lifetime.

						You can also <a href="#">buy Instagram followers</a> at Graming.
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
					<div class="input-link">
						<input type="text" name="custom_link" id="custom_link" placeholder="https://..." value="">
					</div>
					<div class="input-text">
						<input type="email" name="billing_email" id="billing_email" placeholder="email@gmail.com" value="<?php if (isset($user)) {
							echo esc_attr($user->user_email);
						} ?>" autocomplete="email username">
					</div>
				</div>
				<div class="product_select">
					<div class="cart_item first">
						<div class="product-name">
							<?php the_title(); ?>
							<strong class="product-quantity">×&nbsp;??</strong>
							<?php echo " - <span class='deals'>click for deals</span>"; ?>
						</div>
						<div class="product-total">
							<div class="new_price">$ ??</div>
							<div class="arrow_down"></div>
						</div>
					</div>
					<div class="dropdown_products">
						<?php echo custom_checkout_dropdown($product->get_id()); ?>
					</div>
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
				<div class="continue">
					<div class="continue_btn btn-red">Continue</div>
				</div>
			</div>
			<div class="get_started_img"><img src="<?php echo get_template_directory_uri(); ?>/src/images/get_started.png"
					alt=""></div>
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