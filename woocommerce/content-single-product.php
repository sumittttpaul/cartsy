<?php

/**
 * The template for displaying product content in the single-product.php template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.6.0
 */

defined('ABSPATH') || exit;

global $product;

/**
 * Hook: woocommerce_before_single_product.
 *
 * @hooked woocommerce_output_all_notices - 10
 */
do_action('woocommerce_before_single_product');

if (post_password_required()) {
    echo get_the_password_form(); // WPCS: XSS ok.
    return;
}


remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10);
remove_action('woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15);
remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);

$showUpSale = $showRelated = $showTabs = $showRecentlyViewed = 'on';
$recentlyViewedPosition = 'bottom';
if (function_exists('CartsyGlobalOptionData')) {
    $showUpSale  = CartsyGlobalOptionData('woo_single_upsell_products_switch');
    $showRelated = CartsyGlobalOptionData('woo_single_related_products_switch');
    $showTabs = CartsyGlobalOptionData('woo_single_tabs_switch');
    $showRecentlyViewed = CartsyGlobalOptionData('woo_single_recently_viewed_products_switch');
    $recentlyViewedPosition = CartsyGlobalOptionData('woo_single_recently_viewed_products_position');
}
?>

<div id="product-<?php the_ID(); ?>" <?php wc_product_class('', $product); ?>>

    <div class="cartsy-woocommerce-product-summary-wrapper">
        <?php
        /**
         * Hook: woocommerce_before_single_product_summary.
         *
         * @hooked woocommerce_show_product_sale_flash - 10
         * @hooked woocommerce_show_product_images - 20
         */
        do_action('woocommerce_before_single_product_summary');
        ?>

        <div class="summary entry-summary">
            <?php
            /**
             * Hook: woocommerce_single_product_summary.
             *
             * @hooked woocommerce_template_single_title - 5
             * @hooked woocommerce_template_single_rating - 10
             * @hooked woocommerce_template_single_price - 10
             * @hooked woocommerce_template_single_excerpt - 20
             * @hooked woocommerce_template_single_add_to_cart - 30
             * @hooked woocommerce_template_single_meta - 40
             * @hooked woocommerce_template_single_sharing - 50
             * @hooked WC_Structured_Data::generate_product_data() - 60
             */
            do_action('woocommerce_single_product_summary');
            ?>
        </div>

    </div>

    <?php
    $pagination_switch = get_theme_mod('single_page_adjacent_pagination', '1');
    if (!empty($pagination_switch)) {
        cartsy_single_product_pagination();
    }

    if ($showTabs === 'on') {
        woocommerce_output_product_data_tabs();
    }
    if ($showRecentlyViewed === 'on' && $recentlyViewedPosition === 'top') {
        cartsyOutputRecentlyViewedProduct();
    }
    if ($showUpSale === 'on') {
        woocommerce_upsell_display();
    }
    if ($showRelated === 'on') {
        woocommerce_output_related_products();
    }
    if ($showRecentlyViewed === 'on' && $recentlyViewedPosition === 'bottom') {
        cartsyOutputRecentlyViewedProduct();
    }

    /**
     * Hook: woocommerce_after_single_product_summary.
     *
     * @hooked woocommerce_output_product_data_tabs - 10
     * @hooked woocommerce_upsell_display - 15
     * @hooked woocommerce_output_related_products - 20
     */
    do_action('woocommerce_after_single_product_summary');
    ?>
</div>

<?php do_action('woocommerce_after_single_product'); ?>