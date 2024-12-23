<?php
$siteName = $screenID = $getOptionsCopyright = $displayCopyright = $copyrightText = $copyrightSocialArea = $copyrightBGColor = $copyrightFontColor = $copyRightColorSchemaLoad = $copyRightColorSchemaValue = '';
$copyright_color_schema = [];

// $siteName = get_bloginfo('name');
$screenID = CartsyGetCurrentPageID();
$getOptionsCopyright = !empty(get_post_meta($screenID, '_copyright_get_option', true)) ? get_post_meta($screenID, '_copyright_get_option', true) : 'global';

if ($getOptionsCopyright !== 'local') {
    if (function_exists('CartsyGlobalOptionData')) {
        $displayCopyright       = CartsyGlobalOptionData('copyright_switch');
        $copyrightText          = CartsyGlobalOptionData('copyright_texts');
        $copyrightSocialArea    = CartsyGlobalOptionData('copyright_social_area_switch');
    }
} else {
    if (function_exists('CartsyLocalOptionData')) {
        $displayCopyright       = CartsyLocalOptionData($screenID, '_copyright_switch', 'true');
        $copyrightText          = CartsyLocalOptionData($screenID, '_copyright_texts', 'true');
        $copyrightSocialArea    = CartsyLocalOptionData($screenID, '_copyright_social_area_switch', 'true');
        $copyrightBGColor       = CartsyLocalOptionData($screenID, '_copyright_bg_color', 'true');
        $copyrightFontColor     = CartsyLocalOptionData($screenID, '_copyright_font_color', 'true');
    }
    array_push($copyright_color_schema, [
        'copyrightBGColor' => $copyrightBGColor,
        'copyrightFontColor' => $copyrightFontColor,
    ]);
    $copyRightColorSchemaValue = CopyrightDynamicCSS($copyright_color_schema);
    if (!empty($copyRightColorSchemaValue)) {
        $copyRightColorSchemaLoad .= "style='$copyRightColorSchemaValue'";
    }
}
?>


<?php if ($displayCopyright !== 'off') : ?>
    <div class="site-info" <?php echo apply_filters('copyright_color_schema', $copyRightColorSchemaLoad); ?>>
        <div class="copyright">
            <?php echo get_bloginfo('name'); ?>
            <?php if (!empty($copyrightText)) : ?>
                <?php echo esc_attr($copyrightText); ?>
            <?php else : ?>
                <?php echo esc_html__(' - All right reserved - Designed & Developed by RedQ Inc. &copy; 2020', 'cartsy'); ?>
            <?php endif; ?>
        </div>
        <?php if ($copyrightSocialArea !== 'off') : ?>
            <div class="cartsy-copyright-social-area">
                <?php echo CartsySocialProfile(); ?>
            </div>
        <?php endif; ?>
    </div>
<?php endif; ?>