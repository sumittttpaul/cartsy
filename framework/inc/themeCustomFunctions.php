<?php

/**
 *
 * Custom all functions will be listed here in this file
 *
 * Function Lists
 *
 *  - CartsySocialProfile()
 *  - cartsyLocalOptionsChanges()
 *  - CartsyComments()
 *  - cartsyFontVariantSplit()
 *  - globalDynamicCSS()
 *  - is_listing_opened($id)
 *  - ThemeRelatedPluginCheck()
 *  - ThemeServerRequirmentCheck
 *  - HeaderDynamicCSS($value)
 *  - BannerDynamicCSS($value)
 *  - BlogDynamicCSS($value)
 *  - CopyrightDynamicCSS($value)
 *  - DemoImportingCheck()
 *  - CartsyCartLink() 
 *
 */

if (!defined('ABSPATH')) {
    exit('Direct script access denied.');
}


if (!function_exists('CartsyCartLink')) {
    /**
     * Cart Link
     * Displayed a link to the cart including the number of items present and the cart total
     *
     * @return void
     * @since  1.0.0
     */
    function CartsyCartLink()
    {
        $args = [];
        $layout = get_theme_mod('woo_mini_cart_position', 'header-cart');

        $layouts = [
            'header-cart' => 'cart-counter/header.php',
            'middle-cart' => 'cart-counter/middle.php',
            'footer-cart' => 'cart-counter/footer.php',
        ];

        $cart_layout = isset($layouts[$layout]) ? $layouts[$layout] : 'cart-counter/header.php';

        wc_get_template($cart_layout, $args);
    }
}

if (!function_exists('DemoImportingCheck')) {
    /**
     * DemoImportingCheck
     *
     * @return bool
     */
    function DemoImportingCheck()
    {
        $plugin_check_cartsy_algolia = false;
        $plugin_check_cartsy_helper = false;
        $plugin_check_google_map = false;
        $plugin_check_OCDI = false;
        $plugin_check_kirki = false;
        $plugin_check_cartsy_algolia_settings = false;
        $plugin_check_WooCommerce = false;
        $activation_check = false;
        $cartsy_algolia_settings = get_option('cartsy_algolia_settings');

        if (
            !empty($cartsy_algolia_settings)
            && $cartsy_algolia_settings['la_application_id'] != ''
            && $cartsy_algolia_settings['la_search_only_api_key'] != ''
            && $cartsy_algolia_settings['la_admin_api_key'] != ''
            && $cartsy_algolia_settings['la_index_name'] != ''
        ) {
            $plugin_check_cartsy_algolia_settings = true;
        }

        if (class_exists('CartsyAlgolia')) {
            $plugin_check_cartsy_algolia = true;
        }
        if (class_exists('CartsyHelper')) {
            $plugin_check_cartsy_helper = true;
        }
        if (class_exists('Load_Google_Map')) {
            $plugin_check_google_map = true;
        }
        if (class_exists('OCDI_Plugin')) {
            $plugin_check_OCDI = true;
        }
        if (class_exists('Kirki')) {
            $plugin_check_kirki = true;
        }
        if (class_exists('WooCommerce')) {
            $plugin_check_WooCommerce = true;
        }

        if (!empty(get_option('cartsy_server_options'))) {
            $activation_check = true;
        }
        // $plugin_check_cartsy_algolia == true &&
        // $plugin_check_cartsy_algolia_settings = true;
        if (
            $activation_check == true && $plugin_check_cartsy_helper == true && $plugin_check_google_map == true && $plugin_check_OCDI == true && $plugin_check_kirki == true && $plugin_check_WooCommerce == true
        ) {
            return true;
        }

        return false;
    }
}


if (!function_exists('ThemeServerRequirmentCheck')) {
    /**
     * ThemeServerRequirmentCheck
     *
     * @return bool
     */
    function ThemeServerRequirmentCheck()
    {
        global $wp_version, $wpdb;

        $WP_VERSION = '5.0.0';
        $WP_VERSION_CHECK = false;

        $WP_MEMORY_LIMIT = '256M';
        $WP_MEMORY_LIMIT_CHECK = false;

        $PHP_VERSION = '7.0.0';
        $PHP_VERSION_CHECK = false;

        $PHP_MAX_INPUT_VARIABLES = '3000';
        $PHP_MAX_INPUT_VARIABLES_CHECK = false;

        $PHP_MAX_EXECUTION_TIME = '30';
        $PHP_MAX_EXECUTION_TIME_CHECK = false;

        $PHP_MAX_POST_SIZE = '8M';
        $PHP_MAX_POST_SIZE_CHECK = false;

        $MAX_UPLOAD_SIZE = '16 MB';
        $MAX_UPLOAD_SIZE_CHECK = false;

        $DB_SCHEMA = '';
        $MYSQL_VERSION = '5.6';
        $MARIA_DB_VERSION = '10.1';
        $DB_VERSION_CHECK = false;

        $serverVersion = $wpdb->get_var('SELECT VERSION()');
        if (strpos($serverVersion, 'MariaDB') !== false) {
            $DB_SCHEMA = 'mariaDB';
        } else {
            $DB_SCHEMA = 'mysql';
        }
        if (!empty($DB_SCHEMA) && $DB_SCHEMA === 'mariaDB') {
            $DB_VERSION = $MARIA_DB_VERSION;
        } else {
            $DB_VERSION = $MYSQL_VERSION;
        }

        if ($wp_version >= $WP_VERSION) {
            $WP_VERSION_CHECK = true;
        }

        if ((int) filter_var(WP_MEMORY_LIMIT, FILTER_SANITIZE_NUMBER_INT) >= (int) filter_var($WP_MEMORY_LIMIT, FILTER_SANITIZE_NUMBER_INT)) {
            $WP_MEMORY_LIMIT_CHECK = true;
        }

        if (phpversion() >= $PHP_VERSION) {
            $PHP_VERSION_CHECK = true;
        }

        if (ini_get('max_input_vars') >= $PHP_MAX_INPUT_VARIABLES) {
            $PHP_MAX_INPUT_VARIABLES_CHECK = true;
        }

        if (ini_get('max_execution_time') >= $PHP_MAX_EXECUTION_TIME) {
            $PHP_MAX_EXECUTION_TIME_CHECK = true;
        }
        if (ini_get('post_max_size') >= (int) filter_var($PHP_MAX_POST_SIZE, FILTER_SANITIZE_NUMBER_INT)) {
            $PHP_MAX_POST_SIZE_CHECK = true;
        }
        if ((int) filter_var(size_format(wp_max_upload_size()), FILTER_SANITIZE_NUMBER_INT) >= (int) filter_var($MAX_UPLOAD_SIZE, FILTER_SANITIZE_NUMBER_INT)) {
            $MAX_UPLOAD_SIZE_CHECK = true;
        }

        if ($wpdb->db_version() >= $DB_VERSION) {
            $DB_VERSION_CHECK = true;
        }

        if (
            $WP_VERSION_CHECK == true && $WP_MEMORY_LIMIT_CHECK == true && $PHP_VERSION_CHECK == true && $PHP_MAX_INPUT_VARIABLES_CHECK == true && $PHP_MAX_EXECUTION_TIME_CHECK == true &&  $PHP_MAX_POST_SIZE_CHECK == true && $MAX_UPLOAD_SIZE_CHECK == true && $DB_VERSION_CHECK == true
        ) {
            return true;
        }

        return false;
    }
}




if (!function_exists('ThemeRelatedPluginCheck')) {
    /**
     * ThemeRelatedPluginCheck
     *
     * @return bool
     */
    function ThemeRelatedPluginCheck()
    {
        $plugin_check_redq_reuse_form = false;
        $plugin_check_cartsy_algolia = false;
        $plugin_check_cartsy_helper = false;
        $plugin_check_google_map = false;
        $plugin_check_OCDI = false;
        $plugin_check_kirki = false;
        $plugin_check_WooCommerce = false;


        if (class_exists('RedqReuseForm')) {
            $plugin_check_redq_reuse_form = true;
        }

        if (class_exists('WooCommerce')) {
            $plugin_check_WooCommerce = true;
        }

        if (class_exists('CartsyAlgolia')) {
            $plugin_check_cartsy_algolia = true;
        }
        if (class_exists('CartsyHelper')) {
            $plugin_check_cartsy_helper = true;
        }
        if (class_exists('Load_Google_Map')) {
            $plugin_check_google_map = true;
        }
        if (class_exists('OCDI_Plugin')) {
            $plugin_check_OCDI = true;
        }
        if (class_exists('Kirki')) {
            $plugin_check_kirki = true;
        }

        if (
            $plugin_check_redq_reuse_form == true && $plugin_check_cartsy_algolia == true && $plugin_check_cartsy_helper == true && $plugin_check_google_map == true && $plugin_check_OCDI == true && $plugin_check_kirki == true && $plugin_check_WooCommerce == true
        ) {
            return true;
        }

        return false;
    }
}



/**
 * cartsyBrokenImagePath
 *
 * @return void
 */
function cartsyBrokenImagePath()
{
    $icon = '';
    $themeBrokenIcon = CARTSY_IMAGE_PATH . 'broken-icon.svg';
    $icon .= '<style id="theme-image-path" type="text/css">
      :root {
        --themeBrokenIcon: url(' . $themeBrokenIcon . ');
      }
    </style>';
    echo apply_filters('cartsy_custom_icons', $icon);
}
add_action('wp_head', 'cartsyBrokenImagePath');
add_action('admin_head', 'cartsyBrokenImagePath');

if (!function_exists('HeaderDynamicCSS')) {
    /**
     * HeaderDynamicCSS
     *
     * @param  mixed $headerColorSchemaData
     * @return void
     */
    function HeaderDynamicCSS($headerColorSchemaData)
    {
        $variables =  $transparentHeader = $defaultHeaderColor = $stickyHeaderColor = $transparentHeaderTextColor = $transparentHeaderHoverTextColor = $headerMenuColor = $headerMenuHoverColor = $menuTextColor = $menuTextHoverColor = $stickyHeaderMenuColor = $stickyHeaderMenuHoverColor = '';

        if (!empty($headerColorSchemaData)) {
            foreach ($headerColorSchemaData as $value) {
                $transparentHeader               = !empty($value['transparentHeader']) ? $value['transparentHeader'] : 'off';
                $defaultHeaderColor              = !empty($value['defaultHeaderColor']) ? $value['defaultHeaderColor'] : '#ffffff';
                $stickyHeaderColor               = !empty($value['stickyHeaderColor']) ? $value['stickyHeaderColor'] : '#ffffff';
                $transparentHeaderTextColor      = !empty($value['transparentHeaderTextColor']) ? $value['transparentHeaderTextColor'] : '#ffffff';
                $transparentHeaderHoverTextColor = !empty($value['transparentHeaderHoverTextColor']) ? $value['transparentHeaderHoverTextColor'] : '#eaeaea';
                $headerMenuColor                 = !empty($value['headerMenuColor']) ? $value['headerMenuColor'] : '#484848';
                $headerMenuHoverColor            = !empty($value['headerMenuHoverColor']) ? $value['headerMenuHoverColor'] : '#f64e54';
                $menuTextColor                   = $transparentHeader === 'on' ? $transparentHeaderTextColor : $headerMenuColor;
                $menuTextHoverColor              = $transparentHeader === 'on' ? $transparentHeaderHoverTextColor : $headerMenuHoverColor;
                $stickyHeaderMenuColor           = !empty($value['stickyHeaderMenuColor']) ? $value['stickyHeaderMenuColor'] : '#484848';
                $stickyHeaderMenuHoverColor      = !empty($value['stickyHeaderMenuHoverColor']) ? $value['stickyHeaderMenuHoverColor'] : '#f64e54';
            }
        }
        $variables .= '
            --localDefaultHeaderColor: ' . $defaultHeaderColor . '; 
            --localStickyHeaderColor: ' . $stickyHeaderColor . ';
            --localMenuTextColor: ' . $menuTextColor . '; 
            --localMenuTextHoverColor: ' . $menuTextHoverColor . '; 
            --localStickyMenuTextColor: ' . $stickyHeaderMenuColor . '; 
            --localStickyMenuTextHoverColor: ' . $stickyHeaderMenuHoverColor . ';
        ';
        return $variables;
    }
}

if (!function_exists('BannerDynamicCSS')) {
    /**
     * BannerDynamicCSS
     *
     * @param  mixed $bannerColorSchema
     * @return void
     */
    function BannerDynamicCSS($bannerColorSchema)
    {
        $variables = $pageBannerBGColor = $pageBannerTextColor = '';
        if (!empty($bannerColorSchema)) {
            foreach ($bannerColorSchema as $value) {
                $pageBannerBGColor = $value['pageBannerBGColor'];
                $pageBannerTextColor = $value['pageBannerTextColor'];
            }
        }
        $variables .= '
            --localPageBannerBGColor: ' . $pageBannerBGColor . ';
            --localPageBannerTextColor: ' . $pageBannerTextColor . ';
        ';
        return $variables;
    }
}

if (!function_exists('BlogDynamicCSS')) {
    /**
     * BlogDynamicCSS
     *
     * @param  mixed $blogColorSchema
     * @return void
     */
    function BlogDynamicCSS($blogColorSchema)
    {
        $variables = $blogBannerBGColor = $blogBannerBGTextColor = '';
        if (!empty($blogColorSchema)) {
            foreach ($blogColorSchema as $value) {
                $blogBannerBGColor = $value['blogBannerBGColor'];
                $blogBannerBGTextColor = $value['blogBannerTextColor'];
            }
        }
        $variables .= '
            --localBlogBannerBGColor: ' . $blogBannerBGColor . ';
            --localBlogBannerTextColor: ' . $blogBannerBGTextColor . ';
        ';
        return $variables;
    }
}

if (!function_exists('CopyrightDynamicCSS')) {
    /**
     * CopyrightDynamicCSS
     *
     * @param  mixed $copyrightColorSchemaData
     * @return void
     */
    function CopyrightDynamicCSS($copyrightColorSchemaData)
    {
        $variables = $copyrightBGColor = $copyrightFontColor = '';
        if (!empty($copyrightColorSchemaData)) {
            foreach ($copyrightColorSchemaData as $value) {
                $copyrightBGColor = !empty($value['copyrightBGColor']) ? $value['copyrightBGColor'] : '#ffffff';
                $copyrightFontColor = !empty($value['copyrightFontColor']) ? $value['copyrightFontColor'] : '#333333';
            }
        }
        $variables .= '
            --localCopyrightBGColor: ' . $copyrightBGColor . ';
            --localCopyrightFontColor: ' . $copyrightFontColor . ';
        ';
        return $variables;
    }
}


/**
 * cartsyFontVariantSplit
 *
 * @param  mixed $fontVariantSplit
 * @return void
 */
function cartsyFontVariantSplit($fontVariantSplit)
{
    $fontWeight = '';
    $fontStyle = '';

    if (is_numeric($fontVariantSplit[0]) === true) {
        if (count($fontVariantSplit) > 1) {
            $fontWeight = $fontVariantSplit[0];
            array_splice($fontVariantSplit, 0, 1);
            $fontStyle = join("", $fontVariantSplit);
        } else {
            $fontWeight = $fontVariantSplit[0];
        }
    } else {
        $fontStyle = join("", $fontVariantSplit);
    }
    return ['font-weight' => $fontWeight, 'font-style' => $fontStyle,];
}

/**
 * globalDynamicCSS
 *
 * @return void
 */
function globalDynamicCSS()
{
    // setting variables
    $transparentHeader = 'off';
    $bannerType = 'image';
    $blogBannerType = 'image';
    // typography control variables
    $bodyTypography = $menuTypography = $copyrightTypography = $heading1 = $heading2 = $heading3 = $heading4 = $heading5 = $heading6 = [];
    // color and string control variables
    $bodyFontWeight = $bodyFontStyle = $copyrightFontWeight = $copyrightFontStyle = $h1FontWeight = $h1FontStyle = $h2FontWeight = $h2FontStyle = $h3FontWeight = $h3FontStyle = $h4FontWeight = $h4FontStyle = $h5FontWeight = $h5FontStyle = $h6FontWeight = $h6FontStyle = $defaultHeaderColor = $stickyHeaderColor = $primaryColor = $primaryHoverColor = $secondaryColor = $darkTextColor = $mainTextColor =  $lightTextColor = $lighterTextColor = $bannerTextColor = $menuTextColor = $menuTextHoverColor = $stickyMenuTextColor = $stickyMenuTextHoverColor = $bannerBackground = $copyrightBGColor = $blogBannerBackground = $blogBannerTextColor = '';

    if (function_exists('CartsyGlobalOptionData')) {
        // header settings and color
        $transparentHeader = CartsyGlobalOptionData('header_transparent_switch');
        $defaultHeaderColor = CartsyGlobalOptionData('header_initial_color');
        $stickyHeaderColor = CartsyGlobalOptionData('header_sticky_bg_color');

        // menu settings and color
        $menuTypography = CartsyGlobalOptionData('menu_typography_setting');
        $stickyMenuTextColor =  CartsyGlobalOptionData('sticky_header_menu_color');
        $stickyMenuTextHoverColor = CartsyGlobalOptionData('sticky_header_menu_hover_color');
        $menuTextColor =  $transparentHeader === 'on' ? CartsyGlobalOptionData('transparent_header_menu_color') : CartsyGlobalOptionData('header_menu_color');
        $menuTextHoverColor = $transparentHeader === 'on' ? CartsyGlobalOptionData('transparent_header_menu_hover_color') : CartsyGlobalOptionData('header_menu_hover_color');

        // page banner settings and color
        $bannerType = CartsyGlobalOptionData('page_banner_type');
        $bannerBackground = $bannerType === 'image' ? CartsyGlobalOptionData('page_banner_image') : CartsyGlobalOptionData('page_banner_color');
        $bannerBackground = !empty($bannerBackground) ? $bannerBackground : '#323232';
        $bannerTextColor   = CartsyGlobalOptionData('page_banner_text_color');

        // blog banner settings and color
        $blogBannerType = CartsyGlobalOptionData('blog_banner_type');
        $blogBannerBackground = !empty($blogBannerBackground) ? $blogBannerBackground : '#323232';
        $blogBannerTextColor   = CartsyGlobalOptionData('blog_banner_text_color');

        // copyright settings and color
        $copyrightBGColor = CartsyGlobalOptionData('copyright_bg_color');

        // colors
        $primaryColor = CartsyGlobalOptionData('cartsy_primary_color');
        $primaryHoverColor = CartsyGlobalOptionData('cartsy_primary_hover_color');
        $secondaryColor = CartsyGlobalOptionData('cartsy_secondary_color');
        $darkTextColor = CartsyGlobalOptionData('cartsy_dark_text_color');
        $mainTextColor = CartsyGlobalOptionData('cartsy_main_text_color');
        $lightTextColor = CartsyGlobalOptionData('cartsy_light_text_color');
        $lighterTextColor = CartsyGlobalOptionData('cartsy_lighter_text_color');

        // typography
        $heading1   = CartsyGlobalOptionData('heading1_typography_setting');
        $heading2   = CartsyGlobalOptionData('heading2_typography_setting');
        $heading3   = CartsyGlobalOptionData('heading3_typography_setting');
        $heading4   = CartsyGlobalOptionData('heading4_typography_setting');
        $heading5   = CartsyGlobalOptionData('heading5_typography_setting');
        $heading6   = CartsyGlobalOptionData('heading6_typography_setting');
        $bodyTypography = CartsyGlobalOptionData('body_typography_setting');
        $copyrightTypography = CartsyGlobalOptionData('copyright_typography_setting');

        // split font weight and font style 
        $h1FontVariantSplit = str_split($heading1['variant'], 3);
        $h2FontVariantSplit = str_split($heading2['variant'], 3);
        $h3FontVariantSplit = str_split($heading3['variant'], 3);
        $h4FontVariantSplit = str_split($heading4['variant'], 3);
        $h5FontVariantSplit = str_split($heading5['variant'], 3);
        $h6FontVariantSplit = str_split($heading6['variant'], 3);
        $bodyFontVariantSplit = str_split($bodyTypography['variant'], 3);
        $copyrightTypographySplit = str_split($copyrightTypography['variant'], 3);

        // get font wight and font style 
        $h1FontVariant = cartsyFontVariantSplit($h1FontVariantSplit);
        $h1FontWeight = !empty($h1FontVariant['font-weight']) ? $h1FontVariant['font-weight'] : '700';
        $h1FontStyle = !empty($h1FontVariant['font-style']) ? $h1FontVariant['font-style'] : 'regular';

        $h2FontVariant = cartsyFontVariantSplit($h2FontVariantSplit);
        $h2FontWeight = !empty($h2FontVariant['font-weight']) ? $h2FontVariant['font-weight'] : '700';
        $h2FontStyle = !empty($h2FontVariant['font-style']) ? $h2FontVariant['font-style'] : 'regular';

        $h3FontVariant = cartsyFontVariantSplit($h3FontVariantSplit);
        $h3FontWeight = !empty($h3FontVariant['font-weight']) ? $h3FontVariant['font-weight'] : '700';
        $h3FontStyle = !empty($h3FontVariant['font-style']) ? $h3FontVariant['font-style'] : 'regular';

        $h4FontVariant = cartsyFontVariantSplit($h4FontVariantSplit);
        $h4FontWeight = !empty($h4FontVariant['font-weight']) ? $h4FontVariant['font-weight'] : '700';
        $h4FontStyle = !empty($h4FontVariant['font-style']) ? $h4FontVariant['font-style'] : 'regular';

        $h5FontVariant = cartsyFontVariantSplit($h5FontVariantSplit);
        $h5FontWeight = !empty($h5FontVariant['font-weight']) ? $h5FontVariant['font-weight'] : '700';
        $h5FontStyle = !empty($h5FontVariant['font-style']) ? $h5FontVariant['font-style'] : 'regular';

        $h6FontVariant = cartsyFontVariantSplit($h6FontVariantSplit);
        $h6FontWeight = !empty($h6FontVariant['font-weight']) ? $h6FontVariant['font-weight'] : '700';
        $h6FontStyle = !empty($h6FontVariant['font-style']) ? $h6FontVariant['font-style'] : 'regular';

        $bodyFontVariant = cartsyFontVariantSplit($bodyFontVariantSplit);
        $bodyFontWeight = !empty($bodyFontVariant['font-weight']) ? $bodyFontVariant['font-weight'] : '400';
        $bodyFontStyle = !empty($bodyFontVariant['font-style']) ? $bodyFontVariant['font-style'] : 'regular';

        $copyrightFontVariant = cartsyFontVariantSplit($copyrightTypographySplit);
        $copyrightFontWeight = !empty($copyrightFontVariant['font-weight']) ? $copyrightFontVariant['font-weight'] : '400';
        $copyrightFontStyle = !empty($copyrightFontVariant['font-style']) ? $copyrightFontVariant['font-style'] : 'regular';
    }

    $cssVariables = '';
    $cssVariables .= "
  :root {
    --bodyFontFamily: " . $bodyTypography['font-family'] . ";
    --bodyFontSize: " . $bodyTypography['font-size'] . ";
    --bodyFontWeight: " . $bodyFontWeight . ";
    --bodyFontStyle: " . $bodyFontStyle . ";
    --bodyLineHeight: " . $bodyTypography['line-height'] . ";

    --defaultHeaderColor: " . $defaultHeaderColor . ";

    --menuTextColor: " . $menuTextColor . ";
    --menuTextHoverColor: " . $menuTextHoverColor . ";
    --menuFontSize: " . $menuTypography['font-size'] . ";
    --menuFontFamily: " . $menuTypography['font-family'] . ";
    --menulineHeight: " . $menuTypography['line-height'] . ";
    --menuFontWeight: " . $menuTypography['variant'] . ";

    --bannerBackground: " . $bannerBackground . ";
    --bannerTextColor: " . $bannerTextColor . ";
    --blogBannerBackground: " . $blogBannerBackground . ";
    --blogBannerTextColor: " . $blogBannerTextColor . ";

    --copyrightBGColor: " . $copyrightBGColor . ";
    --copyrightFontFamily: " . $copyrightTypography['font-family'] . ";
    --copyrightFontSize: " . $copyrightTypography['font-size'] . ";
    --copyrightFontWeight: " . $copyrightFontWeight . ";
    --copyrightFontStyle: " . $copyrightFontStyle . ";
    --copyrightLineHeight: " . $copyrightTypography['line-height'] . ";
    --copyrightColor: " . $copyrightTypography['color'] . ";

    --colorPrimary: " . $primaryColor . ";
    --colorPrimaryHover: " . $primaryHoverColor . ";
    --colorSecondary: " . $secondaryColor . ";
    --colorTextDark: " . $darkTextColor . ";
    --colorTextMain: " . $mainTextColor . ";
    --colorTextLight: " . $lightTextColor . ";
    --colorTextLighter: " . $lighterTextColor . ";

    --h1FontFamily: " . $heading1['font-family'] . ";
    --h1FontSize: " . $heading1['font-size'] . ";
    --h1FontWeight: " . $h1FontWeight . ";
    --h1FontStyle: " . $h1FontStyle . ";
    --h1LineHeight: " . $heading1['line-height'] . ";
    --h1Color: " . $heading1['color'] . ";
    --h1LetterSpacing: " . $heading1['letter-spacing'] . ";
    --h1TextTransform: " . $heading1['text-transform'] . ";

    --h2FontFamily: " . $heading2['font-family'] . ";
    --h2FontSize: " . $heading2['font-size'] . ";
    --h2FontWeight: " . $h2FontWeight . ";
    --h2FontStyle: " . $h2FontStyle . ";
    --h2LineHeight: " . $heading2['line-height'] . ";
    --h2Color: " . $heading2['color'] . ";
    --h2LetterSpacing: " . $heading2['letter-spacing'] . ";
    --h2TextTransform: " . $heading2['text-transform'] . ";

    --h3FontFamily: " . $heading3['font-family'] . ";
    --h3FontSize: " . $heading3['font-size'] . ";
    --h3FontWeight: " . $h3FontWeight . ";
    --h3FontStyle: " . $h3FontStyle . ";
    --h3LineHeight: " . $heading3['line-height'] . ";
    --h3Color: " . $heading3['color'] . ";
    --h3LetterSpacing: " . $heading3['letter-spacing'] . ";
    --h3TextTransform: " . $heading3['text-transform'] . ";

    --h4FontFamily: " . $heading4['font-family'] . ";
    --h4FontSize: " . $heading4['font-size'] . ";
    --h4FontWeight: " . $h4FontWeight . ";
    --h4FontStyle: " . $h4FontStyle . ";
    --h4LineHeight: " . $heading4['line-height'] . ";
    --h4Color: " . $heading4['color'] . ";
    --h4LetterSpacing: " . $heading4['letter-spacing'] . ";
    --h4TextTransform: " . $heading4['text-transform'] . ";

    --h5FontFamily: " . $heading5['font-family'] . ";
    --h5FontSize: " . $heading5['font-size'] . ";
    --h5FontWeight: " . $h5FontWeight . ";
    --h5FontStyle: " . $h5FontStyle . ";
    --h5LineHeight: " . $heading5['line-height'] . ";
    --h5Color: " . $heading5['color'] . ";
    --h5LetterSpacing: " . $heading5['letter-spacing'] . ";
    --h5TextTransform: " . $heading5['text-transform'] . ";

    --h6FontFamily: " . $heading6['font-family'] . ";
    --h6FontSize: " . $heading6['font-size'] . ";
    --h6FontWeight: " . $h6FontWeight . ";
    --h6FontStyle: " . $h6FontStyle . ";
    --h6LineHeight: " . $heading6['line-height'] . ";
    --h6Color: " . $heading6['color'] . ";
    --h6LetterSpacing: " . $heading6['letter-spacing'] . ";
    --h6TextTransform: " . $heading6['text-transform'] . ";
  }
  ";
    wp_add_inline_style('cartsy_swiper_css', $cssVariables);
}

if (class_exists('CartsyHelper') && class_exists('Kirki')) {
    add_action('wp_enqueue_scripts', 'globalDynamicCSS');
}


if (!function_exists('CartsySocialProfile')) {
    /**
     * CartsySocialProfile
     *
     * @return void
     */
    function CartsySocialProfile()
    {

        $pinterestSwitch = $pinterestLink = $dribbleSwitch = $dribbleLink = $youtubeSwitch = $youtubeLink = $socialProfileDisplay = $facebookSwitch = $facebookLink = $twitterSwitch = $twitterLink = $linkedinSwitch = $linkedinLink =  $instagramSwitch = $instagramLink = $getOptionsFrom = $screenID = $html = '';

        $screenID = CartsyGetCurrentPageID();
        $getOptionsFrom = !empty(get_post_meta($screenID, '_social_profile_get_option', true)) ? get_post_meta($screenID, '_social_profile_get_option', true) : 'global';

        if ($getOptionsFrom !== 'local') {
            if (function_exists('CartsyGlobalOptionData')) {
                $socialProfileDisplay   = CartsyGlobalOptionData('social_profile_switch');
                $facebookSwitch         = CartsyGlobalOptionData('fb_switch');
                $facebookLink           = CartsyGlobalOptionData('fb_profile_link');
                $twitterSwitch          = CartsyGlobalOptionData('twitter_switch');
                $twitterLink            = CartsyGlobalOptionData('tw_profile_link');
                $linkedinSwitch         = CartsyGlobalOptionData('linkedin_switch');
                $linkedinLink           = CartsyGlobalOptionData('linkedin_profile_link');
                $instagramSwitch        = CartsyGlobalOptionData('instagram_switch');
                $instagramLink          = CartsyGlobalOptionData('instagram_profile_link');
                $pinterestSwitch        = CartsyGlobalOptionData('pinterest_switch');
                $pinterestLink          = CartsyGlobalOptionData('pinterest_profile_link');
                $dribbleSwitch        = CartsyGlobalOptionData('dribble_switch');
                $dribbleLink          = CartsyGlobalOptionData('dribble_profile_link');
                $youtubeSwitch        = CartsyGlobalOptionData('youtube_switch');
                $youtubeLink          = CartsyGlobalOptionData('youtube_profile_link');
            }
        } else {
            if (function_exists('CartsyLocalOptionData')) {
                $socialProfileDisplay   = CartsyLocalOptionData($screenID, '_social_profile_switch', 'true');
                $facebookSwitch         = CartsyLocalOptionData($screenID, '_fb_switch', 'true');
                $facebookLink           = CartsyLocalOptionData($screenID, '_fb_profile_link', 'true');
                $twitterSwitch          = CartsyLocalOptionData($screenID, '_twitter_switch', 'true');
                $twitterLink            = CartsyLocalOptionData($screenID, '_tw_profile_link', 'true');
                $linkedinSwitch         = CartsyLocalOptionData($screenID, '_linkedin_switch', 'true');
                $linkedinLink           = CartsyLocalOptionData($screenID, '_linkedin_profile_link', 'true');
                $instagramSwitch        = CartsyLocalOptionData($screenID, '_instagram_switch', 'true');
                $instagramLink          = CartsyLocalOptionData($screenID, '_instagram_profile_link', 'true');
                $pinterestSwitch        = CartsyLocalOptionData($screenID, '_pinterest_switch', 'true');
                $pinterestLink          = CartsyLocalOptionData($screenID, '_pinterest_profile_link', 'true');
                $dribbleSwitch          = CartsyLocalOptionData($screenID, '_dribble_switch', 'true');
                $dribbleLink            = CartsyLocalOptionData($screenID, '_dribble_profile_link', 'true');
                $youtubeSwitch          = CartsyLocalOptionData($screenID, '_youtube_switch', 'true');
                $youtubeLink            = CartsyLocalOptionData($screenID, '_youtube_profile_link', 'true');
            }
        }
        if ($socialProfileDisplay !== 'off') {
            $html .= '<ul class="cartsy-social-profiles">';
            if ($facebookSwitch !== 'off') {
                $html .= '<li class="cartsy-social-profile-item">';
                $html .= '<a href="' . esc_url($facebookLink ? $facebookLink : 'https://www.facebook.com/') . '" title="facebook" target="_blank" rel="noopener"><i class="ion ion-logo-facebook"></i></a>';
                $html .= '</li>';
            }
            if ($twitterSwitch !== 'off') {
                $html .= '<li class="cartsy-social-profile-item">';
                $html .= '<a href="' . esc_url($twitterLink ? $twitterLink : 'https://twitter.com/') . '" title="twitter" target="_blank" rel="noopener"><i class="ion ion-logo-twitter"></i></a>';
                $html .= '</li>';
            }
            if ($instagramSwitch !== 'off') {
                $html .= '<li class="cartsy-social-profile-item">';
                $html .= '<a href="' . esc_url($instagramLink ? $instagramLink : 'https://www.instagram.com/') . '" title="instagram" target="_blank" rel="noopener"><i class="ion ion-logo-instagram"></i></a>';
                $html .= '</li>';
            }
            if ($linkedinSwitch !== 'off') {
                $html .= '<li class="cartsy-social-profile-item">';
                $html .= '<a href="' . esc_url($linkedinLink ? $linkedinLink : 'https://www.linkedin.com/') . '" title="linkedin" target="_blank" rel="noopener"><i class="ion ion-logo-linkedin"></i></a>';
                $html .= '</li>';
            }
            if ($pinterestSwitch === 'on') {
                $html .= '<li class="cartsy-social-profile-item">';
                $html .= '<a href="' . esc_url($pinterestLink) . '" title="pinterest" target="_blank" rel="noopener"><i class="ion ion-logo-pinterest"></i></a>';
                $html .= '</li>';
            }
            if ($dribbleSwitch === 'on') {
                $html .= '<li class="cartsy-social-profile-item">';
                $html .= '<a href="' . esc_url($dribbleLink) . '" title="dribble" target="_blank" rel="noopener"><i class="ion ion-logo-dribbble"></i></a>';
                $html .= '</li>';
            }
            if ($youtubeSwitch === 'on') {
                $html .= '<li class="cartsy-social-profile-item">';
                $html .= '<a href="' . esc_url($youtubeLink) . '" title="youtube" target="_blank" rel="noopener"><i class="ion ion-logo-youtube"></i></a>';
                $html .= '</li>';
            }
            $html .= '</ul>';
        }
        return $html;
    }
}


if (!function_exists('CartsyComments')) {
    /**
     * CartsyComments
     *
     * @param  mixed $comment
     * @param  mixed $args
     * @param  mixed $depth
     * @return void
     */
    function CartsyComments($comment, $args, $depth)
    {
        $allowedHTML = wp_kses_allowed_html('post');
        $GLOBALS['comment'] = $comment;
        extract($args, EXTR_SKIP);
        $commentPostType = get_post_type($comment->comment_post_ID);
        $key = 'nickname';
        $single = true;
        $userId = !empty($comment->user_id) ? $comment->user_id : 0;
        $custom_avatar = get_user_meta($userId, 'user_custom_gravater', true);
        $user = get_userdata($userId);
        if (!$userId) {
            $display_name = $comment->comment_author;
        } else {
            $display_name = $user->user_login;
        }
        $firstName = get_user_meta($userId, 'first_name', true);
        $lastName = get_user_meta($userId, 'last_name', true);

        $authorName = $display_name;
        if ($firstName || $lastName) {
            $authorName = $firstName . ' ' . $lastName;
        }
        $avatarUrl = CARTSY_IMAGE_PATH . 'avatar.png';
        if ($custom_avatar && count($custom_avatar)) {
            $avatarUrl = $custom_avatar[0]['url'];
        }
        $comment_author_url = get_comment_author_url($comment);
        $comment_author     = get_comment_author($comment);
        $avatar             = get_avatar($comment, $args['avatar_size']);

?>
        <?php if (($commentPostType === 'post') || ($commentPostType === 'page')) { ?>
            <li <?php comment_class($args['has_children'] ? 'post-comment has-children' : 'post-comment') ?> id="comment-<?php comment_ID() ?>">
                <div class="comment-card">
                    <?php if (!empty($avatar)) { ?>
                        <div class="comment-avatar">
                            <?php echo wp_kses($avatar, $allowedHTML); ?>
                        </div>
                    <?php } ?>
                    <div class="comment-content">
                        <?php
                        if (!empty($comment_author_url)) {
                            printf('<a href="%s" rel="external nofollow" class="url">', esc_url($comment_author_url));
                        }
                        ?>
                        <div class="name">
                            <h5>
                                <?php
                                printf(
                                    wp_kses(
                                        /* translators: %s: Comment author link. */
                                        __('%s <span class="screen-reader-text says">says:</span>', 'cartsy'),
                                        array(
                                            'span' => array(
                                                'class' => array(),
                                            ),
                                        )
                                    ),
                                    '<b class="fn">' . $comment_author . '</b>'
                                );
                                ?>
                            </h5>
                        </div>
                        <?php
                        if (!empty($comment_author_url)) {
                            echo wp_kses('</a>', $allowedHTML);
                        }
                        ?>
                        <div class="content">
                            <?php if ($comment->comment_approved == '0') : ?>
                                <em> <?php esc_html_e('Your comment is awaiting moderation.', 'cartsy') ?></em><br />
                            <?php endif; ?>
                            <?php comment_text(); ?>
                        </div>
                        <div class="action">
                            <div class="date"> <?php comment_date(get_option('date_format')); ?> </div>
                            <?php comment_reply_link(array_merge($args, array('reply_text' => 'Reply' . '<i class="icon ion-ios-arrow-round-forward"></i>', 'depth' => $depth, 'max_depth' => $args['max_depth']))); ?>
                        </div>
                    </div>
                </div>

            <?php } ?>
    <?php
    }
}


if (!function_exists('cartsyCheckProductInCart')) {
    /**
     * Check product already in cart 
     *
     * @param int $product_id
     * @return boolean|int
     */
    function cartsyCheckProductInCart()
    {
        $result = [];

        if (class_exists('WooCommerce') && !empty(WC()->cart)) {
            $cart_items = WC()->cart->get_cart();
            if (!count($cart_items)) {
                return $result;
            }
            foreach ($cart_items as $cart_item_key => $cart_item) {
                $result[$cart_item['product_id']] = $cart_item['quantity'];
            }
        }

        return $result;
    }
}
