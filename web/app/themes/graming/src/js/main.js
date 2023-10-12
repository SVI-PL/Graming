jQuery(document).ready(function ($) {

  $('.testimonial_slider_wraper').slick({
    infinite: true,
    slidesToShow: 2,
    slidesToScroll: 1,
    arrows: false,
    dots: false
  });

  $('.discount_block').on("click", function () {
    $('.discount_block').removeClass('active');
    $(this).addClass('active');
    var productQuantity = $(this).find('.product_quantity').text();

    $('input[name="quantity"]').focus().val(productQuantity).trigger('change').blur();
  });
  $('.discount_block:first').click();
  $(".custom_buy").click(function () {
    $("button.single_add_to_cart_button").click();
  });
  $('.continue_btn').on("click", function () {
    var customLink = $('#custom_link');
    var billingEmail = $('#billing_email');
    var terms = $('#terms');

    var customLinkValue = customLink.val();
    var billingEmailValue = billingEmail.val();
    var TermsVal = terms.val();

    if (customLinkValue === '' || !isValidURL(customLinkValue)) {
      customLink.addClass('error');
    } else {
      customLink.removeClass('error');
    }

    if (billingEmailValue === '' || !isValidEmail(billingEmailValue)) {
      billingEmail.addClass('error');
    } else {
      billingEmail.removeClass('error');
    }

    if (TermsVal === '') {
      terms.addClass('error');
    } else {
      terms.removeClass('error');
    }

    if (customLink.hasClass('error') || billingEmail.hasClass('error') || terms.hasClass('error')) {
      return;
    }

    var customLinkValue = customLink.val();
    var billingEmailValue = billingEmail.val();

    localStorage.setItem('custom_link', customLinkValue);
    localStorage.setItem('billing_email', billingEmailValue);

    $(".get_started").addClass("hidden");
    $(".payment_wraper").addClass("active");
  });

  function isValidEmail(email) {
    var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
    return emailPattern.test(email);
  }

  function isValidURL(url) {
    var urlPattern = /^(http|https):\/\/[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}/;
    return urlPattern.test(url);
  }

  $(window).on("scroll", function () {
    var ScrollTop = $(".scrollToTop");
    if ($(this).scrollTop() < 500) {
      ScrollTop.removeClass("active");
    } else {
      ScrollTop.addClass("active");
    }
  });

  $('.arrow_down').on("click", function () {
    $(".dropdown_products").toggleClass("active");
  });
  $('.deals').on("click", function () {
    $(".dropdown_products").toggleClass("active");
  });
  $(document).on('click', '.btn_apply', function () {
    let $cupon = $("input.coupon_input").val();
    $("input#coupon_code").val($cupon);
    $(".checkout_coupon").submit();
  });


  //Local storage
  var customLinkValue = localStorage.getItem('custom_link');
  var billingEmailValue = localStorage.getItem('billing_email');

  if (customLinkValue) {
    $('#custom_link').val(customLinkValue);
  }

  if (billingEmailValue) {
    $('#billing_email').val(billingEmailValue);
  }
});

document.addEventListener('DOMContentLoaded', function () {
  const tabDropdowns = document.querySelectorAll('.tab_dropdown');
  const tabContents = document.querySelectorAll('.tab_content');
  const tabWrappers = document.querySelectorAll('.tab_wraper');

  tabDropdowns.forEach(tabDropdown => {
    tabDropdown.addEventListener('click', () => {
      const tabWrapper = tabDropdown.closest('.tab_wraper');
      const tabContent = tabWrapper.querySelector('.tab_content');
      const isActive = tabWrapper.classList.contains('active');
      tabWrappers.forEach(tw => {
        tw.classList.remove('active');
      });
      tabContents.forEach(td => {
        td.classList.remove('active');
      });
      tabDropdowns.forEach(tabDropdowns => {
        tabDropdowns.classList.remove('active');
      });

      if (!isActive) {
        tabWrapper.classList.add('active');
        tabContent.classList.add('active');
        tabDropdown.classList.add('active');
      }
    });
  });
});
