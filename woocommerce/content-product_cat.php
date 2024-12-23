<?php

/**
 * The template for displaying product category thumbnails within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product_cat.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 2.6.1
 */

if (!defined('ABSPATH')) {
	exit;
}

$gridLayout = $cartsyGridClass = '';
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
		$cartsyGridClass = 'cartsy-grid-helium';
		break;

	case 'grid_neon':
		$cartsyGridClass = 'cartsy-grid-neon';
		break;

	case 'grid_argon':
		$cartsyGridClass = 'cartsy-grid-argon';
		break;

	case 'grid_krypton':
		$cartsyGridClass = 'cartsy-grid-krypton';
		break;

	case 'grid_xenon':
		$cartsyGridClass = 'cartsy-grid-xenon';
		break;

	case 'grid_radon':
		$cartsyGridClass = 'cartsy-grid-radon';
		break;

	case 'grid_fluorine':
		$cartsyGridClass = 'cartsy-grid-fluorine';
		break;

	case 'grid_chlorine':
		$cartsyGridClass = 'cartsy-grid-chlorine';
		break;

	case 'grid_bromine':
		$cartsyGridClass = 'cartsy-grid-bromine';
		break;

	case 'grid_iodine':
		$cartsyGridClass = 'cartsy-grid-iodine';
		break;

	default:
		$cartsyGridClass = 'cartsy-grid-helium';
		break;
}

?>
<div <?php wc_product_cat_class('' . $cartsyGridClass,  $category); ?>>
	<?php
	/**
	 * woocommerce_before_subcategory hook.
	 *
	 * @hooked woocommerce_template_loop_category_link_open - 10
	 */
	do_action('woocommerce_before_subcategory', $category);
	?>

	<div class="thumb">
		<?php
		/**
		 * woocommerce_before_subcategory_title hook.
		 *
		 * @hooked woocommerce_subcategory_thumbnail - 10
		 */
		do_action('woocommerce_before_subcategory_title', $category);
		?>
	</div>

	<?php

	/**
	 * woocommerce_shop_loop_subcategory_title hook.
	 *
	 * @hooked woocommerce_template_loop_category_title - 10
	 */
	do_action('woocommerce_shop_loop_subcategory_title', $category);
	?>

	<?php
	/**
	 * woocommerce_after_subcategory_title hook.
	 */
	do_action('woocommerce_after_subcategory_title', $category);
	?>

	<?php
	/**
	 * woocommerce_after_subcategory hook.
	 *
	 * @hooked woocommerce_template_loop_category_link_close - 10
	 */
	do_action('woocommerce_after_subcategory', $category);
	?>
</div>