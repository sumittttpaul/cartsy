<?php
$screenID = $getOptionsPageBanner = $html = $pageBannerImage = $pageBannerColor = $pageCustomTitleSwitch = $pageCustomTitle = $pageCustomSubTitle = $defaultBannerImg = $pageBannerImageLink = $blogBannerColorSchemaValue = $blogBannerColorSchemaLoad = '';
$blog_color_schema = [];
$pageBannerSwitch = $showBreadCrumb = 'off';
$pageBannerType = 'color';
$pageCustomSubTitleSwitch = 'on';

$screenID = CartsyGetCurrentPageID();
$defaultBannerImg = get_template_directory_uri() . '/assets/images/profile-cover.jpg';
$banner_title     = get_the_title();
$getOptionsPageBanner = !empty(get_post_meta($screenID, '_blog_get_option', true)) ? get_post_meta($screenID, '_blog_get_option', true) : 'global';
$allowedHTML = wp_kses_allowed_html('post');


if ($getOptionsPageBanner !== 'local') {
    if (function_exists('CartsyGlobalOptionData')) {
        $pageBannerSwitch            = CartsyGlobalOptionData('blog_baner_switch') ? CartsyGlobalOptionData('blog_baner_switch') : 'off';
        $showBreadCrumb = !empty(CartsyGlobalOptionData('blog_breadcrumb_switch')) ? CartsyGlobalOptionData('blog_breadcrumb_switch') : 'off';
        $pageBannerType              = CartsyGlobalOptionData('blog_banner_type');
        $pageBannerImage             = CartsyGlobalOptionData('blog_banner_image');
        $pageBannerColor             = CartsyGlobalOptionData('blog_banner_color');
        $pageBannerTextColor         = CartsyGlobalOptionData('blog_banner_text_color');
        $pageCustomSubTitle          = CartsyGlobalOptionData('blog_banner_subtitle');
        $pageCustomSubTitleSwitch    = CartsyGlobalOptionData('blog_banner_subtitle_switch');
    }
} else {
    if (function_exists('CartsyLocalOptionData')) {
        $pageBannerSwitch            = CartsyLocalOptionData($screenID, '_blog_baner_switch', 'true') ? CartsyLocalOptionData($screenID, '_blog_baner_switch', 'true') : 'on';
        $pageBannerType              = CartsyLocalOptionData($screenID, '_blog_banner_type', 'true');
        $pageBannerImageLink         = CartsyLocalOptionData($screenID, '_blog_banner_image', 'true');
        $pageBannerColor             = CartsyLocalOptionData($screenID, '_blog_banner_color', 'true');
        $pageBannerTextColor             = CartsyLocalOptionData($screenID, '_blog_banner_text_color', 'true');
        // Setting Default values
        $pageBannerSwitch = $pageBannerSwitch !== '' ? $pageBannerSwitch : 'on';
        $pageBannerType = $pageBannerType !== '' ? $pageBannerType : 'image';
        $pageBannerColor = $pageBannerColor !== '' ? $pageBannerColor : '#323232';
        $pageBannerTextColor = $pageBannerTextColor !== '' ? $pageBannerTextColor : '#ffffff';

        if (!empty($pageBannerImageLink) && isset($pageBannerImageLink)) {
            $pageBannerImage = $pageBannerImageLink[0]['url'];
        }
        array_push($blog_color_schema, [
            'blogBannerBGColor' => $pageBannerColor,
            'blogBannerTextColor' => $pageBannerTextColor,
        ]);
        $blogBannerColorSchemaValue = BlogDynamicCSS($blog_color_schema);
        if (!empty($blogBannerColorSchemaValue)) {
            $blogBannerColorSchemaLoad .= "style='$blogBannerColorSchemaValue'";
        }
    }
}
?>

<?php if (!empty($pageBannerSwitch) && $pageBannerSwitch !== 'off') { ?>
    <?php if ($pageBannerType !== 'color') { ?>
        <div class="cartsy-page-title cartsy-banner-type-blog">
            <?php if (!empty($pageBannerImage)) { ?>
                <div class="cartsy-page-thumb-area">
                    <img src="<?php echo esc_url($pageBannerImage); ?>" alt="<?php the_title(); ?>" />
                </div>
            <?php } ?>
            <div class="cartsy-page-title-content">
                <span><?php echo esc_html__('explore', 'cartsy'); ?></span>
                <h1><?php the_title(); ?></h1>
                <?php
                if ($showBreadCrumb === 'on') {
                    if (function_exists('CartsyBreadcrumb')) {
                        CartsyBreadcrumb();
                    }
                }
                ?>
            </div>
        </div>
    <?php } else { ?>
        <div class="cartsy-page-title cartsy-banner-type-blog color" <?php echo apply_filters('blog_single_banner_color_schema', $blogBannerColorSchemaLoad) ?>>
            <div class="cartsy-page-title-content">
                <?php if ($pageCustomSubTitleSwitch !== 'off') { ?>
                    <?php if (!empty($pageCustomSubTitle)) { ?>
                        <span><?php echo wp_kses($pageCustomSubTitle, $allowedHTML); ?></span>
                    <?php } else { ?>
                        <span><?php echo esc_html__('explore', 'cartsy'); ?></span>
                    <?php } ?>
                <?php } ?>
                <h1><?php the_title(); ?></h1>
                <?php
                if ($showBreadCrumb === 'on') {
                    if (function_exists('CartsyBreadcrumb')) {
                        CartsyBreadcrumb();
                    }
                }
                ?>
            </div>
        </div>
    <?php } ?>
<?php } ?>