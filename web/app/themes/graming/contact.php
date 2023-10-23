<?php
/* Template Name: Contact us */
get_header();
?>
<!-- contact-section start -->
<section class="contact-section">
    <div class="container">
        <div class="contact_header">
            <div class="title">Get in Touch</div>
            <div class="text">Building better services starts with your feedback. Please share your thoughts or ask any questions about our services below.</div>
        </div>
        <div class="contact_form">
            <?php echo do_shortcode('[wpforms id="77" title="false"]');?>
        </div>    
    </div>
</section>
<!-- contact-section end -->
<?php
get_footer();