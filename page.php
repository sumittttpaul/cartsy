<?php

/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Cartsy
 */

get_header();
?>

<?php
$screenID = $getOptionsFrom = $pageSideBar = $pageContainerClass = $sideBarClass = $sideBarName = '';
$pageSideBar = 'off';
$pageSideBarPosition = 'right';
$displaySideBarClass = 'with-sidebar';
$sideBarName = 'cartsy-sidebar';
$screenID = CartsyGetCurrentPageID();

$getOptionsFrom = !empty(get_post_meta($screenID, '_general_get_option', true)) ? get_post_meta($screenID, '_general_get_option', true) : 'global';
if ($getOptionsFrom !== 'local') {
  if (function_exists('CartsyGlobalOptionData')) {

    if (class_exists('WooCommerce') && (is_woocommerce() || is_cart() || is_account_page() || is_checkout() || is_product())) {
      $pageSideBar  = CartsyGlobalOptionData('woo_sidebar_switch') ? CartsyGlobalOptionData('woo_sidebar_switch') : 'on';
      $pageSideBarPosition  = CartsyGlobalOptionData('woo_sidebar_position');
    } else {
      $pageSideBar  = CartsyGlobalOptionData('page_sidebar');
    }
  }
} else {
  if (function_exists('CartsyLocalOptionData')) {
    $pageSideBar  = CartsyLocalOptionData($screenID, '_page_sidebar', 'true');
  }
}

if (class_exists('WooCommerce') && (is_woocommerce() || is_cart() || is_account_page() || is_checkout())) {
  $sideBarName = 'cartsy-woo-sidebar';
} else {
  $sideBarName = 'cartsy-sidebar';
}

if (is_active_sidebar($sideBarName)) {
  if (!empty($pageSideBar) && $pageSideBar === 'on') {
    $displaySideBarClass = 'with-sidebar';
  } else {
    $displaySideBarClass = 'no-sidebar';
  }
} else {
  $displaySideBarClass = 'no-sidebar';
}



if (!empty($pageSideBarPosition) && $pageSideBarPosition === 'left') {
  $sideBarClass = 'left-sidebar';
}
?>

<div id="primary" class="content-area <?php echo esc_attr($pageContainerClass . ' ' . $displaySideBarClass . ' ' . $sideBarClass); ?>">
  <main id="main" class="site-main">
    <?php
    while (have_posts()) :
      the_post();
      get_template_part('template-parts/content/content', 'page');
      // If comments are open or we have at least one comment, load up the comment template.
      if (comments_open() || get_comments_number()) :
        comments_template();
      endif;
    endwhile; // End of the loop.
    ?>
  </main><!-- #main -->

  <?php
  if (is_active_sidebar('cartsy-sidebar') && (!empty($pageSideBar) && $pageSideBar === 'on')) {
    get_sidebar();
  }
  ?>

</div><!-- #primary -->

<?php
get_footer();
