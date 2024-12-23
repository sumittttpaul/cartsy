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

<div <?php wc_product_class('cartsy-grid-helium', $product); ?>>

    <?php
    $cartItems = $splicedGalleryIDs = [];
    if (function_exists('cartsy_woocommerce_check_product_in_cart')) {
        $qty = cartsy_woocommerce_check_product_in_cart($product->get_id());
    } else {
        $qty = [];
    }
    $display = $qty ? 'display:flex;' : 'display:none;';
    $qty_class = 'cartsy-qty-button cartsy-qty-button-' . $product->get_id();
    $stock_qty = $product->get_manage_stock() ? $product->get_stock_quantity() : -1;
    $unit = get_post_meta($product->get_id(), '_cartsy_woocommerce_product_unit', true);
    $label = get_post_meta($product->get_id(), '_cartsy_woocommerce_product_unit_label', true);
    $size = 'woocommerce_thumbnail';
    $imageSize = apply_filters('single_product_archive_thumbnail_size', $size);
    $galleryImageIDs = $product ?  $product->get_gallery_image_ids() : [];
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
    if (function_exists('cartsyCheckProductInCart')) {
        $cartItems = cartsyCheckProductInCart();
    }
    $cartButton = $itemOnCart ? 'display:none;' : 'display:flex;';
    if (!empty($galleryImageIDs) && isset($galleryImageIDs)) {
        $splicedGalleryIDs = array_slice($galleryImageIDs, 0, 1);
    }
    $placeholderImage = CARTSY_IMAGE_PATH . 'placeholder-icon.svg';
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

    <div class="cartsy-helium-product-card">
        <div class="cartsy-helium-product-card-thumb">
            <?php if ($isOnSale) { ?>
                <span class="product-badge">
                    <?php echo esc_html__('Sale', 'cartsy');  ?>
                </span>
            <?php } ?>

            <a href="<?php echo esc_url($link); ?>">
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
            </a>

        </div>

        <div class=" cartsy-helium-product-card-description">
            <div class="cartsy-helium-product-card-price">
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
            </div>
            <a href="<?php echo esc_url($link); ?>" class="cartsy-helium-product-card-title">
                <?php woocommerce_template_loop_product_title(); ?>
            </a>
            <?php if (class_exists('CartsyHelper')) { ?>
                <?php if ($isInStock) { ?>
                    <?php if ($productType === 'simple') { ?>
                        <div class="cartsy-helium-product-card-cart">
                            <!-- Add to cart button -->
                            <a href="#" class="cartsy_btn_display product_type_simple add_to_cart_button cartsy_ajax_add_to_cart cartsy-update-qty cartsy-add-to-cart-<?php echo esc_attr($product->get_id()); ?>" data-product_id="<?php echo esc_attr($product->get_id()); ?>" style="<?php echo esc_attr($cartButton); ?>">
                                <span class="cartsy-helium-product-card-cart-button">
                                    <span class="label"><?php echo esc_html__('ADD', 'cartsy'); ?></span>
                                    <span class="icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 10 10">
                                            <path data-name="Path 9" d="M143.407,137.783h-1.25v4.375h-4.375v1.25h4.375v4.375h1.25v-4.375h4.375v-1.25h-4.375Z" transform="translate(-137.782 -137.783)" fill="currentColor"></path>
                                        </svg>
                                    </span>
                                </span>
                            </a>
                            <!-- End -->
                            <!-- Quantity button -->
                            <div class="cartsy-counter full-width size-medium cartsy-qty-button cartsy-qty-button-<?php echo esc_attr($product->get_id()); ?> <?php echo esc_attr($qty_class); ?>" style="<?php echo esc_attr($display); ?> margin-bottom: 10px;">
                                <span class="cartsy-counter-update decrement cartsy-update-qty" data-product_id="<?php echo esc_attr($product->get_id()); ?>" data-type="minus" data-stock_qty="<?php echo esc_attr($stock_qty); ?>">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="10" height="1.25" viewBox="0 0 10 1.25">
                                        <path data-name="Path 9" d="M142.157,142.158h-4.375v1.25h10v-1.25h-5.625Z" transform="translate(-137.782 -142.158)" fill="#fff"></path>
                                    </svg>
                                </span>

                                <span class="cartsy-counter-value">
                                    <span class="quantity cartsy-cart-qty cartsy-cart-product-<?php echo esc_attr($product->get_id()); ?>">
                                        <?php echo esc_attr($qty); ?>
                                    </span>
                                </span>

                                <span class="cartsy-counter-update increment cartsy-update-qty" data-product_id="<?php echo esc_attr($product->get_id()); ?>" data-type="plus" data-stock_qty="<?php echo esc_attr($stock_qty); ?>">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 10 10">
                                        <path data-name="Path 9" d="M143.407,137.783h-1.25v4.375h-4.375v1.25h4.375v4.375h1.25v-4.375h4.375v-1.25h-4.375Z" transform="translate(-137.782 -137.783)" fill="#fff"></path>
                                    </svg>
                                </span>
                            </div>
                            <!-- End -->
                        </div>
                    <?php } else { ?>
                        <div class="cartsy-helium-product-card-cart">
                            <a href="<?php echo esc_url($link); ?>">
                                <span class="cartsy-helium-product-card-cart-button">
                                    <span class="label"><?php echo esc_html__('Select Options', 'cartsy'); ?></span>
                                    <span class="icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 10 10">
                                            <path data-name="Path 9" d="M143.407,137.783h-1.25v4.375h-4.375v1.25h4.375v4.375h1.25v-4.375h4.375v-1.25h-4.375Z" transform="translate(-137.782 -137.783)" fill="currentColor"></path>
                                        </svg>
                                    </span>
                                </span>
                            </a>
                        </div>
                    <?php } ?>
                <?php } else { ?>
                    <div class="cartsy-helium-product-card-cart">
                        <div class="out-of-stock"><?php echo esc_html__('OUT OF STOCK', 'cartsy'); ?></div>
                    </div>
                <?php } ?>

            <?php } else { ?>
                <?php if ($isInStock) { ?>
                    <?php if ($productType === 'simple') { ?>
                        <div class="cartsy-helium-product-card-cart">
                            <!-- Add to cart button -->
                            <a href="<?php echo esc_url($link); ?>">
                                <span class="cartsy-helium-product-card-cart-button">
                                    <span class="label"><?php echo esc_html__('ADD', 'cartsy'); ?></span>
                                    <span class="icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 10 10">
                                            <path data-name="Path 9" d="M143.407,137.783h-1.25v4.375h-4.375v1.25h4.375v4.375h1.25v-4.375h4.375v-1.25h-4.375Z" transform="translate(-137.782 -137.783)" fill="currentColor"></path>
                                        </svg>
                                    </span>
                                </span>
                            </a>
                            <!-- End -->
                        </div>
                    <?php } else { ?>
                        <div class="cartsy-helium-product-card-cart">
                            <a href="<?php echo esc_url($link); ?>">
                                <span class="cartsy-helium-product-card-cart-button">
                                    <span class="label"><?php echo esc_html__('Select Options', 'cartsy'); ?></span>
                                    <span class="icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 10 10">
                                            <path data-name="Path 9" d="M143.407,137.783h-1.25v4.375h-4.375v1.25h4.375v4.375h1.25v-4.375h4.375v-1.25h-4.375Z" transform="translate(-137.782 -137.783)" fill="currentColor"></path>
                                        </svg>
                                    </span>
                                </span>
                            </a>
                        </div>
                    <?php } ?>
                <?php } else { ?>
                    <div class="cartsy-helium-product-card-cart">
                        <div class="out-of-stock"><?php echo esc_html__('OUT OF STOCK', 'cartsy'); ?></div>
                    </div>
                <?php } ?>
            <?php } ?>
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
</div>