<?php

/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.4.0
 */

defined('ABSPATH') || exit;

get_header();

?>

<?php
$screenID = $getOptionsBlog = $blogBanner = $sideBarClass = $sideBarPosition = '';
$displaySideBar = 'off';
$displaySideBarClass = 'with-sidebar';
$bannerSwitch = 'off';

$screenID = get_option('woocommerce_shop_page_id');
$getOptionsBlog = !empty(get_post_meta($screenID, '_woo_general_get_option', true)) ? get_post_meta($screenID, '_woo_general_get_option', true) : 'global';

if ($getOptionsBlog !== 'local') {
    if (function_exists('CartsyGlobalOptionData')) {
        $displaySideBar  = CartsyGlobalOptionData('woo_sidebar_switch');
        $sideBarPosition = !empty(CartsyGlobalOptionData('woo_sidebar_position')) ? CartsyGlobalOptionData('woo_sidebar_position') : 'right';
        $bannerSwitch = !empty(CartsyGlobalOptionData('woo_banner_switch')) ? CartsyGlobalOptionData('woo_banner_switch') : 'off';
    }
} else {
    if (function_exists('CartsyLocalOptionData')) {
        $displaySideBar  = CartsyLocalOptionData($screenID, '_woo_sidebar_switch', true);
        $sideBarPosition = CartsyLocalOptionData($screenID, '_woo_sidebar_position', true);
        $bannerSwitch = !empty(CartsyLocalOptionData($screenID, '_woo_banner_switch', true)) ? CartsyLocalOptionData($screenID, '_woo_banner_switch', true) : 'off';
    }
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


if (!empty($sideBarPosition) && $sideBarPosition === 'left') {
    $sideBarClass = 'left-sidebar';
}
remove_action('woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);

remove_action('woocommerce_before_shop_loop', 'woocommerce_result_count', 20);
remove_action('woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30);

remove_action('woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);

?>

<?php
/**
 * Hook: woocommerce_before_main_content.
 *
 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
 * @hooked woocommerce_breadcrumb - 20
 * @hooked WC_Structured_Data::generate_website_data() - 30
 */
do_action('woocommerce_before_main_content');
?>
<div id="primary" class="content-area <?php echo esc_attr($displaySideBarClass . ' ' . $sideBarClass); ?>">

    <main id="main" class="site-main">

        <header class="woocommerce-products-header">
            <?php if (!empty($bannerSwitch) && $bannerSwitch === 'off') { ?>
                <?php if (apply_filters('woocommerce_show_page_title', true)) : ?>
                    <h1 class="woocommerce-products-header__title page-title"><?php woocommerce_page_title(); ?></h1>
                <?php endif; ?>
            <?php } ?>

            <?php
            /**
             * Hook: woocommerce_archive_description.
             *
             * @hooked woocommerce_taxonomy_archive_description - 10
             * @hooked woocommerce_product_archive_description - 10
             */
            do_action('woocommerce_archive_description');
            ?>
        </header>


        <?php if (woocommerce_product_loop()) { ?>
            <?php
            /**
             * Hook: woocommerce_before_shop_loop.
             *
             * @hooked woocommerce_output_all_notices - 10
             * @hooked woocommerce_result_count - 20
             * @hooked woocommerce_catalog_ordering - 30
             */
            do_action('woocommerce_before_shop_loop');
            ?>
            <div class="cartsy-shop-page-content-header">
                <?php
                woocommerce_result_count();
                woocommerce_catalog_ordering();
                ?>
            </div>

            <?php woocommerce_product_loop_start(); ?>

            <?php
            if (wc_get_loop_prop('total')) {
                while (have_posts()) {
                    the_post();
                    /**
                     * Hook: woocommerce_shop_loop.
                     */
                    do_action('woocommerce_shop_loop');

                    /**
                     * Hook: cartsy_product_grid_layout.
                     *
                     * @hooked cartsyProductGridLayout - 10
                     */
                    do_action('cartsy_product_grid_layout');
                }
            } ?>

            <?php woocommerce_product_loop_end(); ?>

            <?php
            /**
             * Hook: woocommerce_after_shop_loop.
             *
             * @hooked woocommerce_pagination - 10
             */
            do_action('woocommerce_after_shop_loop');
            ?>
        <?php } else { ?>

            <?php
            /**
             * Hook: woocommerce_no_products_found.
             *
             * @hooked wc_no_products_found - 10
             */
            do_action('woocommerce_no_products_found'); ?>

        <?php } ?>
    </main>
    <?php
    /**
     * Hook: woocommerce_after_main_content.
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
