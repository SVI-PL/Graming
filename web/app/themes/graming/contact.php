<?php
/* Template Name: Contact us */
get_header();
?>
<!-- contact-section start -->
<section class="contact-section register-section ptb-80">
    <div class="container">
        <figure class="figure highlight-background highlight-background--lean-left">
            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="1439px"
                height="480px">
                <defs>
                    <linearGradient id="PSgrad_1" x1="42.262%" x2="0%" y1="90.631%" y2="0%">
                        <stop offset="28%" stop-color="rgb(245,246,252)" stop-opacity="1"></stop>
                        <stop offset="100%" stop-color="rgb(255,255,255)" stop-opacity="1"></stop>
                    </linearGradient>
                </defs>
                <path fill-rule="evenodd" fill="rgb(255, 255, 255)"
                    d="M863.247,-271.203 L-345.788,-427.818 L760.770,642.200 L1969.805,798.815 L863.247,-271.203 Z">
                </path>
                <path fill="url(#PSgrad_1)"
                    d="M863.247,-271.203 L-345.788,-427.818 L760.770,642.200 L1969.805,798.815 L863.247,-271.203 Z">
                </path>
            </svg>
        </figure>
        <div class="row justify-content-center align-items-center ml-b-30">
            <div class="col-lg-6 mrb-30">
                <div class="contact-thumb">
                    <img src="https://easylikes.com.ua/assets/images/frontend/contact/649b4f50d00e71687899984.png"
                        alt="Контакти">
                </div>
            </div>
            <div class="col-lg-6 mrb-30">
                <div class="register-form-area">
                    <h3 class="title">Форма для відгуків</h3>
                    <form class="register-form verify-gcaptcha" method="post" action="">
                        <input type="hidden" name="_token" value="GoU3r4ahqjBiEltze7TZa5CBCAFrQ1wSBqGN3Ry7" id="_token">
                        <div class="row justify-content-center ms-b-20">
                            <div class="col-lg-6 mb-3">
                                <input name="name" type="text" class="form--control" placeholder="Твоє ім'я" value=""
                                    required="" id="name">
                            </div>
                            <div class="col-lg-6 mb-3">
                                <input name="email" type="text" class="form--control" placeholder="Введіть ваш імейл"
                                    value="" required="" id="email">
                            </div>
                            <div class="col-lg-12 mb-3">
                                <input name="subject" type="text" class="form--control" placeholder="Напишіть свою тему"
                                    value="" required="" id="subject">
                            </div>
                            <div class="col-lg-12 mb-3">
                                <textarea name="message" wrap="off" class="form--control"
                                    placeholder="Напишіть своє повідомлення" id="message"></textarea>
                            </div>
                            <div class="col-lg-12 mb-3">
                            </div>

                            <div class="col-lg-12">
                                <button type="submit" class="submit-btn w-100">Надіслати зараз</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- contact-section end -->

<!-- contact-info start -->
<div class="contact-info-area ptb-80">
    <div class="container">
        <figure class="figure highlight-background highlight-background--lean-left">
            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="1439px"
                height="480px">
                <defs>
                    <linearGradient id="PSgrad_1" x1="42.262%" x2="0%" y1="90.631%" y2="0%">
                        <stop offset="28%" stop-color="rgb(245,246,252)" stop-opacity="1"></stop>
                        <stop offset="100%" stop-color="rgb(255,255,255)" stop-opacity="1"></stop>
                    </linearGradient>

                </defs>
                <path fill-rule="evenodd" fill="rgb(255, 255, 255)"
                    d="M863.247,-271.203 L-345.788,-427.818 L760.770,642.200 L1969.805,798.815 L863.247,-271.203 Z">
                </path>
                <path fill="url(#PSgrad_1)"
                    d="M863.247,-271.203 L-345.788,-427.818 L760.770,642.200 L1969.805,798.815 L863.247,-271.203 Z">
                </path>
            </svg>
        </figure>
        <div class="contact-info-item-area">
            <div class="row justify-content-center align-items-center ml-b-30">
                <div class="col-lg-4 col-md-6 col-sm-8 text-center mrb-30">
                    <div class="contact-info-item">
                        <i class="fas fa fa-map-marker-alt"></i>
                        <h3 class="title">Інформація Про Компанію</h3>
                        <p>ФОП ОСТАПЕНКО</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-8 text-center mrb-30">
                    <div class="contact-info-item active">
                        <i class="fas fa-envelope"></i>
                        <h3 class="title">Наш Імейл</h3>
                        <p>info@easylikes.com.ua</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-8 text-center mrb-30">
                    <div class="contact-info-item">
                        <i class="fas fa-phone-alt"></i>
                        <h3 class="title">Контакти</h3>
                        <p>info@easylikes.com.ua або телеграм @easylikescomua</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- contact-info end -->
<?php
get_footer();