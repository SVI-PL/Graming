jQuery(document).ready(function ($) {
  //Sticky header
  $(window).scroll(function () {
    let $menuClass = ".menu"; 
    var winTop = $(window).scrollTop();
    if (winTop >= 64) {
      $($menuClass).addClass("sticky-header");
    } else {
      $($menuClass).removeClass("sticky-header");
    }
  });
  //end jq
});