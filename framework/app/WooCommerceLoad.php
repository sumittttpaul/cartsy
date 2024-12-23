<?php

namespace Framework\App;

// Do not allow directly accessing this file.
use CartsyHelper\WooCartsy\WooCartsyFront;

if (!defined('ABSPATH')) {
    exit('Direct script access denied.');
}

class WooCommerceLoad
{
    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {
        add_filter('body_class', [$this, 'cartsyWooTemplateClassLoad']);
        add_filter('woocommerce_add_to_cart_fragments', [$this, 'cartsyTopbarAddToCartFragment'], 10, 1);
        add_filter('woocommerce_cart_product_price', [$this, 'cartsyCartProductPrice'], 10, 2);
        add_filter('woocommerce_placeholder_img', [$this, 'cartsyShopPlaceHolderImg'], 10, 3);
        add_filter('woocommerce_placeholder_img_src', [$this, 'cartsySinglePlaceHolderImg'], 10, 1);

        add_action('cartsy_woo_mini_cart_hook', [$this, 'cartsyTopbarMiniCart'], 10, 1);
        if (!is_cart() && !is_checkout()) {
            add_action('wp_footer', [$this, 'cartsyFloatingMiniCart']);
            add_action('wp_footer', [$this, 'cartsyFooterMiniCart']);
        }
        add_action('cartsy_product_grid_layout', [$this, 'cartsyProductGridLayout'], 10, 1);
        add_filter('woocommerce_product_options_general_product_data', [$this, 'cartsyWooCommerceGeneralTabCustomFields']);
        add_action('woocommerce_process_product_meta', [$this, 'cartsyWooCommerceSaveFields']);
    }

    /**
     * cartsyWooCommerceGeneralTabCustomFields
     *
     * @return void
     */
    public function cartsyWooCommerceGeneralTabCustomFields()
    {
        get_template_part('template-parts/global/woocommerce', 'unit');
    }

    /**
     * cartsyWooCommerceSaveFields
     *
     * @param  mixed $post_id
     * @return void
     */
    public function cartsyWooCommerceSaveFields($post_id)
    {
        $product = wc_get_product($post_id);
        $product_unit = isset($_POST['_cartsy_woocommerce_product_unit']) ? $_POST['_cartsy_woocommerce_product_unit'] : '';
        $product->update_meta_data('_cartsy_woocommerce_product_unit', sanitize_text_field($product_unit));
        $product_unit_label = isset($_POST['_cartsy_woocommerce_product_unit_label']) ? $_POST['_cartsy_woocommerce_product_unit_label'] : '';
        $product->update_meta_data('_cartsy_woocommerce_product_unit_label', sanitize_text_field($product_unit_label));
        $product->save();
    }

    /**
     * cartsySinglePlaceHolderImg
     *
     * @param  mixed $src
     * @return string
     */
    public function cartsySinglePlaceHolderImg($src)
    {
        $src = CARTSY_IMAGE_PATH . 'placeholder-icon.svg';
        return $src;
    }

    /**
     * cartsyShopPlaceHolderImg
     *
     * @param  mixed $image_html
     * @param  mixed $size
     * @param  mixed $dimensions
     * @return void
     */
    public function cartsyShopPlaceHolderImg($image_html, $size, $dimensions)
    {

        $placeholderImage = CARTSY_IMAGE_PATH . 'placeholder-icon.svg';
        $image_html = '<img src="' . esc_attr($placeholderImage) . '" alt="' . esc_attr__('Placeholder', 'cartsy') . '" width="' . esc_attr($dimensions['width']) . '" class="woocommerce-placeholder wp-post-image fallback-thumb" height="' . esc_attr($dimensions['height']) . '" />';
        return $image_html;
    }


    /**
     * cartsyProductGridLayout
     *
     * @return template_path
     */
    public function cartsyProductGridLayout()
    {
        $gridLayout = '';
        $screenID = get_option('woocommerce_shop_page_id');
        $getOptionsBlog = !empty(get_post_meta($screenID, '_woo_general_get_option', true)) ? get_post_meta($screenID, '_woo_general_get_option', true) : 'global';
        if ($getOptionsBlog !== 'local') {
            if (function_exists('CartsyGlobalOptionData')) {
                $gridLayout = CartsyGlobalOptionData('woo_grid_switch');
            }
        } else {
            if (function_exists('CartsyLocalOptionData')) {
                $gridLayout = CartsyLocalOptionData($screenID, '_woo_grid_switch', true);
            }
        }

        switch ($gridLayout) {
            case 'grid_helium':
                return get_template_part('template-parts/product-grid/grid', 'helium');
                break;

            case 'grid_neon':
                return get_template_part('template-parts/product-grid/grid', 'neon');
                break;

            case 'grid_argon':
                return get_template_part('template-parts/product-grid/grid', 'argon');
                break;

            case 'grid_krypton':
                return get_template_part('template-parts/product-grid/grid', 'krypton');
                break;

            case 'grid_xenon':
                return get_template_part('template-parts/product-grid/grid', 'xenon');
                break;

            case 'grid_radon':
                return get_template_part('template-parts/product-grid/grid', 'radon');
                break;

            case 'grid_fluorine':
                return get_template_part('template-parts/product-grid/grid', 'fluorine');
                break;

            case 'grid_chlorine':
                return get_template_part('template-parts/product-grid/grid', 'chlorine');
                break;

            case 'grid_bromine':
                return get_template_part('template-parts/product-grid/grid', 'bromine');
                break;

            case 'grid_iodine':
                return get_template_part('template-parts/product-grid/grid', 'iodine');
                break;

            default:
                return get_template_part('template-parts/product-grid/grid', 'helium');
                // return wc_get_template_part('content', 'product');
                break;
        }
    }

    /**
     * cartsyTopbarAddToCartFragment
     *
     * @param  mixed $fragments
     * @return void
     */
    public function cartsyTopbarAddToCartFragment($fragments)
    {
        ob_start();
        CartsyCartLink();
        $fragments['div.menu-cart-area'] = ob_get_clean();
        return $fragments;
    }


    /**
     * cartsyTopbarMiniCart
     *
     * @return void
     */
    public function cartsyTopbarMiniCart()
    {
        $layout = get_theme_mod('woo_mini_cart_position', 'header-cart');

        if ($layout !== 'header-cart') {
            return;
        }
?>
        <div class="cartsy-mini-cart-widget">
            <div class="cartsy-mini-cart-overlay"></div>
            <ul id="site-header-cart" class="site-header-cart menu">
                <li class="cartsy-mini-cart-dropdown-btn">
                    <?php CartsyCartLink(); ?>
                </li>
                <?php if (!is_cart()) { ?>
                    <li class="cartsy-mini-cart">
                        <div class="cartsy-mini-cart-head">
                            <h2><?php echo esc_html__('Shopping Cart', 'cartsy') ?></h2>
                            <div class="cartsy-mini-cart-close">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18">
                                    <path id="close" d="M6.572,4.87a1.2,1.2,0,0,0-1.7,1.7l6.947,6.947L4.87,20.465a1.2,1.2,0,1,0,1.7,1.7l6.946-6.946,6.946,6.946a1.2,1.2,0,0,0,1.7-1.7l-6.946-6.946,6.947-6.947a1.2,1.2,0,0,0-1.7-1.7l-6.946,6.947Z" transform="translate(-4.518 -4.518)" fill="#212121" />
                                </svg>
                            </div>
                        </div>
                        <?php the_widget('WC_Widget_Cart', 'title='); ?>
                    </li>
                <?php } ?>
            </ul>
        </div>
    <?php
    }

    /**
     * cartsyFloatingMiniCart function
     *
     * @return void
     */
    public function cartsyFloatingMiniCart()
    {
        $layout = get_theme_mod('woo_mini_cart_position', 'header-cart');

        if ($layout === 'header-cart') {
            return;
        }

        $CssIdClass = 'site-' . $layout;
    ?>
        <?php if (!is_cart() && !is_checkout()) { ?>
            <div class="cartsy-mini-cart-widget">
                <div class="cartsy-mini-cart-overlay"></div>
                <ul id="<?php echo esc_attr($CssIdClass); ?>" class="site-floating-cart <?php echo esc_attr($CssIdClass); ?>">
                    <li class="cartsy-mini-cart-dropdown-btn">
                        <?php echo CartsyCartLink(); ?>
                    </li>
                    <?php if (!is_cart()) { ?>
                        <li class="cartsy-mini-cart">
                            <div class="cartsy-mini-cart-head">
                                <h2><?php echo esc_html__('Shopping Cart', 'cartsy') ?></h2>
                                <div class="cartsy-mini-cart-close">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18">
                                        <path id="close" d="M6.572,4.87a1.2,1.2,0,0,0-1.7,1.7l6.947,6.947L4.87,20.465a1.2,1.2,0,1,0,1.7,1.7l6.946-6.946,6.946,6.946a1.2,1.2,0,0,0,1.7-1.7l-6.946-6.946,6.947-6.947a1.2,1.2,0,0,0-1.7-1.7l-6.946,6.947Z" transform="translate(-4.518 -4.518)" fill="#212121" />
                                    </svg>
                                </div>
                            </div>
                            <?php the_widget('WC_Widget_Cart', 'title='); ?>
                        </li>
                    <?php } ?>
                </ul>
            </div>
        <?php } ?>
    <?php
    }

    /**
     * cartsyFooterMiniCart function
     *
     * @return void
     */
    public function cartsyFooterMiniCart()
    {
        $layout = get_theme_mod('woo_mini_cart_position', 'header-cart');

        if ($layout === 'header-cart') {
            return;
        }

        $CssIdClass = 'site-' . $layout;
    ?>
        <?php if (!is_cart() && !is_checkout()) { ?>
            <div class="cartsy-mini-cart-widget">
                <div class="cartsy-mini-cart-overlay"></div>
                <ul id="<?php echo esc_attr($CssIdClass); ?>" class="site-floating-cart <?php echo esc_attr($CssIdClass); ?>">
                    <li class="cartsy-mini-cart-dropdown-btn">
                        <?php echo CartsyCartLink(); ?>
                    </li>
                    <?php if (!is_cart()) { ?>
                        <li class="cartsy-mini-cart">
                            <div class="cartsy-mini-cart-head">
                                <h2><?php echo esc_html__('Shopping Cart', 'cartsy') ?></h2>
                                <div class="cartsy-mini-cart-close">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18">
                                        <path d="M6.572,4.87a1.2,1.2,0,0,0-1.7,1.7l6.947,6.947L4.87,20.465a1.2,1.2,0,1,0,1.7,1.7l6.946-6.946,6.946,6.946a1.2,1.2,0,0,0,1.7-1.7l-6.946-6.946,6.947-6.947a1.2,1.2,0,0,0-1.7-1.7l-6.946,6.947Z" transform="translate(-4.518 -4.518)" fill="#212121" />
                                    </svg>
                                </div>
                            </div>
                            <?php the_widget('WC_Widget_Cart', 'title='); ?>
                        </li>
                    <?php } ?>
                </ul>
            </div>
        <?php } ?>
<?php
    }

    /**
     * cartsyWooTemplateClassLoad
     *
     * @param  mixed $classes
     * @return array
     */
    public function cartsyWooTemplateClassLoad($classes)
    {
        $singleLayout = '';
        $classes[] = 'cartsy-woocommerce';

        if (function_exists('CartsyGlobalOptionData')) {
            $singleLayout = CartsyGlobalOptionData('woo_single_layout_switch');
        }

        switch ($singleLayout) {
            case 'layout_one':
                if (is_product()) {
                    $classes[] = 'cartsy-single-page-layout-one';
                } else {
                    $classes[] = 'cartsy-woocommerce';
                }
                break;

	        case 'layout_rnb_one':
		        if ( is_product() ) {
			        // If product type is redq_rental then add rnb layout class
			        if ( cartsy_rental_product(get_the_ID()) ) {
				        $classes[] = 'cartsy-single-page-rnb-layout-one';
				        break;
			        }else{
			            // Otherwise add default global class
			            $classes[] = 'cartsy-woocommerce';
			        }
		        } else {
			        $classes[] = 'cartsy-woocommerce';
		        }
		        break;

            default:
                $classes[] = 'cartsy-woocommerce';
                break;
        }
        return $classes;
    }

    /**
     * Cart product price
     *
     * @param float $price
     * @param object $product
     * @return float
     */
    public function cartsyCartProductPrice($price, $product)
    {
        if (WC()->cart->display_prices_including_tax()) {
            $product_price = wc_get_price_including_tax($product);
        } else {
            $product_price = wc_get_price_excluding_tax($product);
        }

        return $product_price;
    }
}
