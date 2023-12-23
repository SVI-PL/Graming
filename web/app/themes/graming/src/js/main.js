jQuery(document).ready(function ($) {
  //Slider setup
  $('.testimonial_slider_wraper').slick({
    infinite: true,
    slidesToShow: 2,
    slidesToScroll: 1,
    arrows: true,
    dots: false,
    prevArrow: '.slider-newprev',
    nextArrow: '.slider-newnext',
    responsive: [{
      breakpoint: 768,
      settings: {
        slidesToShow: 1,
        slidesToScroll: 1
      }
    },]
  });

  //Discount block get price
  $('.discount_block').on("click", function () {
    $('.discount_block').removeClass('active');
    $(this).addClass('active');
    var productQuantity = $(this).find('.product_quantity').text();
    $('input[name="quantity"]').trigger("focus").val(productQuantity).trigger('change').trigger("blur");
    $(".cart_item.first>.product-name>.product-quantity").text(productQuantity);
    $(".item_count>.product-quantity").text(productQuantity);
  });

  //Firs item activator
  setTimeout(function () {
    $('.discount_block').first().trigger("click");
  }, 500);

  //Mask for deposite
  $('#deposit-amount').mask('$000,000', { reverse: false });
  $("#deposit-amount").on("mouseleave", function () {
    let $deposit = $(this).val().replace(/[$,]/g, '');
    $('input[name="quantity"]').trigger("focus").val($deposit).trigger('change').trigger("blur");
  });

  //Deposite form input
  $(".add_deposit").on("click", function () {
    let $deposit = $("#deposit-amount").val().replace(/[$,]/g, '');
    $('input[name="quantity"]').trigger("focus").val($deposit).trigger('change').trigger("blur");
    $("button.single_add_to_cart_button").trigger("click");
  });

  //Validate on continue
  $('.continue_btn').on("click", function () {
    var customLink = $('#custom_link');
    var billingEmail = $('#billing_email');
    // var terms = $('#privacy');

    var customLinkValue = customLink.val();
    var billingEmailValue = billingEmail.val();
    // var isValid = isValidCheckbox(terms[0]);

    if (customLinkValue === '' || !isValidURL(customLinkValue)) {
      customLink.parent().addClass('error');
      customLink.addClass('error');
    } else {
      customLink.parent().removeClass('error');
      customLink.removeClass('error');
    }

    if (billingEmailValue === '' || !isValidEmail(billingEmailValue)) {
      billingEmail.parent().addClass('error');
      billingEmail.addClass('error');
    } else {
      billingEmail.parent().removeClass('error');
      billingEmail.removeClass('error');
    }

    // if (!isValid) {
    //   terms.parent().addClass('error');
    // } else {
    //   terms.parent().removeClass('error');
    // }

    if (customLink.parent().hasClass('error') || billingEmail.parent().hasClass('error')) {
      return;
    }

    var customLinkValue = customLink.val();
    var billingEmailValue = billingEmail.val();

    localStorage.setItem('custom_link', customLinkValue);
    localStorage.setItem('billing_email', billingEmailValue);

    $("button.single_add_to_cart_button").trigger("click");
  });

  //Validate Email
  function isValidEmail(email) {
    var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
    return emailPattern.test(email);
  }

  //Validate url
  function isValidURL(url) {
    var urlPattern = /^(http|https):\/\/[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}/;
    return urlPattern.test(url);
  }

  //Validate checkbox
  function isValidCheckbox(checkbox) {
    return checkbox.checked;
  }
  //Local storage for Link and Email
  var customLinkValue = localStorage.getItem('custom_link');
  var billingEmailValue = localStorage.getItem('billing_email');
  if (customLinkValue) {
    $('#custom_link').val(customLinkValue);
  }
  if (billingEmailValue) {
    const emailValue = $('#billing_email').val();
    if (emailValue === '') {
      $('#billing_email').val(billingEmailValue);
    }
  }

  //Add pay with balance activator
  $(document).on("mouseenter", ".balance_pay", function () {
    let $balance = $('#payment_method_my_balance_payment');
    $balance.trigger("click");
  });
  //Add action for pay with balance
  $(document).on("click", ".balance", function () {
    let $balance = $('#payment_method_my_balance_payment');
    $balance.trigger("click");
    let $place_order = $("#place_order");
    $place_order.trigger("click");
  });

  //Add pay with card activator
  $(document).on("mouseenter", ".card_pay", function () {
    let $card = $('#payment_method_custom_checkout');
    $card.trigger("click");
  });

  //Add pay with card activator 2
  $(document).on("mouseenter", ".payment_method_wc_checkout_com_cards, .pay_order", function () {
    let $card = $('#payment_method_wc_checkout_com_cards');
    $card.trigger("click");
  });

  //Add action for pay with Card
  $(document).on("click", ".pay_order", function () {
    let $card = $('#payment_method_wc_checkout_com_cards');
    $card.trigger("click");
    let $place_order = $("#place_order");
    $place_order.trigger("click");
  });

  //Add pay with google pay activator
  $(document).on("mouseenter", ".google_pay", function () {
    let $card = $('#payment_method_wc_checkout_com_google_pay');
    $card.trigger("click");
  });

  //Add action for pay with Google pay
  $(document).on("click", ".btn-google", function () {
    let $google = $('#payment_method_wc_checkout_com_google_pay');
    $google.trigger("click");
    let $place_order = $("#ckocom_googlePay");
    $place_order.trigger("click");
  });

  //Add action for pay with Apple pay
  $(document).on("click", ".apple_pay", function () {
    let $apple = $('#payment_method_wc_checkout_com_apple_pay');
    $apple.trigger("click");
    let $place_order = $("#ckocom_applePay");
    $place_order.trigger("click");
  });

  //Add action for pay with Crypto
  $(document).on("click", ".pay_crypto", function () {
    let $crypto = $('#payment_method_cryptomus');
    $crypto.trigger("click");
    let $place_order = $("#place_order");
    $place_order.trigger("click");
  });

  //Bonus recalculate in checkout
  $(document).ajaxComplete(function (event, xhr, settings) {
    if (settings.url && settings.url.indexOf("update_order_review") !== -1) {
      let bonusElement = document.querySelector('.bonus_total');
      if (bonusElement) {
        let bonusText = bonusElement.textContent;
        let bonusValue = parseFloat(bonusText.replace(/[$,]/g, ''));
        let bonusCalc = bonusValue * 1.1;
        let formattedBonus = "$" + bonusCalc.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        bonusElement.textContent = formattedBonus;
      }
    }
  });

  //Focus and unFocus for fields
  $("input, textarea").on("focusin", function () {
    $("input").parent().removeClass("active");
    $(this).parent().addClass("active");
  });
  $("input, textarea").on("focusout", function () {
    $("input, textarea").parent().removeClass("active");
  });

  $(".wpcf7-email, input#your_name, textarea#review").on("focusin", function () {
    $("input").parent().parent().removeClass("active");
    $(this).parent().parent().addClass("active");
  });

  $(".wpcf7-email, input#your_name, textarea#review").on("focusout", function () {
    $(".wpcf7-email, input#your_name, textarea#review").parent().parent().removeClass("active");
  });

  $(".submit_btn").on("click", function () {
    $(".wpcf7-submit").trigger("click");
  })
  //Scroll to top btn
  $(window).on("scroll", function () {
    var ScrollTop = $(".scrollToTop");
    if ($(this).scrollTop() < 500) {
      ScrollTop.removeClass("active");
    } else {
      ScrollTop.addClass("active");
    }
  });
  $(".scrollToTop").on("click", function () {
    window.scrollTo({ top: 0, behavior: 'smooth' });
  })

  //Product dropdown list
  $('.arrow_down').on("click", function () {
    $(".dropdown_products").toggleClass("active");
  });
  $('.cart_item').on("click", function () {
    $(".dropdown_products").toggleClass("active");
  });

  //Apply cupon code on checkout
  $(document).on('click', '.btn_apply', function () {
    let $cupon = $("input.coupon_input").val();
    $("input#coupon_code").val($cupon);
    $(".checkout_coupon").submit();
  });

  //Additional menu
  $(".additional_menu_icon").on("click", function () {
    $(".account_icon").removeClass("active");
    $(".my_account").removeClass("active");

    $(this).toggleClass("active");
    $(".additional_menu").toggleClass("active");
  });

  //My account menu
  $(".account_icon").on("click", function () {
    $(".additional_menu_icon").removeClass("active");
    $(".additional_menu").removeClass("active");

    $(this).toggleClass("active");
    $(".my_account").toggleClass("active");
  });

  //Add review form  display
  $("#add_review").on("click", function () {
    $(".testimonials_slider").hide();
    $(".add_review_form").show();
  });

  $(".close_form").on("click", function () {
    $(".testimonials_slider").show();
    $(".add_review_form").hide();
  });

  //Upsale ajax add/remove product
  $('.upsale-product').on('click', function (e) {
    e.preventDefault();
    if ($(this).hasClass("active")) {
      var productID = $(this).find('.remove-upsale').data('product-id');
      var quantity = $(this).find('.remove-upsale').data('quantity');
      $(this).removeClass("active");

      $.ajax({
        type: 'POST',
        url: woocommerce_params.ajax_url,
        data: {
          action: 'update_cart_item_quantity',
          product_id: productID,
          quantity: quantity
        },
        success: function (response) {
          updateOrderReview();
          console.log("refresh")
        }
      });
    } else {
      var productID = $(this).find('.add-upsale').data('product-id');
      var quantity = $(this).find('.add-upsale').data('quantity');
      $('.upsale-product').removeClass("active");
      $(this).addClass("active");

      $.ajax({
        type: 'POST',
        url: woocommerce_params.ajax_url,
        data: {
          action: 'add_to_cart',
          product_id: productID,
          quantity: quantity
        },
        success: function (response) {
          updateOrderReview();
        }
      });
    }
  });

  //Update order review
  function updateOrderReview() {
    var data = {
      security: wc_checkout_params.update_order_review_nonce,
      post_data: $('form.checkout').serialize()
    };

    $.ajax({
      type: 'POST',
      url: wc_checkout_params.wc_ajax_url.toString().replace('%%endpoint%%', 'update_order_review'),
      data: data,
      success: function (response) {

        // Reload the page if requested
        if (response && true === response.reload) {
          window.location.reload();
          return;
        }

        $('.woocommerce-NoticeGroup-updateOrderReview').remove();

        if (response && response.fragments) {
          jQuery.each(response.fragments, function (key, value) {
            jQuery(key).replaceWith(value);
          });
        }

        $(document.body).trigger('updated_checkout', [response]);
      },
    });

  }

  //Clear cart if not checkout
  // function clean_cart() {
  //   var isCheckoutPage = false;
  //   if (window.location.href.indexOf('/checkout/') > -1) {
  //     isCheckoutPage = true;
  //   }
  //   if (!isCheckoutPage) {
  //     $.ajax({
  //       type: 'POST',
  //       url: woocommerce_params.ajax_url,
  //       data: {
  //         action: 'clear_cart'
  //       },
  //       success: function (response) {
  //       }
  //     });
  //   }
  // };
  // clean_cart();

  //Cupon dropdown
  $(document).on('click', '.add_coupon_title', function () {
    $(".dropdown_coupon").toggleClass("active");
  });

  //activete card token
  $(document).on('click', 'ul.woocommerce-SavedPaymentMethods li', function () {
    $("ul.woocommerce-SavedPaymentMethods li").removeClass("active");
    $(this).toggleClass("active");
  });

  //Mobile menu toggle
  $("#menu-header-mobile li.menu-item-has-children").on('click', function () {
    $(this).toggleClass("active");
  });

  //Checkout masks
  $(document).ajaxComplete(function (event, xhr, settings) {
    $('#card_number').mask('9999 9999 9999 9999', { reverse: false });
    //Show applepay
    if (window.ApplePaySession) {
      $(".apple_pay").show();
    } else {
      $(".apple_pay").hide();

    }
  });

  //Ajax get insta user
  $('.send_user').on('click', function () {
    var $insta_user = $('#insta_user').val().trim();
    var user_pop = $('.user_pop');
    user_pop.html("").hide();
    if ($insta_user === '') {
      console.log("empty");
    } else {
      $('.send_user .text').hide();
      $('.send_user .btn_load').css("display", "flex");
      $.ajax({
        type: 'POST',
        url: woocommerce_params.ajax_url,
        data: {
          action: 'get_instagram',
          inst_account: $insta_user,
        },
        success: function (response) {
          $('.send_user .text').show();
          $('.send_user .btn_load').hide();
          var responseData = JSON.parse(response);
          if ($.isArray(responseData)) {
            $.each(responseData, function (index, item) {
              var blockElement = $('<div>').addClass('user_img').attr('data-user-id', item.pk);
              var imageElement = $('<img>').attr('src', item.local_image_path);
              var user_name = $('<div>').addClass('user_name').text(item.full_name);

              blockElement.append(imageElement, user_name);
              user_pop.html(blockElement);
              user_pop.show();
            });
          } else {
            console.error('Response data is not an array.');
            var blockElement = $('<div>').addClass('user_img').text("User not found");
            user_pop.html(blockElement);
            user_pop.show();
          }
        }
      });
    }
  });

  //Ajax get insta photo
  $(document).on('click', '.inst_active_posts .user_img', function () {
    var $insta_user_id = $(this).data('user-id');
    $('.user_pop').hide();
    if ($insta_user_id === '') {
      console.log("empty");
    } else {
      $(".get_started_img>img").hide();
      $(".get_started_img>.select_posts").show();
      $(".photo_load").show();
      //Scroll to photo
      const PhotoElement = $('.get_started_img');
      const activeElement = PhotoElement.offset().top - 60;
      window.scrollTo({
        top: activeElement,
        behavior: 'smooth'
      });

      $.ajax({
        type: 'POST',
        url: woocommerce_params.ajax_url,
        data: {
          action: 'get_user_photo',
          inst_account: $insta_user_id,
        },
        success: function (response) {
          var responseData = JSON.parse(response);
          var imageBlocksContainer = $('.imageBlocks');
          imageBlocksContainer.html("");

          $(".photo_load").hide();

          if ($.isArray(responseData)) {
            $.each(responseData, function (index, item) {
              var blockElement = $('<div>').addClass('user_imgs').attr('data-shortcode', item.shortcode);
              var imageElement = $('<img>').attr('src', item.local_image_path);

              blockElement.append(imageElement);
              imageBlocksContainer.append(blockElement);
            });
          } else {
            console.error('Response data is not an array.');
            var blockElement = $('<div>').addClass('user_photo404').text("User error (private user or etc.)");
            imageBlocksContainer.html(blockElement);
          }
        }
      });
    }
  });

  //Fill user link
  $(document).on('click', '.user_imgs', function () {
    $(".user_imgs").removeClass("active");
    $(this).addClass("active");
    let $link = $(this).data("shortcode");
    $("#custom_link").val("https://www.instagram.com/p/" + $link);
  });
  //Fill user link
  $(document).on('click', '.inst_active_folowers .user_img', function () {
    $('.user_pop').hide();
    let $link = $('#insta_user').val().trim();
    $("#custom_link").val("https://www.instagram.com/" + $link);
  });
});


//Vanilla js
document.addEventListener('DOMContentLoaded', function () {
  //Dropdown Tabs
  const tabTitle = document.querySelectorAll('.tab_title');
  const tabDropdowns = document.querySelectorAll('.tab_dropdown');
  const tabContents = document.querySelectorAll('.tab_content');
  const tabWrappers = document.querySelectorAll('.tab_wraper');

  tabTitle.forEach(tabTitle => {
    tabTitle.addEventListener('click', () => {
      const tabWrapper = tabTitle.closest('.tab_wraper');

      const tabContent = tabWrapper.querySelector('.tab_content');
      const tabDropdown = tabTitle.querySelector('.tab_dropdown');
      const isActive = tabContent.classList.contains('active');
      tabWrappers.forEach(tw => {
        tw.classList.remove('active');
      });
      tabContents.forEach(tabContent => {
        tabContent.classList.remove('active');
      });
      tabDropdowns.forEach(td => {
        td.classList.remove('active');
      });

      if (!isActive) {
        tabContent.classList.add('active');
        tabDropdown.classList.add('active');
        tabWrapper.classList.add('active');
      }
    });
  });

  //Show mini checkout
  const buyButton = document.querySelector('.custom_buy');
  const urlParams = new URLSearchParams(window.location.search);
  const checkoutBlock = document.getElementById('checkout');
  const productBlock = document.querySelector('.single_product');
  function showCheckoutBlock() {
    if (checkoutBlock) {
      checkoutBlock.style.display = 'flex';
    }
    if (productBlock) {
      productBlock.style.display = 'none';
    }
  }
  function hideCheckoutBlock() {
    if (checkoutBlock) {
      checkoutBlock.style.display = 'none';
    }
    if (productBlock) {
      productBlock.style.display = 'flex';
    }
  }
  if (buyButton) {
    buyButton.addEventListener('click', function () {
      urlParams.set('show_checkout', '1');
      const newUrl = `${window.location.pathname}?${urlParams.toString()}`;
      history.pushState(null, null, newUrl);
      showCheckoutBlock();
      window.scrollTo({ top: 0, behavior: 'smooth' });
    });
  }

  if (urlParams.get('show_checkout') === '1') {
    showCheckoutBlock();
  } else {
    hideCheckoutBlock();
  }
  window.addEventListener('popstate', function (event) {
    if (event.state === null) {
      hideCheckoutBlock();
    }
  });

  //Check price status
  var productPriceElement = document.querySelector('.price_all .woocommerce-Price-amount');
  var productTotalElement = document.querySelector('.cart_item.first .product-total .new_price');

  const priceElement = document.querySelector('p.price');
  if (priceElement) {
    function handlePriceChange(mutationsList, observer) {
      for (let mutation of mutationsList) {
        if (mutation.type === 'childList' && mutation.target.classList.contains('price')) {
          productPriceElement = document.querySelector('.price_all .woocommerce-Price-amount');

          if (productPriceElement) {
            var productPrice = productPriceElement.innerHTML;
            productTotalElement.innerHTML = productPrice;
          }
        }
      }
    }

    const observer = new MutationObserver(handlePriceChange);
    observer.observe(priceElement, { childList: true, characterData: true, subtree: true });
  }


  //Change product quantity
  const variantItems = document.querySelectorAll('.dropdown_products .cart_item');
  const discountBlocks = document.querySelectorAll('.discount_blocks .discount_block');

  variantItems.forEach(function (variant, index) {
    variant.addEventListener('click', function () {
      const quantityText = variant.querySelector('.product-quantity').textContent;
      const quantityMatch = quantityText.match(/\d+/);
      const quantity = parseInt(quantityMatch[0]);


      discountBlocks.forEach(function (discountBlock) {
        const productQuantity = parseInt(discountBlock.querySelector('.product_quantity').textContent);
        if (quantity === productQuantity) {
          discountBlock.click();
        }
      });
    });
  });

  //Back btn
  const backButton = document.querySelector('.back_btn');

  if (backButton) {
    backButton.addEventListener('click', function () {
      history.back();
    });
  }
});

//Scroll my account
const navigation = document.querySelector('.woocommerce-MyAccount-navigation ul');
const activeElement = document.querySelector('.woocommerce-MyAccount-navigation-link.is-active');

if (navigation && activeElement) {
  const navigationWidth = navigation.offsetWidth;
  const activeElementCenter = activeElement.offsetLeft + (activeElement.offsetWidth / 2);

  // Posotion to scroll
  let scrollPosition = activeElementCenter - navigationWidth / 2;
  scrollPosition = Math.max(0, scrollPosition);

  // Scroll
  navigation.scrollTo({
    top: scrollPosition,
    behavior: 'smooth'
  });
}

//Scroll to mini cart
const submit_mob = document.querySelector(".submit_mob");
if (submit_mob) {
  submit_mob.addEventListener('click', function () {
    const miniCart = document.querySelector('.content_part');
    if (miniCart) {
      const activeElement = miniCart.offsetTop - 60;
      window.scrollTo({
        top: activeElement,
        behavior: 'smooth'
      });
    }
  });
}
