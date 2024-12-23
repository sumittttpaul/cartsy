<?php
defined('ABSPATH') || exit;

global $product;

$loadGalleryClass  = '';
$size              = 'woocommerce_single';
$imageSize         = apply_filters('single_product_archive_thumbnail_size', $size);
$thumbnailSizeHook = 'woocommerce_gallery_thumbnail';
$thumbnailSize     = apply_filters('single_product_archive_thumbnail_size', $thumbnailSizeHook);
$galleryImageIDs   = $product ? $product->get_gallery_image_ids() : '';
$placeholderImage  = CARTSY_IMAGE_PATH . 'placeholder-icon.svg';

if (!empty($galleryImageIDs) && has_post_thumbnail()) {
    $loadGalleryClass = "cartsy-single-product-thumbs";
} elseif (empty($galleryImageIDs) && has_post_thumbnail()) {
    $loadGalleryClass = "cartsy-single-product-thumbs only-thumb";
} elseif (!empty($galleryImageIDs) && !has_post_thumbnail()) {
    $loadGalleryClass = "cartsy-single-product-thumbs without-thumb";
} else {
    $loadGalleryClass = "cartsy-single-product-thumbs fallback";
}
?>

<div class="<?php echo esc_attr($loadGalleryClass); ?>">
    <?php if (!empty($galleryImageIDs) && has_post_thumbnail()) { ?>
        <!-- If there is feature image and gallery image available -->
        <div class="swiper-container rnb-product-gallery">
            <div class="swiper-wrapper">
                <!-- Feature Image -->
                <?php
                $featured_image = wp_get_attachment_image_url(get_post_thumbnail_id($post->ID), $imageSize);
                ?>
                <div class="swiper-slide">
                    <img src="<?php echo $featured_image; ?>" alt="rnb-product-grid-gallery-item" />
                </div>
                <!-- End Feature Image -->

                <!-- Product gallery images -->
                <?php if (!empty($galleryImageIDs) && isset($galleryImageIDs)) { ?>
                    <?php foreach ($galleryImageIDs as $key => $galleryImageID) { ?>
                        <?php
                        $sliderImageURL    = wp_get_attachment_image_url($galleryImageID, $imageSize) ? wp_get_attachment_image_url($galleryImageID, $imageSize) : CARTSY_IMAGE_PATH . 'placeholder-icon.svg';
                        $sliderImageSrcset = wp_get_attachment_image_srcset($galleryImageID, $imageSize);
                        $sliderImageSizes  = wp_get_attachment_image_sizes($galleryImageID, $imageSize);
                        ?>
                        <div class="swiper-slide">
                            <img src="<?php echo esc_url($sliderImageURL); ?>" srcset="<?php echo esc_attr($sliderImageSrcset) ?>" sizes="<?php echo esc_attr($sliderImageSizes); ?>" alt="product-grid-gallery-item">
                        </div>
                    <?php } ?>
                <?php } ?>
                <!-- End Product gallery images -->
            </div>
        </div>


        <!-- Thumbnail -->
        <div class="swiper-container rnb-product-gallery-thumb">
            <div class="swiper-wrapper">
                <!-- Feature image thumbnail -->
                <?php
                $featured_image = wp_get_attachment_image_url(get_post_thumbnail_id($post->ID), $thumbnailSize);
                ?>
                <div class="swiper-slide">
                    <img src="<?php echo $featured_image; ?>" alt="rnb-product-grid-gallery-item" />
                </div>
                <!-- End feature image thumbnail -->

                <!-- Gallery image thumbnails -->
                <?php if (!empty($galleryImageIDs) && isset($galleryImageIDs)) { ?>
                    <?php foreach ($galleryImageIDs as $key => $galleryImageID) { ?>
                        <?php
                        $carouselImageURL = wp_get_attachment_image_url($galleryImageID, $thumbnailSize);
                        ?>
                        <div class="swiper-slide">
                            <img src="<?php echo esc_url($carouselImageURL); ?>" alt="product-grid-gallery-item-thumbnail">
                        </div>
                    <?php } ?>
                    <!-- End gallery image thumbnail -->
                <?php } ?>
            </div>
        </div>
        <!-- End Thumbnail -->
        <!-- End both feature image and gallery image -->

    <?php } elseif (empty($galleryImageIDs) && has_post_thumbnail()) { ?>
        <!-- No gallery image available but feature image available  -->
        <?php the_post_thumbnail(); ?>
        <!-- End No gallery image available but feature image available  -->
    <?php } elseif (!empty($galleryImageIDs) && !has_post_thumbnail()) { ?>
        <!-- No feature image available but gallery images available  -->
        <?php if (!empty($galleryImageIDs) && isset($galleryImageIDs)) { ?>
            <div class="swiper-container rnb-product-gallery">
                <div class="swiper-wrapper">
                    <!-- Product gallery images -->
                    <?php foreach ($galleryImageIDs as $key => $galleryImageID) { ?>
                        <?php
                        $sliderImageURL    = wp_get_attachment_image_url($galleryImageID, $imageSize) ? wp_get_attachment_image_url($galleryImageID, $imageSize) : CARTSY_IMAGE_PATH . 'placeholder-icon.svg';
                        $sliderImageSrcset = wp_get_attachment_image_srcset($galleryImageID, $imageSize);
                        $sliderImageSizes  = wp_get_attachment_image_sizes($galleryImageID, $imageSize);
                        ?>
                        <div class="swiper-slide">
                            <img src="<?php echo esc_url($sliderImageURL); ?>" srcset="<?php echo esc_attr($sliderImageSrcset) ?>" sizes="<?php echo esc_attr($sliderImageSizes); ?>" alt="product-grid-gallery-item">
                        </div>
                    <?php } ?>
                    <!-- End Product gallery images -->
                </div>
            </div>
        <?php } ?>

        <!-- Thumbnail -->
        <?php if (!empty($galleryImageIDs) && isset($galleryImageIDs)) { ?>
            <div class="swiper-container rnb-product-gallery-thumb">
                <div class="swiper-wrapper">
                    <?php foreach ($galleryImageIDs as $key => $galleryImageID) { ?>
                        <?php
                        $carouselImageURL = wp_get_attachment_image_url($galleryImageID, $thumbnailSize);
                        ?>
                        <div class="swiper-slide">
                            <img src="<?php echo esc_url($carouselImageURL); ?>" alt="product-grid-gallery-item-thumbnail">
                        </div>
                    <?php } ?>
                </div>
            </div>
        <?php } ?>
        <!-- end No feature image available but gallery images available  -->
    <?php } else { ?>
        <!-- fallback  -->
        <img class="fallback-product-thumbnail" src="<?php echo esc_url($placeholderImage); ?>" alt="product-grid-gallery-item">
        <!-- fallback end  -->
    <?php } ?>
</div>