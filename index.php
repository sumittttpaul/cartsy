<?php

/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Cartsy
 */

get_header();
?>

<?php
$screenID = $getOptionsBlog = $blogBanner = $sideBarClass =  '';
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

    if (have_posts()) :

      if (is_home() && !is_front_page()) :
    ?>
        <header>
          <h1 class="page-title screen-reader-text"><?php single_post_title(); ?></h1>
        </header>
    <?php
      endif;

      /* Start the Loop */
      while (have_posts()) :
        the_post();
        get_template_part('template-parts/content/content', get_post_type());
      endwhile;

      /* Start the post navigation */
      the_posts_navigation(array(
        'mid_size' => 2,
        'prev_text' => '<i class="icon ion-ios-arrow-round-back"></i>' . esc_html__('Previous', 'cartsy'),
        'next_text' =>  esc_html__('Next', 'cartsy') . '<i class="icon ion-ios-arrow-round-forward"></i>',
      ));

    else :

      get_template_part('template-parts/content/content', 'none');

    endif;
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
