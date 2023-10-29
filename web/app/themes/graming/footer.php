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
				<ul>
					<li><a href="#">Contact</a></li>
					<li><a href="#">API Documentation</a></li>
				</ul>
			</div>
			<div class="footer_block">
				<div class="footer_block_title">Privacy and Terms</div>
				<ul>
					<li><a href="/privacy-policy/">Privacy and Policy</a></li>
					<li><a href="/dogovir-publicnoyi-oferti/">Договір публічної оферти</a></li>
					<li><a href="/umovi-vikoristannia/">Terms and Condition</a></li>
				</ul>
			</div>
			<div class="footer_block">
				<div class="footer_block_title">Contact Info</div>
				<div class="text">KING & QUEEN MEDIA UG</div>
				<div class="info">
					<a href="mailto:info@graming.com">info@graming.com</a>
				</div>
				<img src="<?php echo get_template_directory_uri(); ?>/src/images/cards.png" alt="Cards" />
			</div>
		</div>
	</div>
</footer>
<!-- footer-section end -->



<?php wp_footer(); ?>

</body>

</html>