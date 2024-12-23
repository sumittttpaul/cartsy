// WOoCommerce related js
(function ($) {
  "use strict";

  if ($(".cartsy-product-grid-slider").length) {
    new Swiper(".cartsy-product-grid-slider", {
      loop: true,
      slidesPerView: "auto",
      spaceBetween: 0,
      centeredSlides: true,
      speed: 500,
      pagination: {
        el: ".swiper-pagination",
        type: "bullets",
        clickable: true,
      },
      on: {
        init: function () {
          $(".cartsy-grid-thumbnail").addClass("loaded");
        },
      },
    });
  }
})(jQuery);
