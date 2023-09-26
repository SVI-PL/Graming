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
<!doctype html>
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
			<div class="header-bottom-area">
				<div class="container">
					<div class="header-menu-content">
						<nav class="navbar navbar-expand-lg p-0">
							<a class="site-logo site-title" href="/"><img
									src="<?php echo get_template_directory_uri() . '/assets/images/logoicon/logo.png' ?>"></a>
							<button class="navbar-toggler ms-auto" type="button" data-bs-toggle="collapse"
								data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
								aria-expanded="false" aria-label="Toggle navigation">
								<span class="fas fa-bars"></span>
							</button>
							<div class="collapse navbar-collapse" id="navbarSupportedContent">
								<ul class="navbar-nav main-menu ms-auto">
									<li><a href="http://easylikes.test">Головна</a></li>
									<li class="menu_has_children">
										<a href="javascript:void(0)" class="icon">
											<i class="fa-brands fa-instagram" style="color: #e4405f;"></i> Інстаграм
										</a>
										<ul class="sub-menu">
											<li><a href="http://easylikes.test/service/details/1">Інстаграм Лайки</a>
											</li>
										</ul>
									</li>
									<li class="menu_has_children">
										<a href="javascript:void(0)" class="icon">
											<i class="fa-brands fa-telegram" style="color: #0088cc;"></i> Телеграм
										</a>
										<ul class="sub-menu">
											<li><a href="http://easylikes.test/service/details/2">Телеграм перегляди</a>
											</li>
										</ul>
									</li>
									<li class="menu_has_children">
										<a href="javascript:void(0)" class="icon">
											<i class="fa-brands fa-tiktok" style="color: #ff0050;"></i> ТікТок
										</a>
										<ul class="sub-menu">
											<li><a href="http://easylikes.test/service/details/3">ТікТок Лайки</a></li>
										</ul>
									</li>
									<li><a href="#testimonial">Відгуки</a></li>
									<li><a href="http://easylikes.test/contact">Контакти</a>
									</li>
									<li class="menu_has_children">
										<a href="javascript:void(0)">Обліковий запис</a>
										<ul class="sub-menu">
											<?php if (!is_user_logged_in()): ?>
												<li><a href="/my-account">Login</a></li>
												<li><a href="/my-account/?register">Register</a></li>
											<?php else: ?>
												<li><a href="/my-account">Панель</a></li>
												<li><a href="<?php echo wp_logout_url("/"); ?>">Вийти</a></li>
											<?php endif; ?>
										</ul>
									</li>
								</ul>
							</div>
						</nav>
					</div>
				</div>
			</div>
		</div>
	</header>
	<!-- header-section end -->
	<a class="scrollToTop" href="#"><i class="fa fa-angle-up"></i></a>