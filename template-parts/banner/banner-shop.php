<?php
global $product;
$screenID = $getOptionsPageBanner = $html = $pageBannerImage = $pageBannerColor = $pageCustomTitleSwitch = $pageCustomTitle = $pageCustomSubTitleSwitch = $pageCustomSubTitle = $defaultBannerImg = $pageBannerImageLink = $bannerColorSchemaValue = $bannerColorSchemaLoad = $prodSingleCustomSubTitle = '';
$pageCustomTitleSwitch = $pageCustomSubTitleSwitch = $prodSingleCustomSubTitleSwitch = 'on';
$pageBannerSwitch = $showBreadCrumb = 'off';
$blog_color_schema = [];
$pageBannerType = 'image';
$pageBannerTextColor = '#fff';

if (is_shop()) {
    $screenID = get_option('woocommerce_shop_page_id');
} elseif (is_cart()) {
    $screenID = get_option('woocommerce_cart_page_id');
} elseif (is_checkout()) {
    $screenID = get_option('woocommerce_checkout_page_id');
} elseif (is_account_page()) {
    $screenID = get_option('woocommerce_myaccount_page_id');
}

$defaultBannerImg = get_template_directory_uri() . '/assets/images/profile-cover.png';
$getOptionsPageBanner = !empty(get_post_meta($screenID, '_woo_general_get_option', true)) ? get_post_meta($screenID, '_woo_general_get_option', true) : 'global';
$allowed_html = wp_kses_allowed_html('post');


if ($getOptionsPageBanner !== 'local') {
    if (function_exists('CartsyGlobalOptionData')) {
        $pageBannerSwitch            = !empty(CartsyGlobalOptionData('woo_banner_switch')) ? CartsyGlobalOptionData('woo_banner_switch') : 'off';
        $showBreadCrumb              = !empty(CartsyGlobalOptionData('woo_page_breadcrumb_switch')) ? CartsyGlobalOptionData('woo_page_breadcrumb_switch') : 'off';
        $pageBannerType              = CartsyGlobalOptionData('woo_banner_type');
        $pageBannerImage             = CartsyGlobalOptionData('woo_banner_image');
        $pageBannerColor             = CartsyGlobalOptionData('woo_banner_color');
        $pageCustomSubTitleSwitch    = CartsyGlobalOptionData('woo_custom_subtitle_switch');
        $pageCustomSubTitle          = CartsyGlobalOptionData('woo_custom_subtitle');
        $pageBannerTextColor         = CartsyGlobalOptionData('woo_banner_text_color');
    }
} else {
    if (function_exists('CartsyLocalOptionData')) {
        $pageBannerSwitch            = !empty(CartsyLocalOptionData($screenID, '_woo_banner_switch', 'true')) ? CartsyLocalOptionData($screenID, '_woo_banner_switch', 'true') : 'off';
        $pageBannerType              = CartsyLocalOptionData($screenID, '_woo_banner_type', 'true');
        $pageBannerImageLink         = CartsyLocalOptionData($screenID, '_woo_banner_image', 'true');
        $pageCustomSubTitleSwitch    = CartsyLocalOptionData($screenID, '_woo_custom_subtitle_switch', 'true');
        $pageCustomSubTitle          = CartsyLocalOptionData($screenID, '_woo_custom_subtitle', 'true');

        $pageBannerColor             = CartsyLocalOptionData($screenID, '_woo_banner_color', 'true');
        $pageBannerTextColor         = CartsyLocalOptionData($screenID, '_woo_banner_text_color', 'true');

        // Setting Default values
        $pageBannerSwitch = $pageBannerSwitch !== '' ? $pageBannerSwitch : 'on';
        $pageBannerType = $pageBannerType !== '' ? $pageBannerType : 'image';
        $pageBannerColor = $pageBannerColor !== '' ? $pageBannerColor : '#323232';
        $pageCustomSubTitleSwitch = $pageCustomSubTitleSwitch !== '' ? $pageCustomSubTitleSwitch : 'on';
        $pageBannerTextColor = $pageBannerTextColor !== '' ? $pageBannerTextColor : '#ffffff';

        if (!empty($pageBannerImageLink) && isset($pageBannerImageLink)) {
            $pageBannerImage = $pageBannerImageLink[0]['url'];
        }
        array_push($blog_color_schema, [
            'pageBannerBGColor' => $pageBannerColor,
            'pageBannerTextColor' => $pageBannerTextColor,
        ]);
        $bannerColorSchemaValue = BannerDynamicCSS($blog_color_schema);
        if (!empty($bannerColorSchemaValue)) {
            $bannerColorSchemaLoad .= "style='$bannerColorSchemaValue'";
        }
    }
}

?>

<!-- the_post_thumbnail_url -->
<?php if (!is_product()) { ?>
    <?php if (!empty($pageBannerSwitch) && $pageBannerSwitch === 'on') { ?>

        <?php if ($pageBannerType === 'image') { ?>
            <!-- Banner with image start -->
            <div class="cartsy-page-title image">
                <?php if (!empty($pageBannerImage)) { ?>
                    <div class="cartsy-page-thumb-area">
                        <img src="<?php echo esc_url($pageBannerImage); ?>" alt="<?php woocommerce_page_title(); ?>" />
                    </div>
                <?php } ?>

                <div class="cartsy-page-title-content">
                    <?php if (!empty($pageCustomSubTitleSwitch) &&  $pageCustomSubTitleSwitch === 'on') { ?>
                        <?php if (!empty($pageCustomSubTitle)) { ?>
                            <span><?php echo wp_kses($pageCustomSubTitle, $allowed_html); ?></span>
                        <?php } else { ?>
                            <span><?php echo esc_html__('explore', 'cartsy'); ?></span>
                        <?php } ?>
                    <?php } ?>
                    <?php if (is_shop() || is_archive()) { ?>
                        <h1><?php woocommerce_page_title(); ?></h1>
                    <?php } else { ?>
                        <h1><?php the_title(); ?></h1>
                    <?php } ?>
                    <?php
                    if ($showBreadCrumb === 'on') {
                        if (function_exists('CartsyBreadcrumb')) {
                            CartsyBreadcrumb();
                        }
                    }
                    ?>
                </div>
            </div>
            <!-- Banner with image end -->
        <?php } else { ?>
            <!-- Banner with color start -->
            <div class="cartsy-page-title color" <?php echo apply_filters('shop_banner_color_schema', $bannerColorSchemaLoad); ?>>
                <div class="cartsy-page-title-content">
                    <?php if (!empty($pageCustomSubTitleSwitch) &&  $pageCustomSubTitleSwitch === 'on') : ?>
                        <?php if (!empty($pageCustomSubTitle)) : ?>
                            <span><?php echo wp_kses($pageCustomSubTitle, $allowed_html); ?></span>
                        <?php else : ?>
                            <span><?php echo esc_html__('explore', 'cartsy'); ?></span>
                        <?php endif; ?>
                    <?php endif; ?>
                    <?php if (is_shop() || is_archive()) { ?>
                        <h1><?php woocommerce_page_title(); ?></h1>
                    <?php } else { ?>
                        <h1><?php the_title(); ?></h1>
                    <?php } ?>
                    <?php
                    if ($showBreadCrumb === 'on') {
                        if (function_exists('CartsyBreadcrumb')) {
                            CartsyBreadcrumb();
                        }
                    }
                    ?>
                </div>
            </div>
            <!-- Banner with color end -->
        <?php } ?>

    <?php } ?>
<?php } ?>