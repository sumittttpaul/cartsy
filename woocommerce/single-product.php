<?php

/**
 * The Template for displaying all single products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce/Templates
 * @version     1.6.4
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

get_header();

remove_action('woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);
remove_action('woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);

$getOptionsBlog = $blogBanner = $sideBarClass = '';
$displaySideBar = 'off';
$sideBarPosition = 'right';
$displaySideBarClass = 'with-sidebar';

if (function_exists('CartsyGlobalOptionData')) {
    $displaySideBar  = !empty(CartsyGlobalOptionData('woo_single_sidebar_switch')) ? CartsyGlobalOptionData('woo_single_sidebar_switch') : 'off';
    $sideBarPosition = !empty(CartsyGlobalOptionData('woo_single_sidebar_position')) ? CartsyGlobalOptionData('woo_single_sidebar_position') : "right";
}

if (is_active_sidebar('cartsy-woo-sidebar')) {
    if (!empty($displaySideBar) && $displaySideBar === 'on') {
        $displaySideBarClass = 'with-sidebar';
    } else {
        $displaySideBarClass = 'no-sidebar';
    }
} else {
    $displaySideBarClass = 'no-sidebar';
}

if ($sideBarPosition == 'left') {
    $sideBarClass = 'left-sidebar';
} else {
    $sideBarClass = 'right-sidebar';
}
?>

<div id="primary" class="content-area <?php echo esc_attr($displaySideBarClass); ?> <?php echo esc_attr($sideBarClass); ?>">

    <?php
    /**
     * woocommerce_before_main_content hook.
     *
     * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
     * @hooked woocommerce_breadcrumb - 20
     */
    do_action('woocommerce_before_main_content');
    ?>
    <main id="main" class="site-main">
        <?php while (have_posts()) : ?>
            <?php the_post(); ?>
            <?php
            /**
             * Hook: cartsyProductSingleLayout.
             *
             * @hooked cartsyProductSingleLayout - 10
             */
            do_action('cartsy_product_single_layout');
            ?>
        <?php endwhile; // end of the loop.
        ?>
    </main>

    <?php
    /**
     * woocommerce_after_main_content hook.
     *
     * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
     */
    do_action('woocommerce_after_main_content');
    ?>

    <?php if (is_active_sidebar('cartsy-woo-sidebar') && (!empty($displaySideBar) && $displaySideBar === 'on')) { ?>
        <?php
        /**
         * Hook: woocommerce_sidebar.
         *
         * @hooked woocommerce_get_sidebar - 10
         */
        do_action('woocommerce_sidebar');
        ?>
    <?php } ?>
</div>

<?php
get_footer();

/* Omit closing PHP tag at the end of PHP files to avoid "headers already sent" issues. */
