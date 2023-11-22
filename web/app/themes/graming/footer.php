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

<footer class="footer">
	<div class="footer-wrap">
		<div class="footer-area">
			<div class="footer_block">
				<div class="footer_block_title">Quick Link</div>
				<?php wp_nav_menu(['theme_location' => 'menu-5']); ?>
			</div>
			<div class="footer_block">
				<div class="footer_block_title">Privacy and Terms</div>
				<?php wp_nav_menu(['theme_location' => 'menu-6']); ?>
			</div>
			<div class="footer_block">
				<div class="footer_block_title">Contact Info</div>
				<div class="text">KING & QUEEN MEDIA UG</div>
				<div class="info">
					<a href="mailto:info@graming.com">info@graming.com</a>
				</div>
				<div class="payments_img">
					<img src="<?php echo get_template_directory_uri(); ?>/src/images/applapay.svg" alt="">
					<img src="<?php echo get_template_directory_uri(); ?>/src/images/mastersvg.svg" alt="">
					<img src="<?php echo get_template_directory_uri(); ?>/src/images/visa.svg" alt="">
					<img src="<?php echo get_template_directory_uri(); ?>/src/images/american.svg" alt="">
				</div>
			</div>
		</div>
	</div>
</footer>
<!-- footer-section end -->
<div class="scrollToTop">
	<svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512">
		<path
			d="M201.4 137.4c12.5-12.5 32.8-12.5 45.3 0l160 160c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L224 205.3 86.6 342.6c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3l160-160z" />
	</svg>
</div>


<?php wp_footer(); ?>

</body>

</html>