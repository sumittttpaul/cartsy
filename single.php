<?php

/**
 * The template for displaying all single posts
 *
 * @package Cartsy
 */

get_header();

$screenID = $getOptionsBlog = $blogBanner = $sideBarClass = '';
$displaySideBar  = 'off';
$sideBarPosition = 'right';
$displaySideBarClass = 'with-sidebar';
$sideBarName = 'cartsy-sidebar';
$screenID = CartsyGetCurrentPageID();
$getOptionsBlog = !empty(get_post_meta($screenID, '_blog_get_option', true)) ? get_post_meta($screenID, '_blog_get_option', true) : 'global';

if ($getOptionsBlog !== 'local') {
  if (function_exists('CartsyGlobalOptionData')) {
    $displaySideBar       = CartsyGlobalOptionData('blog_sidebar_switch');
  }
} else {
  if (function_exists('CartsyLocalOptionData')) {
    $displaySideBar       = CartsyLocalOptionData($screenID, '_blog_sidebar_switch', true);
  }
}


if (class_exists('WooCommerce') && (is_woocommerce() || is_cart() || is_account_page() || is_checkout())) {
  $sideBarName = 'cartsy-woo-sidebar';
} else {
  $sideBarName = 'cartsy-sidebar';
}

if (is_active_sidebar($sideBarName)) {
  if (!empty($displaySideBar) && $displaySideBar === 'on') {
    $displaySideBarClass = 'with-sidebar';
  } else {
    $displaySideBarClass = 'no-sidebar';
  }
} else {
  $displaySideBarClass = 'no-sidebar';
}


if (!empty($sideBarPosition) && $sideBarPosition === 'left') {
  $sideBarClass = 'left-sidebar';
}
?>

<div id="primary" class="content-area <?php echo esc_attr($displaySideBarClass . ' ' . $sideBarClass); ?>">
  <main id="main" class="site-main">
    <?php
    while (have_posts()) :
      the_post();
      get_template_part('template-parts/content/content', 'single');
      // If comments are open or we have at least one comment, load up the comment template.
      if (comments_open() || get_comments_number()) :
        comments_template();
      endif;

    endwhile; // End of the loop.
    ?>

  </main><!-- #main -->

  <?php
  if (is_active_sidebar('cartsy-sidebar') && (!empty($displaySideBar) && $displaySideBar === 'on')) {
    get_sidebar();
  }
  ?>

</div><!-- #primary -->

<?php
get_footer();
