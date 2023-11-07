<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Graming
 */

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<!-- Required meta tags -->
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<?php wp_head(); ?>
</head>

<body <?php if (is_user_logged_in()) {
		echo 'class="logged"';
	} ?>>
	<div id="overlayer">
		<div class="loader">
			<div class="loader-inner"></div>
		</div>
	</div>

	<!-- header-section start -->
	<header class="header-section">
		<div class="header">
			<div class="header_logo">
				<a class="site-logo" href="/">
					Graming <img src="<?php echo get_template_directory_uri() . '/src/images/logo.svg' ?>">
				</a>
			</div>
			<nav class="primary_menu">
				<ul>
					<li class="menu_has_children">
						<div class="title">Instagram</div>
						<ul class="sub-menu">
							<li><a href="/service/instagram-likes/">Instagram Likes</a></li>
						</ul>
					</li>
					<li class="menu_has_children">
						<div class="title">Tik Tok</div>
						<ul class="sub-menu">
							<li><a href="/service/tiktok-likes/">ТікТок Лайки</a></li>
						</ul>
					</li>
					<li><a href="#testimonial">Reviews</a></li>
					<li><a href="/contact">Contact</a>
					</li>
				</ul>
			</nav>
			<div class="account_menu">
				<div class="trust_pilot">
					<img src="<?php echo get_template_directory_uri(); ?>/src/images/Trust_Pilot_Top.svg" alt="">
					<img src="<?php echo get_template_directory_uri(); ?>/src/images/Trust_Pilot_Bottom.svg" alt="">
				</div>
				<?php if (!is_user_logged_in()): ?>
					<div class="login_btn btn-gray"><a href="/my-account">Log in</a></div>
					<div class="signup_btn btn-red"><a href="/my-account/?register">Sign Up</a></div>
				<?php else: ?>
					<div class="balance">
						<a href="/service/usd/">
							<?php get_user_balance(); ?>
						</a>
					</div>
				<?php endif; ?>
				<div class="my_account">
					<div class="account_icon"></div>
					<ul class="sub-menu">
						<?php if (!is_user_logged_in()): ?>
							<div class="login_btn btn-gray"><a href="/my-account">Log in</a></div>
							<div class="signup_btn btn-red"><a href="/my-account/?register">Sign Up</a></div>
						<?php else: ?>
							<li>
								<?php echo get_user_email(); ?>
							</li>
							<li><a href="/my-account">Graming Panel</a></li>
							<li><a href="/my-account">View Orders</a></li>
							<li><a href="<?php echo wp_logout_url("/"); ?>">Log Out</a></li>
							<div class="btn-red"><a href="/service/usd/">Top up</a></div>
						<?php endif; ?>
					</ul>

				</div>

				<div class="additional_menu">
					<div class="additional_menu_icon"></div>
					<ul class="sub-menu">
						<li><a href="/contact">Contact Us</a></li>
						<li><a href="/#testimonial">Reviews</a></li>
						<li><a href="/blog">Blog</a></li>
					</ul>
				</div>
			</div>
		</div>
	</header>
	<!-- header-section end -->