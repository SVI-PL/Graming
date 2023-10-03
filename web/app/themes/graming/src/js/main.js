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
    $(".get_started").addClass("hidden");
    $(".payment_wraper").addClass("active");
  });
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
