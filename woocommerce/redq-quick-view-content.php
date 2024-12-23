<?php

/**
 * Quick view content.
 *
 * @author  REDQ
 * @package REDQ WooCommerce Quick View
 * @version 1.0.0
 */

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}


$loadGalleryClass = '';
$size = 'woocommerce_single';
$imageSize = apply_filters('single_product_archive_thumbnail_size', $size);
$placeholderImage = CARTSY_IMAGE_PATH . 'placeholder-icon.svg';

$product = wc_get_product($product_ID);
$galleryImageIDs = $product ?  $product->get_gallery_image_ids() : '';

if (!empty($galleryImageIDs) && has_post_thumbnail()) {
	$loadGalleryClass = "quick-view-product-preview";
} elseif (empty($galleryImageIDs) && has_post_thumbnail()) {
	$loadGalleryClass = "quick-view-product-preview only-thumb";
} elseif (!empty($galleryImageIDs) && !has_post_thumbnail()) {
	$loadGalleryClass = "quick-view-product-preview without-thumb";
} else {
	$loadGalleryClass = "quick-view-product-preview fallback";
}

while (have_posts()) :
	the_post();
?>

	<div id="product-<?php the_ID(); ?>" <?php post_class('product'); ?>>
		<div class="product-thumb cartsy-pop-up">
			<?php //woocommerce_show_product_images(); 
			?>

			<div class="<?php echo esc_attr($loadGalleryClass); ?>">

				<?php if (empty($galleryImageIDs) && has_post_thumbnail()) { ?>
					<!-- no gallery but thumb  -->
					<?php the_post_thumbnail(); ?>
					<!-- no gallery but thumb end  -->
				<?php } elseif (!empty($galleryImageIDs)) { ?>
					<!-- gallery but no-thumb  -->
					<div class="swiper-container quick-view-slider">
						<div class="swiper-wrapper">
							<?php if (has_post_thumbnail()) { ?>
								<div class="swiper-slide"><?php the_post_thumbnail(); ?></div>
							<?php } ?>
							<?php foreach ($galleryImageIDs as $key => $galleryImageID) { ?>
								<?php
								$sliderImageURL = wp_get_attachment_image_url($galleryImageID, $imageSize) ? wp_get_attachment_image_url($galleryImageID, $imageSize) : CARTSY_IMAGE_PATH . 'placeholder-icon.svg';
								$sliderImageSrcset = wp_get_attachment_image_srcset($galleryImageID, $imageSize);
								$sliderImageSizes = wp_get_attachment_image_sizes($galleryImageID, $imageSize);
								?>
								<div class="swiper-slide"><img src="<?php echo esc_url($sliderImageURL); ?>" srcset="<?php echo esc_attr($sliderImageSrcset) ?>" sizes="<?php echo esc_attr($sliderImageSizes); ?>" alt="product-grid-gallery-item"></div>
							<?php } ?>
						</div>
						<div class="swiper-pagination"></div>
					</div>
					<!-- gallery but no-thumb end  -->
				<?php } else { ?>
					<!-- fallback  -->
					<img class="fallback-product-thumbnail" src="<?php echo esc_url($placeholderImage); ?>" alt="product-grid-gallery-item">
					<!-- fallback end  -->
				<?php } ?>

			</div>

		</div>

		<div class="summary entry-summary cartsy-pop-up">
			<a href="<?php echo esc_url(get_the_permalink()); ?>" class="cartsy-pop-up-product-title">
				<?php woocommerce_template_single_title(); ?>
			</a>


			<?php woocommerce_template_single_excerpt(); ?>

			<?php woocommerce_template_single_price(); ?>

			<?php woocommerce_template_single_add_to_cart(); ?>

			<a href="<?php echo esc_url(get_the_permalink()); ?>" class="quick-view-product-link">
				<?php echo esc_html__('View Details'); ?>
				<i class="ion ion-ios-arrow-round-forward"></i>
			</a>

			<input type="hidden" data-product_id="<?php the_ID(); ?>" name="pop_up_product_id" value="<?php the_ID(); ?>">

		</div>
	</div>

<?php
endwhile; // end of the loop.
