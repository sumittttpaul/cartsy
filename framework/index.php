<?php

// Do not allow directly accessing this file.
if (!defined('ABSPATH')) {
    exit('Direct script access denied.');
}
require get_theme_file_path('/framework/vendor/autoload.php');
require_once get_theme_file_path('/framework/helpers/class-tgm-plugin-activation.php');
require_once get_theme_file_path('/framework/helpers/kirki.php');

new \Framework\App\Admin();
new \Framework\App\Cartsy();
new \Framework\App\Importer();
new \Framework\App\Plugin();
new \Framework\App\Sidebar();
new \Framework\App\Customizer();
if (class_exists('WooCommerce')) {
    new \Framework\App\WooCommerceLoad();
    new \Framework\App\WooCommerceSingleLoad();
    new \Framework\App\RecentlyViewedProduct();
}



/**
 * Output the Mini-cart - used by cart widget.
 *
 * @param array $args Arguments.
 */
function woocommerce_mini_cart($args = array())
{
    $defaults = array(
        'list_class' => '',
    );
    $args = wp_parse_args($args, $defaults);
    $layout = 'grocery';
    $layouts = [
        'grocery' => 'cart/mini-cart.php',
        'dress'   => 'cart/mini-cart-dress.php',
    ];
    wc_get_template($layouts[$layout], $args);
}



if (!function_exists('cartsy_single_product_pagination')) {
    /**
     * Single Product Pagination
     *
     * @since 2.3.0
     */
    function cartsy_single_product_pagination()
    {

        // Show only products in the same category?
        $in_same_term   = apply_filters('cartsy_single_product_pagination_same_category', true);
        $excluded_terms = apply_filters('cartsy_single_product_pagination_excluded_terms', '');
        $taxonomy       = apply_filters('cartsy_single_product_pagination_taxonomy', 'product_cat');

        $previous_product = cartsy_get_previous_product($in_same_term, $excluded_terms, $taxonomy);
        $next_product     = cartsy_get_next_product($in_same_term, $excluded_terms, $taxonomy);

        if (!$previous_product && !$next_product) {
            return;
        }

?>
        <nav class="cartsy-product-pagination" aria-label="<?php esc_attr_e('More products', 'cartsy'); ?>">
            <?php if ($previous_product) : ?>
                <a href="<?php echo esc_url($previous_product->get_permalink()); ?>" rel="prev">
                    <?php echo wp_kses_post($previous_product->get_image()); ?>
                    <span class="cartsy-product-pagination__title"><?php echo wp_kses_post($previous_product->get_name()); ?></span>
                    <i class="ion ion-ios-arrow-back"></i>
                </a>
            <?php endif; ?>

            <?php if ($next_product) : ?>
                <a href="<?php echo esc_url($next_product->get_permalink()); ?>" rel="next">
                    <?php echo wp_kses_post($next_product->get_image()); ?>
                    <span class="cartsy-product-pagination__title"><?php echo wp_kses_post($next_product->get_name()); ?></span>
                    <i class="ion ion-ios-arrow-forward"></i>
                </a>
            <?php endif; ?>
        </nav><!-- .cartsy-product-pagination -->
<?php
    }
}

/**
 * Retrieves the previous product.
 *
 * @since 2.4.3
 *
 * @param bool         $in_same_term   Optional. Whether post should be in a same taxonomy term. Default false.
 * @param array|string $excluded_terms Optional. Comma-separated list of excluded term IDs. Default empty.
 * @param string       $taxonomy       Optional. Taxonomy, if $in_same_term is true. Default 'product_cat'.
 * @return WC_Product|false Product object if successful. False if no valid product is found.
 */
function cartsy_get_previous_product($in_same_term = false, $excluded_terms = '', $taxonomy = 'product_cat')
{
    $product = new \Framework\App\ProductAdjacent($in_same_term, $excluded_terms, $taxonomy, true);
    return $product->getProduct();
}

/**
 * Retrieves the next product.
 *
 * @since 2.4.3
 *
 * @param bool         $in_same_term   Optional. Whether post should be in a same taxonomy term. Default false.
 * @param array|string $excluded_terms Optional. Comma-separated list of excluded term IDs. Default empty.
 * @param string       $taxonomy       Optional. Taxonomy, if $in_same_term is true. Default 'product_cat'.
 * @return WC_Product|false Product object if successful. False if no valid product is found.
 */
function cartsy_get_next_product($in_same_term = false, $excluded_terms = '', $taxonomy = 'product_cat')
{
    $product = new \Framework\App\ProductAdjacent($in_same_term, $excluded_terms, $taxonomy);
    return $product->getProduct();
}

/**
 * Display recently viewed products on the frontend
 *
 * @return false | void
 */
function cartsyOutputRecentlyViewedProduct()
{
    // If WooCommerce is not install then redirect
    if (!class_exists('WooCommerce')) {
        return false;
    }

    // Retrieve product ids
    $recentlyViewedProduct = new \Framework\App\RecentlyViewedProduct();
    $productIds            = $recentlyViewedProduct->cartsyGetProducts();

    // If there is no recently products available
    // Or if any product not found in recently viewed product array
    if (!$productIds || count($productIds) <= 0) {
        return false;
    }

    // If display functions is not available then return false
    if (!function_exists('cartsyDisplayRecentlyViewedProducts')) {
        return false;
    }

    // Product per page
    $productsPerPage = 4;

    // Remove current product id from the array
    $currentProductKey = array_search(get_the_ID(), $productIds);
    unset($productIds[$currentProductKey]);

    // Slice the array based on products per page
    $productIds = array_slice($productIds, 0, $productsPerPage);

    // Reverse the id
    $productIds = array_reverse($productIds);

    // Execute the frontend display function
    cartsyDisplayRecentlyViewedProducts($productIds);
}
