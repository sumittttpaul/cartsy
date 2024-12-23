(function ($) {
  'use strict';

  $(document).ready(function () {
    $('#cartsy_welcome_tour_video').fitVids();

    $('#cartsy_getting_started_faq').accordion({
      collapsible: true,
      header: '.cartsy-getting-started-faq-header',
      heightStyle: 'content',
      create: function () {
        $('.cartsy-getting-started-faq-header').find('.ui-icon').remove();
      },
    });

    $('.cartsy-getting-started-faq-header').each(function () {
      if ($(this).hasClass('ui-accordion-header-active')) {
        $(this)
          .children('.faq-header-icon-expand')
          .removeClass('show')
          .addClass('hide');
        $(this)
          .children('.faq-header-icon-collapse')
          .removeClass('hide')
          .addClass('show');
      } else {
        $(this)
          .children('.faq-header-icon-expand')
          .removeClass('hide')
          .addClass('show');
        $(this)
          .children('.faq-header-icon-collapse')
          .removeClass('show')
          .addClass('hide');
      }
    });

    $(document).on('click', '.cartsy-getting-started-faq-header', function () {
      $(this)
        .parents('#cartsy_getting_started_faq')
        .find('.faq-header-icon-expand')
        .removeClass('hide')
        .addClass('show');

      $(this)
        .parents('#cartsy_getting_started_faq')
        .find('.faq-header-icon-collapse')
        .removeClass('show')
        .addClass('hide');

      if ($(this).hasClass('ui-accordion-header-active')) {
        $(this)
          .find('.faq-header-icon-expand')
          .removeClass('show')
          .addClass('hide');

        $(this)
          .find('.faq-header-icon-collapse')
          .removeClass('hide')
          .addClass('show');
      } else {
        $(this)
          .find('.faq-header-icon-expand')
          .removeClass('hide')
          .addClass('show');

        $(this)
          .find('.faq-header-icon-collapse')
          .removeClass('show')
          .addClass('hide');
      }
    });
  });

  //Category Slider
  function onElementInserted(containerSelector, elementSelector, callback) {
    var onMutationsObserved = function (mutations) {
      mutations.forEach(function (mutation) {
        if (mutation.addedNodes.length) {
          var elements = $(mutation.addedNodes).find(elementSelector);
          for (var i = 0, len = elements.length; i < len; i++) {
            callback(elements[i]);
          }
        }
      });
    };

    var target = $(containerSelector)[0];
    var config = { childList: true, subtree: true };
    var MutationObserver =
      window.MutationObserver || window.WebKitMutationObserver;
    var observer = new MutationObserver(onMutationsObserved);
    observer.observe(target, config);
  }

  onElementInserted('body', '.product-category-slider', function () {
    const template = $('.cartsy-product-categories').data('template');
    let spaceBetween, slidesPerView;
    switch (template) {
      case 'boxed':
        spaceBetween = {
          device_mobile: 10,
          device_440: 10,
          device_575: 10,
          device_800: 10,
          device_1100: 10,
          device_1300: 10,
          device_1500: 10,
          device_1600: 10,
          device_1800: 10,
        };
        slidesPerView = {
          device_mobile: 2,
          device_440: 4,
          device_575: 4,
          device_800: 5,
          device_1100: 6,
          device_1300: 7,
          device_1500: 8,
          device_1600: 9,
          device_1800: 10,
        };
        break;

      case 'list':
        spaceBetween = {
          device_mobile: 15,
          device_440: 15,
          device_575: 15,
          device_800: 15,
          device_1100: 15,
          device_1300: 15,
          device_1500: 15,
          device_1600: 15,
          device_1800: 15,
        };
        slidesPerView = {
          device_mobile: 1,
          device_440: 2,
          device_575: 2,
          device_800: 3,
          device_1100: 4,
          device_1300: 4,
          device_1500: 5,
          device_1600: 5,
          device_1800: 5,
        };
        break;

      case 'boxed_plus':
        spaceBetween = {
          device_mobile: 15,
          device_440: 15,
          device_575: 15,
          device_800: 15,
          device_1100: 30,
          device_1300: 30,
          device_1500: 30,
          device_1600: 30,
          device_1800: 30,
        };
        slidesPerView = {
          device_mobile: 2,
          device_440: 2,
          device_575: 3,
          device_800: 4,
          device_1100: 5,
          device_1300: 6,
          device_1500: 6,
          device_1600: 6,
          device_1800: 6,
        };
        break;

      default:
        spaceBetween = 10;
        slidesPerView = {
          device_mobile: 2,
          device_440: 4,
          device_575: 4,
          device_800: 5,
          device_1100: 6,
          device_1300: 7,
          device_1500: 8,
          device_1600: 9,
          device_1800: 10,
        };
        break;
    }

    new Swiper('.product-category-slider', {
      spaceBetween: spaceBetween.device_mobile,
      slidesPerView: slidesPerView.device_mobile,
      observer: true,
      observeParents: true,
      navigation: {
        nextEl: '.product-category-slider-next',
        prevEl: '.product-category-slider-prev',
      },
      breakpoints: {
        440: {
          spaceBetween: spaceBetween.device_440,
          slidesPerView: slidesPerView.device_440,
        },
        575: {
          spaceBetween: spaceBetween.device_575,
          slidesPerView: slidesPerView.device_575,
        },
        800: {
          spaceBetween: spaceBetween.device_800,
          slidesPerView: slidesPerView.device_800,
        },
        1100: {
          spaceBetween: spaceBetween.device_1100,
          slidesPerView: slidesPerView.device_1100,
        },
        1300: {
          spaceBetween: spaceBetween.device_1300,
          slidesPerView: slidesPerView.device_1300,
        },
        1500: {
          spaceBetween: spaceBetween.device_1500,
          slidesPerView: slidesPerView.device_1500,
        },
        1600: {
          spaceBetween: spaceBetween.device_1600,
          slidesPerView: slidesPerView.device_1600,
        },
        1800: {
          spaceBetween: spaceBetween.device_1800,
          slidesPerView: slidesPerView.device_1800,
        },
      },
    });
  });
})(jQuery);
