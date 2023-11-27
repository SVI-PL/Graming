<?php
/* Template Name: Home Page */
get_header();
?>
<div class="home_page">
    <section class="hero_banner">
        <div class="left_part">
            <div class="banner_title">Boost Your Social Influence <span>with Gramy</span></div>
            <div class="hero_text">Make the difference with Gramy's Followers, Likes & Views – Premium Quality and
                Instant Delivery!</div>
            <div class="banner-btn btn-red"><a href="/my-account/?register">Sign up now</a></div>
            <div class="trustpilot">
                <img src="<?php echo get_template_directory_uri(); ?>/src/images/TrustPilot123.svg" alt="">
            </div>
        </div>
        <div class="right_part">
            <img src="<?php echo get_template_directory_uri(); ?>/src/images/Dino_heads.png" alt="">
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
                            <div class="rating"><img src="<?php echo get_template_directory_uri(); ?>/src/images/5stars.svg"
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
            <?php echo do_shortcode('[contact-form-7 id="0fc0a82" title="Review form"]'); ?>
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
<?php
get_footer();