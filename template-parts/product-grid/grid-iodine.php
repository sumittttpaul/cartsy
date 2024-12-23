<?php

/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
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

// Ensure visibility.
if (empty($product) || !$product->is_visible()) {
    return;
}
remove_action('woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10);
remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5);
remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10);
remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10);
remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10);
remove_action('woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10);
remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5);
remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10);
?>

<div <?php wc_product_class('cartsy-grid-iodine', $product); ?>>

    <?php
    $product_short_description = '';
    $splicedGalleryIDs = [];
    $showPopUP = 'on';

    $qty = cartsy_woocommerce_check_product_in_cart($product->get_id());
    $display = $qty ? 'display:flex;' : 'display:none;';
    $stock_qty = $product->get_manage_stock() ? $product->get_stock_quantity() : -1;
    $unit = get_post_meta($product->get_id(), '_cartsy_woocommerce_product_unit', true);
    $label = get_post_meta($product->get_id(), '_cartsy_woocommerce_product_unit_label', true);
    $size = 'woocommerce_thumbnail';
    $imageSize = apply_filters('single_product_archive_thumbnail_size', $size);
    $galleryImageIDs = $product ?  $product->get_gallery_image_ids() : '';
    $isInStock =  $product->is_in_stock();
    $isOnSale = $product->is_on_sale();
    $productTitle = $product->get_title();
    $productType = get_the_terms($product->get_id(), 'product_type') ? current(get_the_terms($product->get_id(), 'product_type'))->slug : '';
    $link = apply_filters('woocommerce_loop_product_link', get_the_permalink(), $product);
    if (function_exists('cartsy_woocommerce_check_product_in_cart')) {
        $itemOnCart = cartsy_woocommerce_check_product_in_cart($product->get_id());
    } else {
        $itemOnCart = [];
    }
    $cartButton = $itemOnCart ? 'display:none;' : 'display:flex;';
    if (!empty($galleryImageIDs) && isset($galleryImageIDs)) {
        $splicedGalleryIDs = array_slice($galleryImageIDs, 0, 1);
    }
    $placeholderImage = CARTSY_IMAGE_PATH . 'placeholder-icon.svg';
    $product_short_description = !empty($product) ? $product->get_short_description() : '';
    if (function_exists('CartsyGlobalOptionData')) {
        $showPopUP = !empty(CartsyGlobalOptionData('woo_preview_pop_switch')) ? CartsyGlobalOptionData('woo_preview_pop_switch') : 'on';
    }
    ?>

    <?php
    /**
     * Hook: woocommerce_before_shop_loop_item.
     *
     * @hooked woocommerce_template_loop_product_link_open - 10
     */
    do_action('woocommerce_before_shop_loop_item');
    ?>

    <?php
    /**
     * Hook: woocommerce_before_shop_loop_item_title.
     *
     * @hooked woocommerce_show_product_loop_sale_flash - 10
     * @hooked woocommerce_template_loop_product_thumbnail - 10
     */
    do_action('woocommerce_before_shop_loop_item_title');
    ?>

    <?php
    /**
     * Hook: woocommerce_shop_loop_item_title.
     *
     * @hooked woocommerce_template_loop_product_title - 10
     */
    do_action('woocommerce_shop_loop_item_title');
    ?>

    <div class="cartsy-iodine-product-card">
        <a href="<?php echo esc_url($link); ?>">
            <div class="cartsy-iodine-product-card-thumb">
                <?php if ($isOnSale) { ?>
                    <span class=" product-badge">
                        <?php echo esc_html__('Sale', 'cartsy'); ?>
                    </span>
                <?php } ?>
                <?php woocommerce_template_loop_product_thumbnail(); ?>
                <?php if (!empty($splicedGalleryIDs) && isset($splicedGalleryIDs)) { ?>
                    <?php foreach ($splicedGalleryIDs as $key => $galleryImageID) { ?>
                        <?php
                        $sliderImageURL = wp_get_attachment_image_url($galleryImageID, $imageSize) ? wp_get_attachment_image_url($galleryImageID, $imageSize) : CARTSY_IMAGE_PATH . 'placeholder-icon.svg';
                        $sliderImageSrcset = wp_get_attachment_image_srcset($galleryImageID, $imageSize);
                        $sliderImageSizes = wp_get_attachment_image_sizes($galleryImageID, $imageSize);
                        ?>
                        <img class="thumb-1" src="<?php echo esc_url($sliderImageURL); ?>" srcset="<?php echo esc_attr($sliderImageSrcset) ?>" sizes="<?php echo esc_attr($sliderImageSizes); ?>" alt="product-grid-gallery-item">
                    <?php } ?>
                <?php } ?>
            </div>

            <div class="cartsy-iodine-product-card-description">
                <div class="cartsy-iodine-product-card-title">
                    <?php woocommerce_template_loop_product_title(); ?>
                </div>
                <div class="cartsy-iodine-product-card-price">
                    <span class="price">
                        <?php woocommerce_template_loop_price(); ?>
                    </span>
                    <span class="unit">
                        <?php
                        if (!empty($unit)) {
                            echo esc_attr($label . ' ' . $unit);
                        }
                        ?>
                    </span>
                    <?php if (!$isInStock) { ?>
                        <div class="out-of-stock">
                            <?php echo esc_html__('(Out Of Stock)', 'cartsy') ?>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </a>
    </div>

    <?php
    /**
     * Hook: woocommerce_after_shop_loop_item_title.
     *
     * @hooked woocommerce_template_loop_rating - 5
     * @hooked woocommerce_template_loop_price - 10
     */
    do_action('woocommerce_after_shop_loop_item_title');
    ?>

    <?php
    /**
     * Hook: woocommerce_after_shop_loop_item.
     *
     * @hooked woocommerce_template_loop_product_link_close - 5
     * @hooked woocommerce_template_loop_add_to_cart - 10
     */
    do_action('woocommerce_after_shop_loop_item');
    ?>
</div>