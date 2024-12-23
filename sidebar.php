<?php

/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Cartsy
 */

if (class_exists('WooCommerce') && (is_woocommerce() || is_cart() || is_account_page() || is_checkout() || is_product())) {
	if (!is_active_sidebar('cartsy-woo-sidebar')) {
		return;
	}
} else {
	if (!is_active_sidebar('cartsy-sidebar')) {
		return;
	}
}
?>

<aside id="secondary" class="widget-area">

	<?php if (class_exists('WooCommerce') && (is_woocommerce() || is_cart() || is_account_page() || is_checkout() || is_product())) { ?>
		<?php if (is_active_sidebar('cartsy-woo-sidebar')) { ?>
			<?php dynamic_sidebar('cartsy-woo-sidebar'); ?>
		<?php } ?>
	<?php } else { ?>
		<?php if (is_active_sidebar('cartsy-sidebar')) { ?>
			<?php dynamic_sidebar('cartsy-sidebar'); ?>
		<?php } ?>
	<?php } ?>


</aside><!-- #secondary -->