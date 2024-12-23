<?php
$miniCartLayout = '';
if (function_exists('CartsyGlobalOptionData')) {
    $miniCartLayout = !empty(CartsyGlobalOptionData('woo_mini_cart_position')) ? CartsyGlobalOptionData('woo_mini_cart_position') : 'header-cart';
}
?>
<?php if (class_exists('WooCommerce')) { ?>
    <?php $myAccountPageID = get_option('woocommerce_myaccount_page_id'); ?>
    <div class="cartsy-menu-right-col">
        <div class="cartsy-header-search-button" style='display: none'>
            <svg xmlns="http://www.w3.org/2000/svg" width="18.942" height="20" viewBox="0 0 18.942 20">
                <g id="Group_5362" data-name="Group 5362" transform="translate(-643 -40)">
                    <g id="Group_5327" data-name="Group 5327" transform="translate(643 40)">
                        <path data-name="Path 17130" d="M381.768,385.4l3.583,3.576c.186.186.378.366.552.562a.993.993,0,1,1-1.429,1.375c-1.208-1.186-2.422-2.367-3.585-3.6a1.026,1.026,0,0,0-1.473-.246,8.343,8.343,0,1,1-3.671-15.785,8.369,8.369,0,0,1,6.663,13.262C382.229,384.815,382.025,385.063,381.768,385.4Zm-6.152.579a6.342,6.342,0,1,0-6.306-6.355A6.305,6.305,0,0,0,375.615,385.983Z" transform="translate(-367.297 -371.285)" fill="currentColor" />
                    </g>
                </g>
            </svg>
        </div>
        <?php if (!empty($myAccountPageID)) { ?>
            <a class="cartsy-join-us-btn" href="<?php echo esc_url(get_permalink($myAccountPageID)); ?>">
                <?php echo esc_html__('My Account', 'cartsy') ?>
            </a>
        <?php } ?>

        <?php if ($miniCartLayout === 'header-cart') { ?>
            <?php if (!is_cart() && !is_checkout()) { ?>
                <div class="cartsy-mini-cart-on-desktop">
                    <?php
                    /**
                     * Functions hooked into cartsy_woo_mini_cart_hook action
                     *
                     * @hooked cartsyTopbarMiniCart function
                     *
                     */
                    do_action('cartsy_woo_mini_cart_hook');
                    ?>
                </div>
            <?php } ?>
        <?php } ?>


    </div>
<?php } ?>