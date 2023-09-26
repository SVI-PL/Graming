<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Graming
 */

?>

<!-- footer-section start -->

<footer class="footer-section ptb-80">
	<div class="container">
		<div class="footer-area">
			<div class="row gy-4">
				<div class="col-lg-4 col-sm-8">
					<div class="footer-widget widget-menu">
						<div class="footer-logo">
							<h3 class="widget-title">About Us</h3>
							<p>Швидкий та легкий шлях до популярності – Easylikes!</p>
							<div class="social-area">
								<ul class="footer-social">
									<li><a href="https://easylikes.com.ua/contact"><i
												class="fas fa-headset"></i></a></a></li>
								</ul>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-2 col-sm-6">
					<div class="footer-widget">
						<h3 class="widget-title">Посилання</h3>
						<ul>
							<li><a href="#">Contact</a></li>
							<li><a href="#">API Documentation</a></li>
						</ul>
					</div>
				</div>
				<div class="col-lg-3 col-sm-6">
					<div class="footer-widget">
						<h3 class="widget-title">Privacy and Terms</h3>
						<ul>
							<li><a href="/privacy-policy/">Політика конфіденційності</a></li>
							<li><a href="/dogovir-publicnoyi-oferti/">Договір публічної оферти</a></li>
							<li><a href="/umovi-vikoristannia/">Умови використання</a></li>
						</ul>
					</div>
				</div>
				<div class="col-lg-3 col-sm-6">
					<div class="footer-widget widget-menu">
						<h3 class="widget-title">Контактна інформація</h3>
						<ul class="footer-contact-list">
							<li>ФОП ОСТАПЕНКО</li>
							<li>Контакти<br>
								Email: <a href="mailto:info@easylikes.com.ua">info@easylikes.com.ua</a><br>
								Телеграм: <a href="https://t.me/easylikescomua">@easylikescomua</a><br>
								Телефон: <a href="tel:+380953081812">+380953081812</a>
							</li>
						</ul>

						</ul>
						<img src="https://smoozzy.io/www/Files/assets/images/cards.png" alt="Cards"
							style="padding-top: 6px;" />
					</div>
				</div>
			</div>
		</div>
	</div>
</footer>

<div class="notification-wrap mb-3">

</div>

<div class="privacy-area privacy-area--style">
	<div class="container">
		<div class="copyright-area d-flex align-items-center justify-content-center flex-wrap">
			<div class="copyright">
				<p>COPYRIGHT © 2023 ALL RIGHT RESERVED</p>
			</div>
		</div>
	</div>
</div>
<!-- footer-section end -->

<!-- cookies dark version start -->
<div class="cookies-card hide text-center">
	<div class="cookies-card__icon bg--base">
		<i class="las la-cookie-bite"></i>
	</div>
	<p class="cookies-card__content mt-4"><a class="link-text" href="route('cookie.policy" target="_blank">learn
			more</a></p>
	<div class="cookies-card__btn mt-4">
		<button class="btn submit-btn w-100 policy" type="button">Allow</button>
	</div>
</div>
<script src="<?php echo get_template_directory_uri() . '/assets/global/js/bootstrap.bundle.min.js' ?>"></script>
<script
	src="<?php echo get_template_directory_uri() . '/assets/templates/basic/js/jquery.magnific-popup.js' ?>"></script>
<script src="<?php echo get_template_directory_uri() . '/assets/templates/basic/js/jquery.nice-select.js' ?>"></script>
<script src="<?php echo get_template_directory_uri() . '/assets/templates/basic/js/swiper.min.js' ?>"></script>
<script src="<?php echo get_template_directory_uri() . '/assets/templates/basic/js/plugin.js' ?>"></script>
<script src="<?php echo get_template_directory_uri() . '/assets/templates/basic/js/viewport.jquery.js' ?>"></script>
<script src="<?php echo get_template_directory_uri() . '/assets/templates/basic/js/odometer.min.js' ?>"></script>
<script src="<?php echo get_template_directory_uri() . '/assets/templates/basic/js/wow.min.js' ?>"></script>
<script src="<?php echo get_template_directory_uri() . '/assets/templates/basic/js/main.js' ?>"></script>
<script>
	(function ($) {
		"use strict";
		$(".langSel").on("change", function () {
			window.location.href = "route('home/change/" + $(this).val();
		});

		window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', event => {
			matched = event.matches;
			if (matched) {
				$('body').addClass('dark-mode');
				$('.navbar').addClass('navbar-dark');
			} else {
				$('body').removeClass('dark-mode');
				$('.navbar').removeClass('navbar-dark');
			}
		});

		let matched = window.matchMedia('(prefers-color-scheme: dark)').matches;
		if (matched) {
			$('body').addClass('dark-mode');
			$('.navbar').addClass('navbar-dark');
		} else {
			$('body').removeClass('dark-mode');
			$('.navbar').removeClass('navbar-dark');
		}

		var inputElements = $('input,select');
		$.each(inputElements, function (index, element) {
			element = $(element);
			element.closest('.form-group').find('label').attr('for', element.attr('name'));
			element.attr('id', element.attr('name'))
		});

		$('.policy').on('click', function () {
			$.get('route('cookie.accept', function (response) {
				$('.cookies-card').addClass('d-none');
		});
	});

	setTimeout(function () {
		$('.cookies-card').removeClass('hide')
	}, 2000);

	var inputElements = $('[type=text],select,textarea');
	$.each(inputElements, function (index, element) {
		element = $(element);
		element.closest('.form-group').find('label').attr('for', element.attr('name'));
		element.attr('id', element.attr('name'))
	});

	$.each($('input,select,textarea'), function (i, element) {
		let elementType = $(element);
		if (elementType.attr('type') != 'checkbox') {
			if (element.hasAttribute('required')) {
				$(element).closest('.form-group').find('label').addClass('required');
			}
		}
	})


	}) (jQuery);
</script>
<?php wp_footer(); ?>

</body>

</html>