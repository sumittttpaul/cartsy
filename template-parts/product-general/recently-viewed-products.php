<?php

/**
 * Prevent direct access of this page
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Function for display recently viewed products
 */
if ( ! function_exists( 'cartsyDisplayRecentlyViewedProducts' ) ) {
	function cartsyDisplayRecentlyViewedProducts( $recentlyViewedProductIds ) {
		if ( $recentlyViewedProductIds ) : ?>

            <section class="recently-viewed products">

				<?php
				$heading = apply_filters( 'woocommerce_product_related_products_heading', __( 'Recently viewed products', 'cartsy' ) );

				if ( $heading ) : ?>
                    <h2><?php echo esc_html( $heading ); ?></h2>
				<?php endif; ?>

				<?php woocommerce_product_loop_start(); ?>

				<?php foreach ( $recentlyViewedProductIds as $recentlyViewedProductId ) : ?>

					<?php
					$postObject = get_post( $recentlyViewedProductId );

					setup_postdata( $GLOBALS['post'] = &$postObject ); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited, Squiz.PHP.DisallowMultipleAssignments.Found
					?>

					<?php
					/**
					 * cartsy_product_grid_layout hook.
					 *
					 * @hooked cartsyProductGridLayout - 10 (outputs of different grid layout)
					 *
					 */
					do_action( 'cartsy_product_grid_layout' );
					?>

				<?php endforeach; ?>

				<?php woocommerce_product_loop_end(); ?>

            </section>
		<?php
		endif;
		wp_reset_postdata();
	}
}

