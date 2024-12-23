<?php

/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package Cartsy
 */

get_header();
?>

<?php
$screenID = $getOptionsBlog = $blogBanner = $sideBarClass = '';
$displaySideBar = 'on';
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


if (is_woocommerce() || is_cart() || is_account_page() || is_checkout()) {
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

    <?php if (have_posts()) :

      /* Start the Loop */
      while (have_posts()) :
        the_post();

        /**
         * Run the loop for the search to output the results.
         * If you want to overload this in a child theme then include a file
         * called content-search.php and that will be used instead.
         */
        get_template_part('template-parts/content/content-search', 'search');

      endwhile;

      the_posts_navigation(array(
        'mid_size' => 2,
        'prev_text' => '<i class="icon ion-ios-arrow-round-back"></i>' . esc_html__('Previous', 'cartsy'),
        'next_text' =>  esc_html__('Next', 'cartsy') . '<i class="icon ion-ios-arrow-round-forward"></i>',
      ));

    else :

      get_template_part('template-parts/content/content-none', 'none');

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
