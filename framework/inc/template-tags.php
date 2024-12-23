<?php

/**
 * Custom template tags for this theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Cartsy
 */


if (!function_exists('cartsy_post_meta')) :
  /**
   * cartsy_post_meta
   *
   * @return void
   */
  function cartsy_post_meta()
  {
    $numberOfComment  = get_comments_number();
    $comment          = $numberOfComment > 1 ? $numberOfComment . ' comments' : $numberOfComment . ' comment';
    $allowedHTML      = wp_kses_allowed_html('post');
    $html             = '';

    $html .= '<span class="date"><time>' . get_the_date() . '</time></span>';
    if ($numberOfComment > 0) {
      $html .= '<span class="number-of-comment"> ' . wp_kses($comment, $allowedHTML) . '</span>';
    }

    echo wp_kses($html, $allowedHTML);
  }
endif;


if (!function_exists('cartsy_post_thumbnail')) {
  /**
   * cartsy_post_thumbnail
   *
   * @return void
   */
  function cartsy_post_thumbnail()
  {
    $allowedHTML     = wp_kses_allowed_html('post');
    $html            = '';

    if (post_password_required() || is_attachment() || !has_post_thumbnail()) {
      return;
    }
    if (is_singular()) {
      $html .= '<div class="post-thumbnail">';
      $html .= the_post_thumbnail();
      $html .= '</div>';
    } else {
      $html .= '<a class="post-thumbnail" href="' . get_the_permalink() . '" aria-hidden="true" tabindex="-1">';
      $html .= the_post_thumbnail('post-thumbnail', array(
        'alt' => the_title_attribute(array(
          'echo' => false,
        )),
      ));
      $html .= '</a>';
    }

    echo wp_kses($html, $allowedHTML);
  }
}



if (!function_exists('cartsy_post_navigation')) {
  /**
   * cartsy_post_navigation
   *
   * @return void
   */
  function cartsy_post_navigation()
  {
    $prevPost       = get_previous_post();
    $nextPost       = get_next_post();
    $allowedHTML    = wp_kses_allowed_html('post');
    $html           = '';

    if ($prevPost || $nextPost) {
      $html .= '<nav class="navigation post-navigation">';
      $html .= '<div class="nav-links">';
      if ($prevPost) {
        $html .= '<a class="nav-previous" href="' . esc_url(get_permalink($prevPost->ID)) . '">';
        $html .= '<div class="thumb-img">' . get_the_post_thumbnail($prevPost->ID, array(90, 90)) . '</div>';
        $html .= '<div class="nav-text">';
        $html .= '<h5>' . $prevPost->post_title . '</h5>';
        $html .= '<p>' . esc_html__('Previous', 'cartsy') . '</p>';
        $html .= '</div>';
        $html .= '</a>';
      }
      if ($prevPost && $nextPost) {
        $html .= '<span class="hr-bar"></span>';
      }
      if ($nextPost) {
        $html .= '<a class="nav-next" href="' . esc_url(get_permalink($nextPost->ID)) . '">';
        $html .= '<div class="nav-text">';
        $html .= '<h5>' . $nextPost->post_title . '</h5>';
        $html .= '<p>' . esc_html__('Next', 'cartsy') . '</p>';
        $html .= '</div>';
        $html .= '<div class="thumb-img">' . get_the_post_thumbnail($nextPost->ID, array(90, 90)) . '</div>';
        $html .= '</a>';
      }
      $html .= '</div>';
      $html .= '</nav>';
    }

    echo wp_kses($html, $allowedHTML);
  }
}


if (!function_exists('cartsy_post_gallery_slider')) {
  /**
   * cartsy_post_gallery_slider
   *
   * @return void
   */
  function cartsy_post_gallery_slider()
  {
    $gallery        = get_post_gallery(get_the_ID(), false);
    $allowedHTML    = wp_kses_allowed_html('post');
    $html           = '';
    if (!isset($gallery['src'])) return;

    $html .= '<div class="cartsy-post-gallery">';
    $html .= '<div class="swiper-container">';
    $html .= '<div class="swiper-wrapper">';
    foreach ($gallery['src'] as $src) {
      $html .= '<div class="swiper-slide">';
      $html .= '<div class="cartsy-post-gallery-item">';
      $html .= '<img src="' . esc_attr($src) . '" class="gallery-img" alt="Gallery image" />';
      $html .= '</div>';
      $html .= '</div>';
    }
    $html .= '</div>';
    $html .= '</div>';
    // end of .swiper-container
    $html .= '<div class="cartsy-post-gallery-prev">';
    $html .= '<i class="ion ion-ios-arrow-back"></i>';
    $html .= '</div>';
    // end of .cartsy-post-gallery-prev
    $html .= '<div class="cartsy-post-gallery-next">';
    $html .= '<i class="ion ion-ios-arrow-forward"></i>';
    $html .= '</div>';
    // end of .cartsy-post-gallery-next
    $html .= '</div>';

    echo wp_kses($html, $allowedHTML);
  }
}


if (!function_exists('cartsy_allowed_iframe_html')) {
  /**
   * cartsy_allowed_iframe_html
   *
   * @return void
   */
  function cartsy_allowed_iframe_html()
  {
    return array(
      'iframe' => array(
        'title' => array(),
        'width' => array(),
        'height' => array(),
        'scrolling' => array(),
        'frameborder' => array(),
        'allowfullscreen' => array(),
        'allow' => array(),
        'name' => array(),
        'src' => array(),
      ),
    );
  }
}
