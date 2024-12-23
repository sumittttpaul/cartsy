<?php

/**
 * Mini-cart
 *
 * Contains the markup for the mini-cart, used by the cart widget.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/mini-cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.7.0
 */

defined('ABSPATH') || exit;

$emptyCSSClass = '';
$cartItems = [];
if (function_exists('cartsyCheckProductInCart')) {
    $cartItems = cartsyCheckProductInCart();
}
if (empty($cartItems)) {
    $emptyCSSClass = 'cartsy-empty-mini-cart';
}
$allowed_html = wp_kses_allowed_html('post');


do_action('woocommerce_before_mini_cart'); ?>

<?php if (!WC()->cart->is_empty()) : ?>

    <div class="cartsy-mini-cart-items">
        <?php
        do_action('woocommerce_before_mini_cart_contents');

        foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
            $_product   = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
            $product_id = apply_filters('woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key);
            if ($_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters('woocommerce_widget_cart_item_visible', true, $cart_item, $cart_item_key)) {
                $product_name      = apply_filters('woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key);
                $thumbnail         = apply_filters('woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key);
                $product_price     = apply_filters('woocommerce_cart_item_price', WC()->cart->get_product_price($_product), $cart_item, $cart_item_key);
                $product_permalink = apply_filters('woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink($cart_item) : '', $cart_item, $cart_item_key);
        ?>
                <div class="cartsy-mini-cart-item woocommerce-mini-cart-item mini_cart_item cartsy-product-<?php echo esc_attr($product_id); ?>">
                    <div class="cartsy-mini-cart-item-thumbnail">
                        <?php echo wp_kses($thumbnail, $allowed_html); ?>
                        <?php
                        echo apply_filters( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                            'woocommerce_cart_item_remove_link',
                            sprintf(
                                '<a href="%s" class="remove remove_from_cart_button cartsy_remove_mini_cart_item" aria-label="%s" data-product_id="%s" data-cart_item_key="%s" data-product_sku="%s" data-type="clean_cart_item" data-source="mini_cart_remove">
									<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20">
										<path  data-name="Path 16584" d="M17.074,2.925a10,10,0,1,0,0,14.149A10.016,10.016,0,0,0,17.074,2.925Zm-3.129,11.02a.769.769,0,0,1-1.088,0L10,11.088,7.007,14.081a.769.769,0,0,1-1.088-1.088L8.912,10,6.055,7.143A.769.769,0,0,1,7.143,6.055L10,8.912l2.721-2.721a.769.769,0,0,1,1.088,1.088L11.088,10l2.857,2.857A.769.769,0,0,1,13.945,13.945Z" transform="translate(0 0)" fill="#fff"/>
									</svg>
								</a>',
                                esc_url(wc_get_cart_remove_url($cart_item_key)),
                                esc_attr__('Remove this item', 'cartsy'),
                                esc_attr($product_id),
                                esc_attr($cart_item_key),
                                esc_attr($_product->get_sku())
                            ),
                            $cart_item_key
                        );
                        ?>
                    </div>
                    <div class="cartsy-mini-cart-item-info">
                        <?php if (empty($product_permalink)) : ?>
                            <span class="cartsy-mini-cart-item-title"><?php echo  esc_html($product_name); ?></span>
                        <?php else : ?>
                            <a class="cartsy-mini-cart-item-title" href=" <?php echo esc_url($product_permalink); ?>"><?php echo esc_html($product_name); ?></a>
                        <?php endif; ?>
                        <?php if (!cartsy_rental_product($product_id)) : ?>
                            <span class="cartsy-mini-cart-item-price">
                                <?php echo apply_filters('cartsy_cart_item_price', sprintf('%s %s', esc_html('Unit Price', 'cartsy'), WC()->cart->get_product_subtotal($_product, 1), $cart_item, $cart_item_key)); ?>
                            </span>
                        <?php endif; ?>
                        <div class="cartsy-mini-cart-item-count">
                            <?php if (!cartsy_rental_product($product_id)) : ?>
                                <div class="cartsy-counter shadow filled size-medium">
                                    <span data-product_id="<?php echo esc_attr($product_id); ?>" data-type="minus" data-source="mini_cart" class="cartsy-counter-update decrement cartsy-update-qty">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="10" height="1.25" viewBox="0 0 10 1.25">
                                            <path data-name="Path 9" d="M142.157,142.158h-4.375v1.25h10v-1.25h-5.625Z" transform="translate(-137.782 -142.158)" fill="#fff" />
                                        </svg>
                                    </span>
                                    <span class="cartsy-counter-value">
                                        <?php echo apply_filters('woocommerce_widget_cart_item_quantity', '<span class="quantity">' . sprintf('%s', $cart_item['quantity']) . '</span>', $cart_item, $cart_item_key); ?>
                                    </span>
                                    <span data-product_id="<?php echo esc_attr($product_id); ?>" data-type="plus" data-source="mini_cart" class="cartsy-counter-update increment cartsy-update-qty">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 10 10">
                                            <path data-name="Path 9" d="M143.407,137.783h-1.25v4.375h-4.375v1.25h4.375v4.375h1.25v-4.375h4.375v-1.25h-4.375Z" transform="translate(-137.782 -137.783)" fill="#fff" />
                                        </svg>
                                    </span>
                                </div>
                            <?php endif; ?>
                            <div class="cartsy-mini-cart-item-total">
                                <?php echo apply_filters('woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal($_product, $cart_item['quantity']), $cart_item, $cart_item_key); ?>
                            </div>
                        </div>
                    </div>
                </div>
        <?php
            }
        }

        do_action('woocommerce_mini_cart_contents');
        ?>
    </div>


<?php else : ?>

    <div class="cartsy-mini-cart-empty-message">
        <img src="<?php echo esc_url(CARTSY_IMAGE_PATH . 'not-found-alt.svg') ?>" alt="<?php echo esc_attr__('no product found', 'cartsy'); ?>">
        <h3><?php esc_html_e('No products in the cart.', 'cartsy'); ?></h3>
    </div>

<?php endif; ?>

<?php do_action('woocommerce_widget_shopping_cart_before_buttons'); ?>
<div class="cartsy-mini-cart-total <?php echo esc_attr($emptyCSSClass); ?>">
    <a href="<?php echo esc_url(wc_get_checkout_url()); ?>">
        <span class="label"><?php echo esc_html__('Proceed To Checkout', 'cartsy'); ?></span>
        <span class="amount">
            <?php
            /**
             * Hook: woocommerce_widget_shopping_cart_total.
             *
             * @hooked woocommerce_widget_shopping_cart_subtotal - 10
             */
            do_action('woocommerce_widget_shopping_cart_total');
            ?>
        </span>
        <span class="mini-loader">
            <span class="dot1"></span>
            <span class="dot2"></span>
            <span class="dot3"></span>
        </span>
    </a>
</div>
<?php do_action('woocommerce_widget_shopping_cart_after_buttons'); ?>


<?php do_action('woocommerce_after_mini_cart'); ?>