jQuery(document).ready(function ($) {

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

  $('.discount_block').on("click", function () {
    $('.discount_block').removeClass('active');
    $(this).addClass('active');
    var productQuantity = $(this).find('.product_quantity').text();
    $('input[name="quantity"]').trigger("focus").val(productQuantity).trigger('change').trigger("blur");
    $(".cart_item.first>.product-name>.product-quantity").text("× " + productQuantity);
  });

  setTimeout(function () {
    $('.discount_block').first().trigger("click");
  }, 1000);

  $('#deposit-amount').mask('$000,000', { reverse: false });
  $("#deposit-amount").on("mouseleave", function () {
    let $deposit = $(this).val().replace(/[$,]/g, '');
    $('input[name="quantity"]').trigger("focus").val($deposit).trigger('change').trigger("blur");
  });

  $(".add_deposit").on("click", function () {
    let $deposit = $("#deposit-amount").val().replace(/[$,]/g, '');
    $('input[name="quantity"]').trigger("focus").val($deposit).trigger('change').trigger("blur");
    $("button.single_add_to_cart_button").trigger("click");
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

    $("button.single_add_to_cart_button").trigger("click");
  });

  function isValidEmail(email) {
    var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
    return emailPattern.test(email);
  }

  function isValidURL(url) {
    var urlPattern = /^(http|https):\/\/[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}/;
    return urlPattern.test(url);
  }

  //Local storage
  var customLinkValue = localStorage.getItem('custom_link');
  var billingEmailValue = localStorage.getItem('billing_email');

  if (customLinkValue) {
    $('#custom_link').val(customLinkValue);
  }

  if (billingEmailValue) {
    $('#billing_email').val(billingEmailValue);
  }

  //Add pay with balance

  $(document).on("mouseenter", ".balance_pay", function () {
    let $balance = $('#payment_method_my_balance_payment');
    $balance.trigger("click");
    console.log("enter");
  });

  $(document).on("click", ".balance", function () {
    let $place_order = $("#place_order");
    $place_order.trigger("click");
  });

  $(document).ajaxComplete(function (event, xhr, settings) {
    if (settings.url && settings.url.indexOf("update_order_review") !== -1) {
      const bonusElement = document.querySelector('.bonus_total');
      if (bonusElement) {
        let bonusText = bonusElement.textContent;
        let bonusValue = parseFloat(bonusText.replace(/[$,]/g, ''));
        let bonusCalc = bonusValue * 1.1;
        let formattedBonus = "$" + bonusCalc.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        bonusElement.textContent = formattedBonus;
      }
    }
  });

  $("input, textarea").on("focusin", function () {
    $("input").parent().removeClass("active");
    $(this).parent().addClass("active");
  });
  $("input, textarea").on("focusout", function () {
    $("input").parent().removeClass("active");
  });

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

  $(".addditional_menu_icon").on("click", function () {
    $(".account_icon").removeClass("active");
    $(".my_account").removeClass("active");

    $(this).toggleClass("active");
    $(".addditional_menu").toggleClass("active");
  });
  $(".account_icon").on("click", function () {
    $(".addditional_menu_icon").removeClass("active");
    $(".addditional_menu").removeClass("active");

    $(this).toggleClass("active");
    $(".my_account").toggleClass("active");
  });

  $("#add_review").on("click", function () {
    $(".testimonials_slider").hide();
    $(".add_review_form").show();
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