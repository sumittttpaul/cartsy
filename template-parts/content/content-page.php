<?php

/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Cartsy
 */

$screenID = $getOptionsBlog = '';
$pageBannerSwitch = 'off';
$screenID = CartsyGetCurrentPageID();

$getOptionsBlog = !empty(get_post_meta($screenID, '_general_get_option', true)) ? get_post_meta($screenID, '_general_get_option', true) : 'global';

if ($getOptionsBlog !== 'local') {
    if (function_exists('CartsyGlobalOptionData')) {
        if (class_exists('WooCommerce') && (is_woocommerce() || is_cart() || is_account_page() || is_checkout() || is_product())) {
            $pageBannerSwitch = !empty(CartsyGlobalOptionData('woo_banner_switch')) ? CartsyGlobalOptionData('woo_banner_switch') : 'off';
        } else {
            $pageBannerSwitch = !empty(CartsyGlobalOptionData('page_banner_switch')) ? CartsyGlobalOptionData('page_banner_switch') : 'off';
        }
    }
} else {
    if (function_exists('CartsyLocalOptionData')) {
        $pageBannerSwitch = !empty(CartsyLocalOptionData($screenID, '_page_banner_switch', 'true')) ? CartsyLocalOptionData($screenID, '_page_banner_switch', 'true') : 'off';
    }
}

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <?php if (!empty($pageBannerSwitch) && $pageBannerSwitch === 'off') { ?>
        <header class="entry-header fall-back-header">
            <?php
            the_title('<h3 class="entry-title">', '</h3>');
            ?>
        </header>
    <?php } ?>
    <!-- .entry-header -->
    <div class="entry-content">
        <?php
        the_content();
        wp_link_pages(array(
            'before' => '<div class="page-links">' . esc_html__('Pages:', 'cartsy'),
            'after'  => '</div>',
        ));
        ?>
    </div><!-- .entry-content -->

    <?php if (get_edit_post_link()) : ?>
        <footer class="entry-footer">
            <?php
            edit_post_link(
                sprintf(
                    wp_kses(
                        /* translators: %s: Name of current post. Only visible to screen readers */
                        __('Edit <span class="screen-reader-text">%s</span>', 'cartsy'),
                        array(
                            'span' => array(
                                'class' => array(),
                            ),
                        )
                    ),
                    get_the_title()
                ),
                '<span class="edit-link">',
                '</span>'
            );
            ?>
        </footer><!-- .entry-footer -->
    <?php endif; ?>
</article><!-- #post-<?php the_ID(); ?> -->