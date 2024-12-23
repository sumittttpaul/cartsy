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
remove_action('woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20);
remove_action('woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_title', 5);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 10);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50);
remove_action('rnb_before_add_to_cart_form', 'rnb_price_flip_box', 10);

$showUpSale             = $showRelated = $showRecentlyViewed = 'on';
$showBreadCrumb         = 'off';
$recentlyViewedPosition = 'bottom';
if (function_exists('CartsyGlobalOptionData')) {
	$showUpSale             = CartsyGlobalOptionData('woo_single_upsell_products_switch');
	$showRelated            = CartsyGlobalOptionData('woo_single_related_products_switch');
	$showRecentlyViewed     = CartsyGlobalOptionData('woo_single_recently_viewed_products_switch');
	$recentlyViewedPosition = CartsyGlobalOptionData('woo_single_recently_viewed_products_position');
	$showBreadCrumb         = !empty(CartsyGlobalOptionData('woo_single_breadcrumb_switch')) ? CartsyGlobalOptionData('woo_single_breadcrumb_switch') : 'off';
	$showTabs               = CartsyGlobalOptionData('woo_single_tabs_switch');
}
?>
<div id="product-<?php the_ID(); ?>" <?php wc_product_class('rnb-layout-one', $product); ?>>

	<div class="cartsy-product-single-breadcrumb">
		<?php //woocommerce_breadcrumb();
		?>
		<?php
		if ($showBreadCrumb === 'on') {
			if (function_exists('CartsyBreadcrumb')) {
				CartsyBreadcrumb();
			}
		}
		?>
	</div>

	<?php
	/**
	 * Hook: woocommerce_before_single_product_summary.
	 *
	 * @hooked woocommerce_show_product_sale_flash - 10
	 * @hooked woocommerce_show_product_images - 20
	 */
	do_action('woocommerce_before_single_product_summary');
	?>

	<div class="cartsy-single-product-summary cartsy-rnb-single-product-summary">
		<div class="rnb-layout-one-header">
			<!-- Title -->
			<?php woocommerce_template_single_title(); ?>

			<!-- Rating -->
			<?php woocommerce_template_single_rating(); ?>

			<!-- Price -->
			<?php get_template_part('template-parts/product-single/layout-rnb-one/rental-product', 'price'); ?>
		</div>

		<div class="rnb-layout-one-gallery">
			<!-- RnB Product Gallery -->
			<div class="rnb-gallery">
				<?php get_template_part('template-parts/product-single/layout-rnb-one/rental-product', 'gallery'); ?>
			</div>

			<!-- RnB Attributes -->
			<div class="rnb-attributes">
				<?php get_template_part('template-parts/product-single/layout-rnb-one/rental-product', 'attributes'); ?>
			</div>

			<!-- Sort description -->
			<?php if (has_excerpt()) { ?>
				<div class="rnb-short-description">
					<?php the_excerpt(); ?>
				</div>
			<?php } ?>


			<!-- Tabs -->
			<?php
			if ($showTabs === 'on') {
				woocommerce_output_product_data_tabs();
			}
			?>
		</div>

		<div class="summary entry-summary right-content">

			<!-- RnB Price Flipbox -->
			<?php get_template_part('template-parts/product-single/layout-rnb-one/rental-product', 'flipbox'); ?>

			<?php woocommerce_template_single_add_to_cart(); ?>

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

			<?php woocommerce_template_single_sharing(); ?>

			<?php woocommerce_template_single_meta(); ?>

			<?php
			$pagination_switch = get_theme_mod('single_page_adjacent_pagination', '1');
			if (!empty($pagination_switch)) {
				cartsy_single_product_pagination();
			}
			?>
		</div>
	</div>

	<?php
	if ($showRecentlyViewed === 'on' && $recentlyViewedPosition === 'top') {
		cartsyOutputRecentlyViewedProduct();
	}
	?>

	<?php
	if ($showUpSale === 'on') {
		woocommerce_upsell_display();
	}
	?>

	<?php
	if ($showRelated === 'on') {
		woocommerce_output_related_products();
	}
	?>

	<?php
	if ($showRecentlyViewed === 'on' && $recentlyViewedPosition === 'bottom') {
		cartsyOutputRecentlyViewedProduct();
	}
	?>

	<?php
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