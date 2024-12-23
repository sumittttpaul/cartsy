<?php

/**
 * The template for displaying 404 pages (not found)
 *
 * @package Cartsy
 */

get_header();
?>

<div class="cartsy-404">
	<img src="<?php echo esc_url(CARTSY_IMAGE_PATH . '404.png') ?>" alt="<?php esc_attr_e('Page not found', 'cartsy'); ?>">
	<h1>
		<?php esc_html_e('Oops! That page can not be found.', 'cartsy'); ?>
	</h1>
	<p>
		<?php esc_html_e('The page you are looking for is no longer here. Maybe it was never here in the first place.', 'cartsy') ?>
	</p>
	<a class="button button-primary button-medium" href="<?php echo esc_url(site_url()) ?>">
		<span class="button-icon">
			<i class="ion ion-ios-arrow-round-back"></i>
		</span>
		<?php echo esc_html__('Go Back', 'cartsy'); ?>
	</a>
</div>

<?php
get_footer();
