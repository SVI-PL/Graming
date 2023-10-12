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
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	
		<link href="<?php echo get_template_directory_uri() . '/assets/global/css/bootstrap.min.css' ?>" rel="stylesheet">
		<link href="<?php echo get_template_directory_uri() . '/assets/global/css/all.min.css' ?>" rel="stylesheet">
		<link href="<?php echo get_template_directory_uri() . '/assets/global/css/line-awesome.min.css' ?>"
			rel="stylesheet" />

		<link href="<?php echo get_template_directory_uri() . '/assets/templates/basic/css/magnific-popup.css' ?>"
			rel="stylesheet">
		<link href="<?php echo get_template_directory_uri() . '/assets/templates/basic/css/nice-select.css' ?>"
			rel="stylesheet">
		<link href="<?php echo get_template_directory_uri() . '/assets/templates/basic/css/swiper.min.css' ?>"
			rel="stylesheet">
		<link href="<?php echo get_template_directory_uri() . '/assets/templates/basic/css/odometer.css' ?>"
			rel="stylesheet">
		<link href="<?php echo get_template_directory_uri() . '/assets/templates/basic/css/animate.css' ?>"
			rel="stylesheet">
		<link href="<?php echo get_template_directory_uri() . '/assets/templates/basic/css/jquery.animatedheadline.css' ?>"
			rel="stylesheet">
		<link href="<?php echo get_template_directory_uri() . '/assets/templates/basic/css/style.css' ?>" rel="stylesheet">
		<link href="<?php echo get_template_directory_uri() . '/assets/templates/basic/css/custom.css' ?>" rel="stylesheet">
		<link href="<?php echo get_template_directory_uri() . '/assets/templates/basic/css/color.css' ?>" rel="stylesheet">
	
	<?php wp_head(); ?>
</head>

<body>
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
					<li><a href="/#testimonial">Reviews</a></li>
					<li><a href="/contact">Contact</a>
					</li>
				</ul>
			</nav>
			<div class="account_menu">
				<?php if (!is_user_logged_in()): ?>
					<div class="login_btn btn-red"><a href="/my-account">Log in</a></div>
				<?php else: ?>
					<ul class="sub-menu">
						<li><a href="/my-account">Панель</a></li>
						<li><a href="<?php echo wp_logout_url("/"); ?>">Вийти</a></li>
					</ul>
				<?php endif; ?>

			</div>
		</div>
	</header>
	<!-- header-section end -->
	<a class="scrollToTop" href="#"><svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512">
			<path
				d="M201.4 137.4c12.5-12.5 32.8-12.5 45.3 0l160 160c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L224 205.3 86.6 342.6c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3l160-160z" />
		</svg></a>