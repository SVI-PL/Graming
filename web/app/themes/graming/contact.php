<?php
/* Template Name: Contact us */
get_header();
?>
<!-- contact-section start -->
<section class="contact-section">
    <div class="container">
        <div class="contact_header">
            <div class="title">Get in Touch</div>
            <div class="text">We are always open to new business cooperation and your feedback. To contact our support, please create an account and go to our panel - <a href="/my-account/support/">Click Here</a></div>
        </div>
        <div class="contact_form">
            <?php echo do_shortcode('[wpforms id="77" title="false"]');?>
        </div>    
    </div>
</section>
<!-- contact-section end -->
<?php
get_footer();