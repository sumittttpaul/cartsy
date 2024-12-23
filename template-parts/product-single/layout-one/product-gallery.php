<?php
defined('ABSPATH') || exit;

global $product;

$loadGalleryClass = '';
$size = 'woocommerce_single';
$imageSize = apply_filters('single_product_archive_thumbnail_size', $size);
$galleryImageIDs = $product ?  $product->get_gallery_image_ids() : '';
$placeholderImage = CARTSY_IMAGE_PATH . 'placeholder-icon.svg';

if (!empty($galleryImageIDs) && has_post_thumbnail()) {
    $loadGalleryClass = "cartsy-single-product-thumbs grid-cols-2 gap-10";
} elseif (empty($galleryImageIDs) && has_post_thumbnail()) {
    $loadGalleryClass = "cartsy-single-product-thumbs only-thumb";
} elseif (!empty($galleryImageIDs) && !has_post_thumbnail()) {
    $loadGalleryClass = "cartsy-single-product-thumbs grid-cols-2 gap-10 without-thumb";
} else {
    $loadGalleryClass = "cartsy-single-product-thumbs fallback";
}
?>


<div class="cartsy-single-product-gallery">
    <?php if (wp_is_mobile()) { ?>
        <div class="cartsy-single-product-mobile-gallery">
            <?php if (!empty($galleryImageIDs) && isset($galleryImageIDs)) { ?>
                <div class="swiper-container layout-one-mobile-slider">
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
            <?php } else if (empty($galleryImageIDs) && has_post_thumbnail()) { ?>
                <?php the_post_thumbnail(); ?>
            <?php } else { ?>
                <div class="cartsy-single-product-thumbs fallback">
                    <img class="fallback-product-thumbnail" src="<?php echo esc_url($placeholderImage); ?>" alt="product-grid-gallery-item">
                </div>
            <?php } ?>
        </div>
    <?php } else { ?>
        <div class="<?php echo esc_attr($loadGalleryClass); ?>">

            <?php if (!empty($galleryImageIDs) && has_post_thumbnail()) { ?>
                <!-- has both -->
                <?php the_post_thumbnail(); ?>
                <?php if (!empty($galleryImageIDs) && isset($galleryImageIDs)) { ?>
                    <?php foreach ($galleryImageIDs as $key => $galleryImageID) { ?>
                        <?php
                        $sliderImageURL = wp_get_attachment_image_url($galleryImageID, $imageSize) ? wp_get_attachment_image_url($galleryImageID, $imageSize) : CARTSY_IMAGE_PATH . 'placeholder-icon.svg';
                        $sliderImageSrcset = wp_get_attachment_image_srcset($galleryImageID, $imageSize);
                        $sliderImageSizes = wp_get_attachment_image_sizes($galleryImageID, $imageSize);
                        ?>
                        <img src="<?php echo esc_url($sliderImageURL); ?>" srcset="<?php echo esc_attr($sliderImageSrcset) ?>" sizes="<?php echo esc_attr($sliderImageSizes); ?>" alt="product-grid-gallery-item">
                    <?php } ?>
                <?php } ?>
                <!-- has both end -->
            <?php } elseif (empty($galleryImageIDs) && has_post_thumbnail()) { ?>
                <!-- no gallery but thumb  -->
                <?php the_post_thumbnail(); ?>
                <!-- no gallery but thumb end  -->
            <?php } elseif (!empty($galleryImageIDs) && !has_post_thumbnail()) { ?>
                <!-- gallery but no-thumb  -->
                <?php if (!empty($galleryImageIDs) && isset($galleryImageIDs)) { ?>
                    <?php foreach ($galleryImageIDs as $key => $galleryImageID) { ?>
                        <?php
                        $sliderImageURL = wp_get_attachment_image_url($galleryImageID, $imageSize) ? wp_get_attachment_image_url($galleryImageID, $imageSize) : CARTSY_IMAGE_PATH . 'placeholder-icon.svg';
                        $sliderImageSrcset = wp_get_attachment_image_srcset($galleryImageID, $imageSize);
                        $sliderImageSizes = wp_get_attachment_image_sizes($galleryImageID, $imageSize);
                        ?>
                        <img src="<?php echo esc_url($sliderImageURL); ?>" srcset="<?php echo esc_attr($sliderImageSrcset) ?>" sizes="<?php echo esc_attr($sliderImageSizes); ?>" alt="product-grid-gallery-item">
                    <?php } ?>
                <?php } ?>
                <!-- gallery but no-thumb end  -->
            <?php } else { ?>
                <!-- fallback  -->
                <img class="fallback-product-thumbnail" src="<?php echo esc_url($placeholderImage); ?>" alt="product-grid-gallery-item">
                <!-- fallback end  -->
            <?php } ?>

        </div>
    <?php } ?>
</div>