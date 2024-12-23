<?php
$screenID = $footerDisplay = $footerDisplayPost = $getOptionsFrom = $getFooterPost = $getFooterContent = '';

$screenID = CartsyGetCurrentPageID();
$allowedHTML = wp_kses_allowed_html('post');

$getOptionsFrom = !empty(get_post_meta($screenID, '_footer_get_option', true)) ? get_post_meta($screenID, '_footer_get_option', true) : 'global';

if ($getOptionsFrom !== 'local') {
    if (function_exists('CartsyGlobalOptionData')) {
        $footerDisplay     = CartsyGlobalOptionData('footer_switch');
        $footerDisplayPost = CartsyGlobalOptionData('footer_layout_select');
    }
} else {
    if (function_exists('CartsyLocalOptionData')) {
        $footerDisplay = CartsyLocalOptionData($screenID, '_footer_switch', 'true');
        $footerDisplayPost = CartsyLocalOptionData($screenID, '_footer_layout_select', 'true');
    }
}
if (!empty($footerDisplayPost)) {
    $args = array(
        'post_type'     => array('footer'),
        'post_status'   => array('publish'),
        'p'             => $footerDisplayPost
    );
    $footerPost = new WP_Query($args);
}

if (isset($footerPost) && $footerPost->have_posts()) {
    // The Loop
    while ($footerPost->have_posts()) {
        $footerPost->the_post();
        if ($footerDisplay !== 'off') {
?>
            <div class="cartsy-site-footer-content">
                <?php the_content(); ?>
            </div>
<?php
        }
        // End Loop
    }
}

// Restore original Post Data
wp_reset_postdata();

?>