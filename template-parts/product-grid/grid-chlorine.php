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

<div <?php wc_product_class('cartsy-grid-chlorine', $product); ?>>

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

    <div class="cartsy-chlorine-product-card">

        <?php if (($showPopUP === 'on' && class_exists('RedQWooCommerceQuickView')) && $productType !== 'redq_rental') { ?>
            <a href="#redq-quick-view-modal" class="button-redq-woocommerce-quick-view" data-product_id="<?php echo $product->get_id(); ?>" rel="modal:open">
            <?php } else { ?>
                <a href="<?php echo esc_url($link); ?>">
                <?php } ?>


                <div class="cartsy-chlorine-product-card-thumb">
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

                    <?php if ($qty) { ?>
                        <div class='added-to-cart added-to-cart-<?php echo esc_attr($product->get_id()); ?>'>
                            <svg version="1.1" fill='currentColor' xmlns="http://www.w3.org/2000/svg" width='18' height='18' x="0px" y="0px" viewBox="0 0 512 512" xml:space="preserve">
                                <path d="M458.732,422.212l-22.862-288.109c-1.419-18.563-17.124-33.098-35.737-33.098h-45.164v66.917
			c0,8.287-6.708,14.995-14.995,14.995c-8.277,0-14.995-6.708-14.995-14.995v-66.917H187.028v66.917
			c0,8.287-6.718,14.995-14.995,14.995c-8.287,0-14.995-6.708-14.995-14.995v-66.917h-45.164c-18.613,0-34.318,14.535-35.737,33.058
			L53.265,422.252c-1.769,23.082,6.238,46.054,21.962,63.028C90.952,502.253,113.244,512,136.386,512h239.236
			c23.142,0,45.434-9.747,61.159-26.721C452.505,468.305,460.512,445.333,458.732,422.212z M323.56,275.493l-77.553,77.553
			c-2.929,2.929-6.768,4.398-10.606,4.398c-3.839,0-7.677-1.469-10.606-4.398l-36.347-36.347c-5.858-5.858-5.858-15.345,0-21.203
			c5.858-5.858,15.355-5.858,21.203,0l25.751,25.741l66.956-66.956c5.848-5.848,15.345-5.848,21.203,0
			C329.418,260.139,329.418,269.635,323.56,275.493z" />
                                <path d="M256.004,0c-54.571,0-98.965,44.404-98.965,98.975v2.029h29.99v-2.029c0-38.037,30.939-68.986,68.976-68.986
			s68.976,30.949,68.976,68.986v2.029h29.989v-2.029C354.969,44.404,310.575,0,256.004,0z" />
                            </svg>
                        </div>
                    <?php } else { ?>
                        <div class='added-to-cart added-to-cart-<?php echo esc_attr($product->get_id()); ?>' style='display:none'>
                            <svg version="1.1" fill='currentColor' xmlns="http://www.w3.org/2000/svg" width='18' height='18' x="0px" y="0px" viewBox="0 0 512 512" xml:space="preserve">
                                <path d="M458.732,422.212l-22.862-288.109c-1.419-18.563-17.124-33.098-35.737-33.098h-45.164v66.917
			c0,8.287-6.708,14.995-14.995,14.995c-8.277,0-14.995-6.708-14.995-14.995v-66.917H187.028v66.917
			c0,8.287-6.718,14.995-14.995,14.995c-8.287,0-14.995-6.708-14.995-14.995v-66.917h-45.164c-18.613,0-34.318,14.535-35.737,33.058
			L53.265,422.252c-1.769,23.082,6.238,46.054,21.962,63.028C90.952,502.253,113.244,512,136.386,512h239.236
			c23.142,0,45.434-9.747,61.159-26.721C452.505,468.305,460.512,445.333,458.732,422.212z M323.56,275.493l-77.553,77.553
			c-2.929,2.929-6.768,4.398-10.606,4.398c-3.839,0-7.677-1.469-10.606-4.398l-36.347-36.347c-5.858-5.858-5.858-15.345,0-21.203
			c5.858-5.858,15.355-5.858,21.203,0l25.751,25.741l66.956-66.956c5.848-5.848,15.345-5.848,21.203,0
			C329.418,260.139,329.418,269.635,323.56,275.493z" />
                                <path d="M256.004,0c-54.571,0-98.965,44.404-98.965,98.975v2.029h29.99v-2.029c0-38.037,30.939-68.986,68.976-68.986
			s68.976,30.949,68.976,68.986v2.029h29.989v-2.029C354.969,44.404,310.575,0,256.004,0z" />
                            </svg>
                        </div>
                    <?php }  ?>
                </div>

                <div class="cartsy-chlorine-product-card-description">
                    <div class="cartsy-chlorine-product-card-title">
                        <?php woocommerce_template_loop_product_title(); ?>
                    </div>
                    <?php if (!empty($product_short_description)) { ?>
                        <div class="cartsy-chlorine-product-card-details">
                            <!-- Product Short description -->
                            <?php echo apply_filters('cartsy_chlorine_grid_short_description', $product_short_description); ?>
                        </div>
                    <?php } ?>
                    <div class="cartsy-chlorine-product-card-price">
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