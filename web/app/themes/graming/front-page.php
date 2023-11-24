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
        <div class="promo_descr">With Graming, you can boost your social presence to new heights, expand your reach in record time, and get your content recommended to others!</div>
        <div class="promo_blocks">
            <div class="promo_block">
                <div class="block_title">Instant Delivery Start</div>
                <div class="block_desc">Don’t wait for ages as on other platforms. After your purchase, we begin processing your order within the first few minutes.</div>
            </div>
            <div class="promo_block">
                <div class="block_title">Guaranteed Quality</div>
                <div class="block_desc">Experience instant engagement from real and premium quality accounts – no fakes involved. High-quality is our guarantee.</div>
            </div>
            <div class="promo_block">
                <div class="block_title">24/7 Experienced Support</div>
                <div class="block_desc">At Gramy, our experienced team is committed to providing top-notch support and the finest service whenever you require it.</div>
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
            <?php echo do_shortcode('[contact-form-7 id="0fc0a82" title="Review form"]');?>
        </div>
    </section>
    <section class="tabs_section">
        <div class="title">Buy Instagram Likes with <span>Graming</span></div>
        <div class="tabs_desc">Over 12,000 daily customers trust us as the best site to deliver real Instagram likes
        </div>
        <div class="tabs_block">
            <div class="tab_wraper active">
                <div class="tab_title">
                    Why SHOULD I BUY INSTAGRAM LIKES?
                    <div class="tab_dropdown"></div>
                </div>
                <div class="tab_content active">
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
<?php
get_footer();