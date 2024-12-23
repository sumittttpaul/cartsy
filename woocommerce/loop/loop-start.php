<?php

/**
 * Product Loop Start
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/loop-start.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce/Templates
 * @version     3.3.0
 */

if (!defined('ABSPATH')) {
	exit;
}

global $woocommerce_loop;


$gridLayout = $gridWrapperClass = '';
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
		if ($woocommerce_loop['name'] == 'up-sells' || $woocommerce_loop['name'] == 'related' || $woocommerce_loop['name'] ==  'cross-sells') {
			$gridWrapperClass = 'grid-helium grid-cols-xxl-5 grid-cols-xl-5 grid-cols-lg-4 grid-cols-md-3 grid-cols-sm-3 grid-cols-2 gap-10';
		} else {
			$gridWrapperClass = 'grid-helium grid-cols-xxl-6 grid-cols-xl-5 grid-cols-md-4 grid-cols-sm-3 grid-cols-2 gap-10';
		}
		break;

	case 'grid_neon':
		if ($woocommerce_loop['name'] == 'up-sells' || $woocommerce_loop['name'] == 'related' || $woocommerce_loop['name'] ==  'cross-sells') {
			$gridWrapperClass = 'grid-neon grid-cols-xxl-5 grid-cols-xl-5 grid-cols-lg-4 grid-cols-md-3 grid-cols-sm-3 grid-cols-2 gap-10';
		} else {
			$gridWrapperClass = 'grid-neon grid-cols-xxl-6 grid-cols-xl-5 grid-cols-md-4 grid-cols-sm-3 grid-cols-2 gap-10';
		}
		break;

	case 'grid_argon':
		$gridWrapperClass = 'grid-argon grid-cols-xxl-4 grid-cols-md-3 grid-cols-xs-2 grid-cols-1 gap-30';
		break;

	case 'grid_krypton':
		if ($woocommerce_loop['name'] == 'up-sells' || $woocommerce_loop['name'] == 'related' || $woocommerce_loop['name'] ==  'cross-sells') {
			$gridWrapperClass = 'grid-krypton grid-cols-xxl-5 grid-cols-xl-5 grid-cols-lg-4 grid-cols-md-3 grid-cols-sm-3 grid-cols-2 gap-10';
		} else {
			$gridWrapperClass = 'grid-krypton grid-cols-xxl-6 grid-cols-xl-5 grid-cols-md-4 grid-cols-sm-3 grid-cols-2 gap-10';
		}
		break;

	case 'grid_xenon':
		if ($woocommerce_loop['name'] == 'up-sells' || $woocommerce_loop['name'] == 'related' || $woocommerce_loop['name'] ==  'cross-sells') {
			$gridWrapperClass = 'grid-xenon grid-cols-xxl-5 grid-cols-xl-5 grid-cols-lg-4 grid-cols-md-3 grid-cols-sm-3 grid-cols-2 gap-10';
		} else {
			$gridWrapperClass = 'grid-xenon grid-cols-xxl-6 grid-cols-xl-5 grid-cols-md-4 grid-cols-sm-3 grid-cols-2 gap-10';
		}
		break;

	case 'grid_radon':
		$gridWrapperClass = 'grid-radon grid-cols-xxl-4 grid-cols-lg-3 grid-cols-xs-2 gap-10';
		break;

	case 'grid_fluorine':
		if ($woocommerce_loop['name'] == 'up-sells' || $woocommerce_loop['name'] == 'related' || $woocommerce_loop['name'] ==  'cross-sells') {
			$gridWrapperClass = 'grid-fluorine grid-cols-xxl-5 grid-cols-xl-5 grid-cols-lg-4 grid-cols-md-3 grid-cols-sm-3 grid-cols-2';
		} else {
			$gridWrapperClass = 'grid-fluorine grid-cols-xxl-6 grid-cols-xl-5 grid-cols-md-4 grid-cols-sm-3 grid-cols-2';
		}
		break;

	case 'grid_chlorine':
		$gridWrapperClass = 'grid-chlorine grid-cols-xl-4 grid-cols-md-3 grid-cols-xs-2 grid-cols-1 gap-30';
		break;

	case 'grid_bromine':
		$gridWrapperClass = 'grid-bromine grid-cols-xl-4 grid-cols-md-3 grid-cols-xs-2 grid-cols-1 gap-30';
		break;

	case 'grid_iodine':
		$gridWrapperClass = 'grid-chlorine grid-cols-xl-4 grid-cols-md-3 grid-cols-xs-2 grid-cols-1 gap-20';
		break;

	default:
		if ($woocommerce_loop['name'] == 'up-sells' || $woocommerce_loop['name'] == 'related' || $woocommerce_loop['name'] ==  'cross-sells') {
			$gridWrapperClass = 'grid-helium grid-cols-xxl-5 grid-cols-xl-5 grid-cols-lg-4 grid-cols-md-3 grid-cols-sm-3 grid-cols-2 gap-10';
		} else {
			$gridWrapperClass = 'grid-helium grid-cols-xxl-6 grid-cols-xl-5 grid-cols-md-4 grid-cols-sm-3 grid-cols-2 gap-10';
		}
		break;
}

?>
<div class="products cartsy-archive-products columns-<?php echo esc_attr(wc_get_loop_prop('columns')); ?> <?php echo esc_attr($gridWrapperClass); ?>">