(()=>{var e={693:()=>{jQuery(document).ready((function(e){e(".testimonial_slider_wraper").slick({infinite:!0,slidesToShow:2,slidesToScroll:1,arrows:!0,dots:!1,prevArrow:".slider-newprev",nextArrow:".slider-newnext",responsive:[{breakpoint:768,settings:{slidesToShow:1,slidesToScroll:1}}]}),e(".discount_block").on("click",(function(){e(".discount_block").removeClass("active"),e(this).addClass("active");var t=e(this).find(".product_quantity").text();e('input[name="quantity"]').trigger("focus").val(t).trigger("change").trigger("blur"),e(".cart_item.first>.product-name>.product-quantity").text(t),e(".item_count>.product-quantity").text(t)})),setTimeout((function(){e(".discount_block").first().trigger("click")}),500),e("#deposit-amount").mask("$000,000",{reverse:!1}),e("#deposit-amount").on("mouseleave",(function(){let t=e(this).val().replace(/[$,]/g,"");e('input[name="quantity"]').trigger("focus").val(t).trigger("change").trigger("blur")})),e(".add_deposit").on("click",(function(){let t=e("#deposit-amount").val().replace(/[$,]/g,"");e('input[name="quantity"]').trigger("focus").val(t).trigger("change").trigger("blur"),e("button.single_add_to_cart_button").trigger("click")})),e(".continue_btn").on("click",(function(){var t=e("#custom_link"),o=e("#billing_email"),a=t.val(),c=o.val();""!==a&&/^(http|https):\/\/[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}/.test(a)?(t.parent().removeClass("error"),t.removeClass("error")):(t.parent().addClass("error"),t.addClass("error")),""!==c&&/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/.test(c)?(o.parent().removeClass("error"),o.removeClass("error")):(o.parent().addClass("error"),o.addClass("error")),t.parent().hasClass("error")||o.parent().hasClass("error")||(a=t.val(),c=o.val(),localStorage.setItem("custom_link",a),localStorage.setItem("billing_email",c),e("button.single_add_to_cart_button").trigger("click"))}));var t=localStorage.getItem("custom_link"),o=localStorage.getItem("billing_email");function a(){var t={security:wc_checkout_params.update_order_review_nonce,post_data:e("form.checkout").serialize()};e.ajax({type:"POST",url:wc_checkout_params.wc_ajax_url.toString().replace("%%endpoint%%","update_order_review"),data:t,success:function(t){t&&!0===t.reload?window.location.reload():(e(".woocommerce-NoticeGroup-updateOrderReview").remove(),t&&t.fragments&&jQuery.each(t.fragments,(function(e,t){jQuery(e).replaceWith(t)})),e(document.body).trigger("updated_checkout",[t]))}})}t&&e("#custom_link").val(t),o&&""===e("#billing_email").val()&&e("#billing_email").val(o),e(document).on("mouseenter",".balance_pay",(function(){e("#payment_method_my_balance_payment").trigger("click")})),e(document).on("click",".balance",(function(){e("#payment_method_my_balance_payment").trigger("click"),e("#place_order").trigger("click")})),e(document).on("mouseenter",".card_pay",(function(){e("#payment_method_custom_checkout").trigger("click")})),e(document).on("mouseenter",".payment_method_wc_checkout_com_cards, .pay_order",(function(){e("#payment_method_wc_checkout_com_cards").trigger("click")})),e(document).on("click",".pay_order",(function(){e("#payment_method_wc_checkout_com_cards").trigger("click"),e("#place_order").trigger("click")})),e(document).on("mouseenter",".google_pay",(function(){e("#payment_method_wc_checkout_com_google_pay").trigger("click")})),e(document).on("click",".btn-google",(function(){e("#payment_method_wc_checkout_com_google_pay").trigger("click"),e("#ckocom_googlePay").trigger("click")})),e(document).on("click",".apple_pay",(function(){e("#payment_method_wc_checkout_com_apple_pay").trigger("click"),e("#ckocom_applePay").trigger("click")})),e(document).ajaxComplete((function(e,t,o){if(o.url&&-1!==o.url.indexOf("update_order_review")){let e=document.querySelector(".bonus_total");if(e){let t=e.textContent,o="$"+(1.1*parseFloat(t.replace(/[$,]/g,""))).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g,",");e.textContent=o}}})),e("input, textarea").on("focusin",(function(){e("input").parent().removeClass("active"),e(this).parent().addClass("active")})),e("input, textarea").on("focusout",(function(){e("input, textarea").parent().removeClass("active")})),e(".wpcf7-email, input#your_name, textarea#review").on("focusin",(function(){e("input").parent().parent().removeClass("active"),e(this).parent().parent().addClass("active")})),e(".wpcf7-email, input#your_name, textarea#review").on("focusout",(function(){e(".wpcf7-email, input#your_name, textarea#review").parent().parent().removeClass("active")})),e(".submit_btn").on("click",(function(){e(".wpcf7-submit").trigger("click")})),e(window).on("scroll",(function(){var t=e(".scrollToTop");e(this).scrollTop()<500?t.removeClass("active"):t.addClass("active")})),e(".scrollToTop").on("click",(function(){window.scrollTo({top:0,behavior:"smooth"})})),e(".arrow_down").on("click",(function(){e(".dropdown_products").toggleClass("active")})),e(".cart_item").on("click",(function(){e(".dropdown_products").toggleClass("active")})),e(document).on("click",".btn_apply",(function(){let t=e("input.coupon_input").val();e("input#coupon_code").val(t),e(".checkout_coupon").submit()})),e(".additional_menu_icon").on("click",(function(){e(".account_icon").removeClass("active"),e(".my_account").removeClass("active"),e(this).toggleClass("active"),e(".additional_menu").toggleClass("active")})),e(".account_icon").on("click",(function(){e(".additional_menu_icon").removeClass("active"),e(".additional_menu").removeClass("active"),e(this).toggleClass("active"),e(".my_account").toggleClass("active")})),e("#add_review").on("click",(function(){e(".testimonials_slider").hide(),e(".add_review_form").show()})),e(".close_form").on("click",(function(){e(".testimonials_slider").show(),e(".add_review_form").hide()})),e(".upsale-product").on("click",(function(t){if(t.preventDefault(),e(this).hasClass("active")){var o=e(this).find(".remove-upsale").data("product-id"),c=e(this).find(".remove-upsale").data("quantity");e(this).removeClass("active"),e.ajax({type:"POST",url:woocommerce_params.ajax_url,data:{action:"update_cart_item_quantity",product_id:o,quantity:c},success:function(e){a(),console.log("refresh")}})}else o=e(this).find(".add-upsale").data("product-id"),c=e(this).find(".add-upsale").data("quantity"),e(".upsale-product").removeClass("active"),e(this).addClass("active"),e.ajax({type:"POST",url:woocommerce_params.ajax_url,data:{action:"add_to_cart",product_id:o,quantity:c},success:function(e){a()}})})),e(document).on("click",".add_coupon_title",(function(){e(".dropdown_coupon").toggleClass("active")})),e(document).on("click","ul.woocommerce-SavedPaymentMethods li",(function(){e("ul.woocommerce-SavedPaymentMethods li").removeClass("active"),e(this).toggleClass("active")})),e("#menu-header-mobile li.menu-item-has-children").on("click",(function(){e(this).toggleClass("active")})),e(document).ajaxComplete((function(t,o,a){e("#card_number").mask("9999 9999 9999 9999",{reverse:!1}),window.ApplePaySession?e(".apple_pay").show():e(".apple_pay").hide()})),e(".send_user").on("click",(function(){var t=e("#insta_user").val().trim(),o=e(".user_pop");o.html("").hide(),""===t?console.log("empty"):(e(".send_user .text").hide(),e(".send_user .btn_load").css("display","flex"),e.ajax({type:"POST",url:woocommerce_params.ajax_url,data:{action:"get_instagram",inst_account:t},success:function(t){e(".send_user .text").show(),e(".send_user .btn_load").hide();var a=JSON.parse(t);if(e.isArray(a))e.each(a,(function(t,a){var c=e("<div>").addClass("user_img").attr("data-user-id",a.pk),n=e("<img>").attr("src",a.local_image_path),r=e("<div>").addClass("user_name").text(a.full_name);c.append(n,r),o.html(c),o.show()}));else{console.error("Response data is not an array.");var c=e("<div>").addClass("user_img").text("User not found");o.html(c),o.show()}}}))})),e(document).on("click",".inst_active_posts .user_img",(function(){var t=e(this).data("user-id");if(e(".user_pop").hide(),""===t)console.log("empty");else{e(".get_started_img>img").hide(),e(".get_started_img>.select_posts").show(),e(".photo_load").show();const o=e(".get_started_img").offsetTop-60;window.scrollTo({top:o,behavior:"smooth"}),e.ajax({type:"POST",url:woocommerce_params.ajax_url,data:{action:"get_user_photo",inst_account:t},success:function(t){var o=JSON.parse(t),a=e(".imageBlocks");if(a.html(""),e(".photo_load").hide(),e.isArray(o))e.each(o,(function(t,o){var c=e("<div>").addClass("user_imgs").attr("data-shortcode",o.shortcode),n=e("<img>").attr("src",o.local_image_path);c.append(n),a.append(c)}));else{console.error("Response data is not an array.");var c=e("<div>").addClass("user_photo404").text("User error (private user or etc.)");a.html(c)}}})}})),e(document).on("click",".user_imgs",(function(){e(".user_imgs").removeClass("active"),e(this).addClass("active");let t=e(this).data("shortcode");e("#custom_link").val("https://www.instagram.com/p/"+t)})),e(document).on("click",".inst_active_folowers .user_img",(function(){e(".user_pop").hide();let t=e("#insta_user").val().trim();e("#custom_link").val("https://www.instagram.com/"+t)}))})),document.addEventListener("DOMContentLoaded",(function(){const e=document.querySelectorAll(".tab_title"),t=document.querySelectorAll(".tab_dropdown"),o=document.querySelectorAll(".tab_content"),a=document.querySelectorAll(".tab_wraper");e.forEach((e=>{e.addEventListener("click",(()=>{const c=e.closest(".tab_wraper"),n=c.querySelector(".tab_content"),r=e.querySelector(".tab_dropdown"),i=n.classList.contains("active");a.forEach((e=>{e.classList.remove("active")})),o.forEach((e=>{e.classList.remove("active")})),t.forEach((e=>{e.classList.remove("active")})),i||(n.classList.add("active"),r.classList.add("active"),c.classList.add("active"))}))}));const c=document.querySelector(".custom_buy"),n=new URLSearchParams(window.location.search),r=document.getElementById("checkout"),i=document.querySelector(".single_product");function s(){r&&(r.style.display="flex"),i&&(i.style.display="none")}function l(){r&&(r.style.display="none"),i&&(i.style.display="flex")}c&&c.addEventListener("click",(function(){n.set("show_checkout","1");const e=`${window.location.pathname}?${n.toString()}`;history.pushState(null,null,e),s(),window.scrollTo({top:0,behavior:"smooth"})})),"1"===n.get("show_checkout")?s():l(),window.addEventListener("popstate",(function(e){null===e.state&&l()}));var u=document.querySelector(".price_all .woocommerce-Price-amount"),d=document.querySelector(".cart_item.first .product-total .new_price");const m=document.querySelector("p.price");m&&new MutationObserver((function(e,t){for(let t of e)if("childList"===t.type&&t.target.classList.contains("price")&&(u=document.querySelector(".price_all .woocommerce-Price-amount"))){var o=u.innerHTML;d.innerHTML=o}})).observe(m,{childList:!0,characterData:!0,subtree:!0});const _=document.querySelectorAll(".dropdown_products .cart_item"),p=document.querySelectorAll(".discount_blocks .discount_block");_.forEach((function(e,t){e.addEventListener("click",(function(){const t=e.querySelector(".product-quantity").textContent.match(/\d+/),o=parseInt(t[0]);p.forEach((function(e){const t=parseInt(e.querySelector(".product_quantity").textContent);o===t&&e.click()}))}))}));const v=document.querySelector(".back_btn");v&&v.addEventListener("click",(function(){history.back()}))}));const e=document.querySelector(".woocommerce-MyAccount-navigation ul"),t=document.querySelector(".woocommerce-MyAccount-navigation-link.is-active");if(e&&t){const o=e.offsetWidth;let a=t.offsetLeft+t.offsetWidth/2-o/2;a=Math.max(0,a),e.scrollTo({top:a,behavior:"smooth"})}const o=document.querySelector(".submit_mob");o&&o.addEventListener("click",(function(){const e=document.querySelector(".content_part");if(e){const t=e.offsetTop-60;window.scrollTo({top:t,behavior:"smooth"})}}))}},t={};function o(a){var c=t[a];if(void 0!==c)return c.exports;var n=t[a]={exports:{}};return e[a](n,n.exports,o),n.exports}o.n=e=>{var t=e&&e.__esModule?()=>e.default:()=>e;return o.d(t,{a:t}),t},o.d=(e,t)=>{for(var a in t)o.o(t,a)&&!o.o(e,a)&&Object.defineProperty(e,a,{enumerable:!0,get:t[a]})},o.o=(e,t)=>Object.prototype.hasOwnProperty.call(e,t),(()=>{"use strict";o(693)})()})();