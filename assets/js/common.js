(function ($) {
  'use strict';

  ImageLazy();
  //Image Lazyload with broken image detector
  function ImageLazy() {
    var lazyImage = $('.cartsy-lazy-image');
    $(document).on('lazyloaded', function () {
      lazyImage.on('error', function () {
        $(this).addClass('image-is-broken');
        $(this).parent().addClass('broken-image-icon');
      });
      lazyImage.each(function () {
        if ($(this).hasClass('lazyloaded')) {
          $(this).parent().removeClass('cartsy-content-loading');
          $(this).siblings('.cartsy-image-loader').remove();
        }
      });
    });
  }
})(jQuery);
