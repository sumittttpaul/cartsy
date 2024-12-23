<?php

/**
 * Review Comments Template
 *
 * Closing li is left out on purpose!.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/review.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 2.6.0
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

remove_action('woocommerce_review_before', 'woocommerce_review_display_gravatar', 10);
remove_action('woocommerce_review_before_comment_meta', 'woocommerce_review_display_rating', 10);
remove_action('woocommerce_review_meta', 'woocommerce_review_display_meta', 10);
?>


<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">

    <div id="comment-<?php comment_ID(); ?>" class="product-review">

        <div class="product-review-head">
            <div class="product-review-gravatar">
                <?php woocommerce_review_display_gravatar($comment); ?>
            </div>
            <div class="product-review-meta">
                <div class="product-review-author">
                    <?php woocommerce_review_display_meta($comment); ?>
                </div>
                <div class="product-review-rating">
                    <?php woocommerce_review_display_rating($comment); ?>
                </div>
            </div>
        </div>

        <?php
        /**
         * The woocommerce_review_before hook
         *
         * @hooked woocommerce_review_display_gravatar - 10
         */
        do_action('woocommerce_review_before', $comment);
        ?>

        <div class="product-review-content">

            <?php
            /**
             * The woocommerce_review_before_comment_meta hook.
             *
             * @hooked woocommerce_review_display_rating - 10
             */
            do_action('woocommerce_review_before_comment_meta', $comment);
            ?>

            <?php
            /**
             * The woocommerce_review_meta hook.
             *
             * @hooked woocommerce_review_display_meta - 10
             */
            do_action('woocommerce_review_meta', $comment);
            ?>


            <?php do_action('woocommerce_review_before_comment_text', $comment); ?>

            <?php
            /**
             * The woocommerce_review_comment_text hook
             *
             * @hooked woocommerce_review_display_comment_text - 10
             */
            do_action('woocommerce_review_comment_text', $comment);
            ?>

            <?php do_action('woocommerce_review_after_comment_text', $comment); ?>

        </div>
    </div>