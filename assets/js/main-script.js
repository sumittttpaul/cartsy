(function ($) {
  'use strict';

  init();

  function init() {
    socialShare();
    dynamicQuantityInput();
    productCategorySlider();
    sidebarDrawer();
    showMobileHeaderSearch();
    moveBannerSearchToHeader();
    windowHasScrollbar();
    checkClientUser();
    CartsyNewsletterPopup();
    CartsyFooterCartbarPosition();
  }

  function windowHasScrollbar() {
    if (window.innerWidth > document.body.clientWidth) {
      $('body').addClass('windowHasScrollbar');
    }
  }

  function checkClientUser() {
    if (window.navigator.appVersion.indexOf('Mac') !== -1) {
      $('body').addClass('usingMacOS');
    }
  }

  function socialShare() {
    $('.share-button').simpleSocialShare();
  }

  //Mutation Observer
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

  //ioS device detection
  function iOS() {
    return (
      [
        'iPad Simulator',
        'iPhone Simulator',
        'iPod Simulator',
        'iPad',
        'iPhone',
        'iPod',
      ].includes(navigator.platform) ||
      // iPad on iOS 13 detection
      (navigator.userAgent.includes('Mac') && 'ontouchend' in document)
    );
  }

  // Sidebar custom scrollbar
  var sidebarScrollbar = $('.cartsy-layout-sidebar-scroll')
    .overlayScrollbars({
      autoUpdate: true,
      scrollbars: {
        autoHide: 'leave',
      },
    })
    .overlayScrollbars();

  // Sidebar custom scrollbar
  var menuScrollbar = $('.cartsy-menu-drawer .cartsy-menu-wrapper')
    .overlayScrollbars({
      autoUpdate: true,
      scrollbars: {
        autoHide: 'leave',
      },
    })
    .overlayScrollbars();

  if ($('#redq-quick-view-content').length) {
    onElementInserted('#redq-quick-view-content', '.summary', function () {
      // QuickView Summary Scrollbar
      var summaryScrollbar = $('#redq-quick-view-content .summary')
        .overlayScrollbars({
          autoUpdate: true,
          scrollbars: {
            autoHide: 'leave',
          },
        })
        .overlayScrollbars();

      new Swiper('.quick-view-slider', {
        speed: 400,
        slidesPerView: 1,
        spaceBetween: 0,
        loop: true,
        pagination: {
          el: '.swiper-pagination',
          clickable: true,
        },
      });
    });
  }

  if (iOS()) {
    if ($('.cartsy-layout-sidebar-scroll').length) {
      sidebarScrollbar.destroy();
    }
    if ($('.cartsy-menu-drawer').length) {
      menuScrollbar.destroy();
    }
  }

  // Mobile menu Toggler
  if ($('.cartsy-menu-toggler').length) {
    var menuDrawer = $('.cartsy-menu-drawer');
    var drawerOverlay = $('.cartsy-drawer-overlay');

    $(document).mouseup((e) => {
      if (!$('.cartsy-menu-drawer, .cartsy-menu-drawer *').is(e.target)) {
        $(menuDrawer).removeClass('open');
        $(drawerOverlay).removeClass('show');
      }
    });

    $('.cartsy-menu-toggler').on('click', function () {
      $(menuDrawer).addClass('open');
      $(drawerOverlay).addClass('show');
      $('body').css({
        overflow: 'hidden',
        touchAction: 'none',
      });
      menuScrollbar.update();
    });

    $('.cartsy-menu-drawer-close').on('click', function () {
      $(menuDrawer).removeClass('open');
      $(drawerOverlay).removeClass('show');
      $('body').css({
        overflow: '',
        touchAction: '',
        width: '',
      });
    });
  }

  //Remove scrollbar From body
  $(document).mouseup((e) => {
    if (
      !$(
        '.cartsy-menu-drawer, .cartsy-menu-drawer *, .cartsy-mini-cart, .cartsy-mini-cart *, .cartsy-layout-sidebar, .cartsy-layout-sidebar *, #redq-quick-view-modal, #redq-quick-view-modal *'
      ).is(e.target)
    ) {
      $('body').css({
        overflow: '',
        touchAction: '',
        width: '',
      });
    }
  });

  // Mobile Menu
  if ($('.cartsy-main-menu').length) {
    $('.cartsy-main-menu .menu-item-has-children>.menu-drop-down-selector').on(
      'click',
      function (e) {
        e.preventDefault();

        $(this).toggleClass('children-active');
        $(this).siblings('ul').slideToggle();
        $(this).attr('title') == 'open'
          ? $(this).attr('title', 'close')
          : $(this).attr('title', 'open');
      }
    );
  }

  // Accordion
  if ($('.cartsy-accordion').length) {
    $('.cartsy-accordion').accordion({
      collapsible: true,
      active: false,
      heightStyle: 'content',
      header: '.cartsy-accordion-title',
      icons: {
        header: 'ion ion-md-add',
        activeHeader: 'ion ion-md-remove',
      },
    });
  }

  // Post Gallery
  if ($('.cartsy-post-gallery').length) {
    $('.cartsy-post-gallery').each(function (index) {
      var gallerySlider = $(this).children('.swiper-container');
      var nextEl = $(this).find('.cartsy-post-gallery-next');
      var prevEl = $(this).find('.cartsy-post-gallery-prev');

      gallerySlider = gallerySlider.addClass('cartsy-gallery-slider-' + index);
      nextEl = nextEl.addClass('index-' + index);
      prevEl = prevEl.addClass('index-' + index);

      new Swiper(gallerySlider, {
        loop: true,
        slidesPerView: 'auto',
        spaceBetween: 0,
        speed: 500,
        autoHeight: true,
        navigation: {
          nextEl: nextEl,
          prevEl: prevEl,
        },
      });
    });
  }

  //Product Single Layout One Mobile Slider
  if ($('.layout-one-mobile-slider').length) {
    new Swiper('.layout-one-mobile-slider', {
      speed: 400,
      slidesPerView: 1,
      spaceBetween: 0,
      autoHeight: true,
      pagination: {
        el: '.swiper-pagination',
        clickable: true,
      },
      breakpoints: {
        767: {
          slidesPerView: 2,
          spaceBetween: 15,
        },
      },
    });
  }

  // Header position observer
  function scrollPositionObserver() {
    var header = $('.cartsy-menu-area');
    var body = $('body');
    var scrollPosition = $(window).scrollTop();
    if (scrollPosition >= 30) {
      header.addClass('header-on-float');
      body.addClass('cartsy-on-scroll');
    } else {
      header.removeClass('header-on-float');
      body.removeClass('cartsy-on-scroll');
    }
  }

  // FitVid
  if ($('.post .entry-media').length) {
    $('.post .entry-media').fitVids();
  }

  // Woocommerce product gallery thumb carousel
  function productGalleryThumbSlider() {
    var productGalleryThumb = $(
      '.woocommerce-product-gallery--with-images .flex-control-thumbs'
    );
    productGalleryThumb.addClass('swiper-container');
    $('<div class="swiper-wrapper">').insertBefore(
      '.flex-control-thumbs li:first-child'
    );
    $('.flex-control-thumbs li').appendTo('.swiper-wrapper');
    $('.flex-control-thumbs li').addClass('swiper-slide');
    $(
      '<div class="swiper-button-prev"></div><div class="swiper-button-next"></div>'
    ).insertAfter('.swiper-wrapper');

    if (productGalleryThumb.length) {
      new Swiper('.flex-control-thumbs', {
        spaceBetween: 10,
        slidesPerView: 5,

        navigation: {
          nextEl: '.swiper-button-next',
          prevEl: '.swiper-button-prev',
        },
      });
    }
  }

  // Window on load functions here
  $(window).on('load', function () {
    //init scroll position observer
    scrollPositionObserver();
    //init sticky scroll to content
    if ($('.cartsy-scroll-to-content-nav').length) stickyScrollSidebar();
    // init Woocommerce product gallery thumb carousel
    productGalleryThumbSlider();
    //init mini cart dropdown
    miniCartDropdown();

    //language switcher dropdown
    $('.cartsy-active-lang').on('click', function () {
      $('.cartsy-language-switcher-list').toggleClass('show');
    });
    $(document).mouseup((e) => {
      if (
        !$(
          '.cartsy-language-switcher-list, .cartsy-language-switcher-list *'
        ).is(e.target)
      ) {
        $('.cartsy-language-switcher-list').removeClass('show');
      }
    });

    //Move search from to header
    if (
      !$('.cartsy-product-search-form.position-banner').length &&
      $('.cartsy-product-search-form.position-header').length
    ) {
      $('.cartsy-product-search-form.position-header').appendTo(
        $('.cartsy-header-search-form')
      );
    }

    //Site preloader
    $('.cartsy-site-preloader').fadeOut();

    // Check if woocommerce store notice is visible
    if (
      $('.woocommerce-store-notice').length &&
      $('.woocommerce-store-notice').is(':visible')
    ) {
      $('#page, .cartsy-menu-area').css({
        marginTop: $('.woocommerce-store-notice')[0].getBoundingClientRect()
          .height,
      });
      $(':root')[0].style.setProperty(
        '--store-notice-height',
        $('.woocommerce-store-notice').outerHeight() + 'px'
      );

      $('.woocommerce-store-notice__dismiss-link').on('click', function () {
        $('#page, .cartsy-menu-area').css({
          marginTop: '',
        });
        $(':root')[0].style.setProperty('--store-notice-height', '');
      });
    }

    //sticky category button offset
    var stickyCategoryButton = $(
      '.cartsy-show-sidebar-category.sticky-on-mobile'
    );
    if (stickyCategoryButton.length && $(window).width() < 1024) {
      $('.cartsy-show-sidebar-category-wrap').css({
        minHeight: stickyCategoryButton.innerHeight(),
      });
    }
  });

  // Banner to header input form focus detection
  $('.cartsy-product-search-form-input')
    .blur(function () {
      $('.cartsy-product-search-form-input').removeClass('input-is-focused');
    })
    .focus(function () {
      $(this).addClass('input-is-focused');
    });

  // Window on scroll functions here
  var lastScrollTop = 0;
  $(window).on('scroll', function () {
    var scrollPosition = $(window).scrollTop();
    var adminBarHeight = $('#wpadminbar').outerHeight();
    var menuAreaHeight = $('.cartsy-menu-area').outerHeight();
    var categoryButton = $('.cartsy-show-sidebar-category.sticky-on-mobile');

    //Move banner search to header
    if (
      $('.cartsy-product-search-form.position-banner').length &&
      $(window).width() > 1024
    ) {
      var bannerSearch = $('.cartsy-banner-search-form');
      var headerSearch = $('.cartsy-header-search-form');
      var bannerSearchForm = $(
        '.cartsy-banner-search-form .cartsy-product-search-form.position-banner'
      );
      var headerSearchForm = $(
        '.cartsy-header-search-form .cartsy-product-search-form.position-banner'
      );
      var bannerSearchOffset =
        Math.floor(bannerSearch.offset().top) -
        (adminBarHeight + menuAreaHeight);
      var isInputFocused = false;

      if (scrollPosition < lastScrollTop) {
        if (scrollPosition <= bannerSearchOffset) {
          if (
            $(
              '.cartsy-product-search-form-cartsy-product-search-form-input.input-is-focused'
            ).length
          ) {
            isInputFocused = true;
          }
          headerSearchForm.appendTo(bannerSearch);
          isInputFocused ? $('.cartsy-product-search-form-input').focus() : '';
        }
      } else {
        if (scrollPosition > bannerSearchOffset) {
          if ($('.cartsy-product-search-form-input.input-is-focused').length) {
            isInputFocused = true;
          }
          bannerSearchForm.appendTo(headerSearch);
          isInputFocused ? $('.cartsy-product-search-form-input').focus() : '';
        }
      }
      lastScrollTop = scrollPosition;
    }

    //Layout Sidebar position
    if (
      $('.cartsy-layout-sidebar').length &&
      $('footer .site-info').length &&
      $(window).width() > 1024
    ) {
      var footerCopyright = $('footer .site-info');
      var elementTop = footerCopyright.offset().top;
      var elementBottom =
        footerCopyright.offset().top + footerCopyright.outerHeight();
      var bottomOfScreen = $(window).scrollTop() + $(window).innerHeight();
      var topOfScreen = $(window).scrollTop();
      if (bottomOfScreen > elementTop && topOfScreen < elementBottom) {
        $('.cartsy-layout-sidebar-inner').css({
          paddingBottom: footerCopyright.outerHeight(),
        });
      } else {
        $('.cartsy-layout-sidebar-inner').css({
          paddingBottom: '',
        });
      }
    }

    //Category button sticky on mobile
    if (
      scrollPosition > 40 &&
      categoryButton.length &&
      $(window).width() < 1024
    ) {
      categoryButton.addClass('stick-to-top');
      $(':root')[0].style.setProperty(
        '--sticky-category-button-position',
        menuAreaHeight + 'px'
      );
      $('.cartsy-menu-area').css({ boxShadow: 'none' });
    } else {
      categoryButton.removeClass('stick-to-top');
      $('.cartsy-menu-area').css({ boxShadow: '' });
    }

    scrollPositionObserver();
  });

  //move search banner to header on mobile
  function moveBannerSearchToHeader() {
    if ($('.cartsy-banner-search-form').length && $(window).width() <= 1024) {
      $('.cartsy-banner-search-form .cartsy-product-search-form').appendTo(
        $('.cartsy-header-search-form')
      );
    }
  }
  if ($('.cartsy-product-search-form').length) {
    $('.cartsy-header-search-button').css({ display: '' });
    $('.site-branding').addClass('mr-left-large');
  }

  //Window onresize functions
  $(window).on('resize', function () {
    moveBannerSearchToHeader();
  });

  // Cart Dropdown
  function miniCartDropdown() {
    $('.mobile-cart-link, .cartsy-mini-cart-dropdown-btn').on(
      'click',
      function (e) {
        e.preventDefault();
        $('.cartsy-mini-cart').addClass('open');
        $('.cartsy-mini-cart-overlay').addClass('show');
        $('body').addClass('cartsy-mini-cart-open');
      }
    );
    $(document).mouseup((e) => {
      if (!$('.cartsy-mini-cart, .cartsy-mini-cart *').is(e.target)) {
        $('.cartsy-mini-cart').removeClass('open');
        $('.cartsy-mini-cart-overlay').removeClass('show');
        $('body').removeClass('cartsy-mini-cart-open');
      }
    });
    $('.cartsy-mini-cart-close, .cartsy-mini-cart-overlay').on(
      'click',
      function () {
        $('.cartsy-mini-cart').removeClass('open');
        $('.cartsy-mini-cart-overlay').removeClass('show');
        $('body').removeClass('cartsy-mini-cart-open');
        $('body').css({
          overflow: '',
          touchAction: '',
          width: '',
        });
      }
    );
  }

  //Mini Cart custom scrollbar
  onElementInserted('body', '.cartsy-mini-cart-items', function () {
    var scrollbar = $('.cartsy-mini-cart-items')
      .overlayScrollbars({
        scrollbars: {
          autoHide: 'leave',
        },
        callbacks: {
          onScroll: function (e) {
            var container = $('.cartsy-mini-cart-items');
            var scrollHeight = this.scroll().max.y - 20;
            var scrollPosition = this.scroll().position.y;
            if (scrollPosition >= scrollHeight) {
              container.removeClass('bottom-shadow');
            } else if (scrollPosition < 20) {
              container.removeClass('top-shadow');
            } else {
              container.addClass('top-shadow');
              container.addClass('bottom-shadow');
            }
          },
          onUpdated: function () {
            var container = $('.cartsy-mini-cart-items');
            var scrollHeight = this.scroll().max.y;
            var containerHeight = container.prop('scrollHeight');
            if (scrollHeight > containerHeight) {
              container.addClass('bottom-shadow');
            }
          },
        },
      })
      .overlayScrollbars();

    $('.cartsy-mini-cart-total a').on('click', function (e) {
      $(this).addClass('load');
    });
  });

  //Sidebar drawer
  function sidebarDrawer() {
    var layoutSidebar = $('.cartsy-layout-sidebar');
    $('.cartsy-show-sidebar-category').on('click', function () {
      $('body').css({
        overflow: 'hidden',
        touchAction: 'none',
      });

      layoutSidebar.addClass('show-sidebar');
    });
    $('.cartsy-layout-sidebar-close, .cartsy-category-clear').on(
      'click',
      function () {
        $('body').css({
          overflow: '',
          touchAction: '',
          width: '',
        });
        layoutSidebar.removeClass('show-sidebar');
      }
    );
    $(document).mouseup((e) => {
      if (!$('.cartsy-layout-sidebar, .cartsy-layout-sidebar *').is(e.target)) {
        layoutSidebar.removeClass('show-sidebar');
      }
    });
  }

  // Dynamic Quantity input
  function dynamicQuantityInput() {
    $('.quantity').each(function () {
      // Append custom increment/decrement button
      if ($(this).children('.quantity-btn-wrapper').length === 0) {
        $(
          '<div class="quantity-btn-wrapper"><div class="quantity-btn quantity-btn-up"><i class="ion ion-ios-add"></i></div><div class="quantity-btn quantity-btn-down"><i class="ion ion-ios-remove"></i></div></div>'
        ).insertAfter('.quantity input');
      }

      var counterWrapper = jQuery(this),
        input = counterWrapper.find('input[type="number"]'),
        onBtnUp = counterWrapper.find('.quantity-btn-up'),
        onBtnDown = counterWrapper.find('.quantity-btn-down'),
        step = parseInt(input.attr('step')),
        min = input.attr('min'),
        max = input.attr('max') === '' ? 10000 : input.attr('max');

      var inputValue = input.val() === '' ? 0 : input.val();

      input.val(inputValue);

      onBtnUp.off('click').on('click', function () {
        var oldValue = parseFloat(input.val());
        if (oldValue >= max) {
          var newVal = oldValue;
        } else {
          if (step) {
            var newVal = oldValue + step;
          } else {
            var newVal = oldValue + 1;
          }
        }
        counterWrapper.find('input').val(newVal);
        counterWrapper.find('input').trigger('change');
      });

      onBtnDown.off('click').on('click', function () {
        var oldValue = parseFloat(input.val());
        if (oldValue <= min) {
          var newVal = oldValue;
        } else {
          if (step) {
            var newVal = oldValue - step;
          } else {
            var newVal = oldValue - 1;
          }
        }
        counterWrapper.find('input').val(newVal);
        counterWrapper.find('input').trigger('change');
      });
    });
  }

  function productCategorySlider() {
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
  }

  //Show mobile header search
  function showMobileHeaderSearch() {
    $('.cartsy-header-search-button').on('click', function () {
      $('.cartsy-header-search-form').addClass('show-mobile-search');
    });
    $(document).mouseup((e) => {
      if (
        !$('.cartsy-header-search-form, .cartsy-header-search-form *').is(
          e.target
        )
      ) {
        $('.cartsy-header-search-form').removeClass('show-mobile-search');
      }
    });
  }

  //Sticky Scroll to content sidebar
  function stickyScrollSidebar() {
    var menuareaHeight = $('.cartsy-menu-area').outerHeight();
    var adminBarHeight = $('#wpadminbar').outerHeight();
    var offset = menuareaHeight + adminBarHeight + 40;

    var stickyNav = new StickySidebar('.cartsy-scroll-to-content-nav', {
      topSpacing: offset,
      bottomSpacing: 30,
      resizeSensor: true,
    });
  }

  // Run This function after woocommerce cart ajax complete
  onElementInserted('body', '.quantity', function () {
    if (!$('.rnb-layout-one').length) {
      dynamicQuantityInput();
    }
  });

  // cartsy newsletter popup
  function CartsyNewsletterPopup() {
    if ($('.cartsy-newsletter-popup-wrap').length) {
      var popupWrapper = $('.cartsy-newsletter-popup-wrap');
      var closeButton = $('.cartsy-newsletter-close');

      // init cartsy newsletter popup session
      if (!window.sessionStorage.getItem('cartsyNewsletterPopup')) {
        window.sessionStorage.setItem('cartsyNewsletterPopup', true);
      }

      // add active popup class when window scroll > 500 and session is true
      $(window).on('scroll', function () {
        var scrollFromTop = window.scrollY;
        if (
          scrollFromTop > 500 &&
          window.sessionStorage.getItem('cartsyNewsletterPopup') === 'true'
        ) {
          popupWrapper.addClass('show-newsletter');
          $('body').addClass('freeze-body-scroll');
        }
      });

      // close newsletter popup when click on x button
      closeButton.on('click', function () {
        popupRemoveClass();
      });

      // close newsletter popup when click on window
      $(window).on('click', function () {
        popupRemoveClass();
      });

      // prevent close popup when click on newsletter popup body
      $('.cartsy-newsletter-body').on('click', function (e) {
        e.stopPropagation();
      });

      // remove active popup class and set session to false
      function popupRemoveClass() {
        popupWrapper.removeClass('show-newsletter');
        $('body').removeClass('freeze-body-scroll');
        window.sessionStorage.setItem('cartsyNewsletterPopup', false);
      }
    }
  }

  // cartsy footer cart bar position set when it reached to the bottom
  function CartsyFooterCartbarPosition() {
    if ($('.cartsy-mini-cart-widget .site-footer-cart').length) {
      var $footerCartbar = $(
        '.cartsy-mini-cart-widget .site-footer-cart .cartsy-mini-cart-dropdown-btn'
      );
      $('body').addClass('cartsy-cart-variation-footer');
      window.onscroll = function () {
        if (window.innerHeight + window.scrollY >= document.body.offsetHeight) {
          $footerCartbar.addClass('on-the-footer');
        } else {
          $footerCartbar.removeClass('on-the-footer');
        }
      };
    }
  }

  // RnB product single page gallery
  var rnbGalleryThumbs = new Swiper('.rnb-product-gallery-thumb', {
    spaceBetween: 10,
    slidesPerView: 4,
    freeMode: true,
    watchSlidesVisibility: true,
    watchSlidesProgress: true,
    breakpoints: {
      768: {
        slidesPerView: 8,
      },
      1200: {
        slidesPerView: 6,
      },
      1400: {
        slidesPerView: 8,
      },
      1800: {
        slidesPerView: 12,
      },
    },
  });
  var rnbGalleryTop = new Swiper('.rnb-product-gallery', {
    autoHeight: true,
    slidesPerView: 1,
    thumbs: {
      swiper: rnbGalleryThumbs,
    },
  });
})(jQuery);
