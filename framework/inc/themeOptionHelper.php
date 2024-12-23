<?php

/**
 * 
 *  Theme Options Settings related functions are listed here
 *
 * Function Lists
 * 
 *  - CartsyGlobalOptionData()
 *  - CartsyLocalOptionData()
 *  - CartsyGetCurrentPageID()
 * 
 */

if (!defined('ABSPATH')) {
    exit('Direct script access denied.');
}

$globalOptions = $localOptions = $screenID = '';

/** 
 * ****** Page Global Settings Parameters ******
 * 
 * Config Key name : cartsy_config
 * 
 * 
 * :::::: Header Section ::::::
 * header_switch
 * header_sticky_switch
 * header_initial_color
 * header_sticky_bg_color
 * header_menu_color
 * header_menu_hover_color
 * header_typography_setting
 * 
 * :::::: Footer Section ::::::
 * footer_switch
 * footer_layout_select
 * 
 * :::::: Copyright Section ::::::
 * copyright_switch
 * copyright_social_area_switch
 * copyright_texts
 * copyright_bg_color
 * copyright_typography_setting
 * 
 * :::::: Banner Section ::::::
 * page_banner_switch
 * page_banner_type
 * page_banner_image
 * page_banner_color
 * page_custom_title_switch
 * page_custom_title
 * page_custom_subtitle_switch
 * page_custom_subtitle
 * 
 * :::::: Typography Section ::::::
 * body_typography_setting
 * heading1_typography_setting
 * heading2_typography_setting
 * heading3_typography_setting
 * heading4_typography_setting
 * heading5_typography_setting
 * heading6_typography_setting
 * 
 * :::::: Color Settings ::::::
 * cartsy_primary_color 
 * cartsy_secondary_color
 * cartsy_dark_text_color
 * cartsy_light_text_color
 * banner_text_color
 * 
 * :::::: Social Profile Section ::::::
 * social_profile_switch
 * fb_switch
 * fb_profile_link
 * twitter_switch
 * tw_profile_link
 * linkedin_switch
 * linkedin_profile_link
 * instagram_switch
 * instagram_profile_link
 * pinterest_switch
 * pinterest_profile_link
 * dribble_switch
 * dribble_profile_link
 * youtube_switch
 * youtube_profile_link
 * 
 * 
 * :::::: Blog Section ::::::
 * blog_type
 * blog_sidebar_switch
 * blog_page_banner
 * blog_custom_title_switch
 * blog_custom_title
 * blog_custom_subtitle_switch
 * blog_custom_subtitle
 * blog_typography_setting
 * 
 * :::::: WooCommerce Section ::::::
 * woo_sidebar_switch
 * woo_sidebar_position
 * woo_cart_sidebar_position
 * woo_checkout_sidebar_position
 * woo_my_account_sidebar_position
 * woo_banner_switch
 * woo_banner_type
 * woo_banner_image
 * woo_banner_color
 * woo_banner_text_color
 * woo_custom_subtitle_switch
 * woo_custom_subtitle
 * 
 * :::::: WooCommerce Product Single Section ::::::
 * woo_single_sidebar_switch
 * 
 */


if (class_exists('Kirki')) {
    if (!function_exists('CartsyGlobalOptionData')) {
        /**
         * CartsyGlobalOptionData
         *
         * @param  mixed $optionKey
         * @return string|integer
         */
        function CartsyGlobalOptionData($optionKey)
        {
            $globalOptions = Kirki::get_option('cartsy_config', $optionKey);
            return $globalOptions;
        }
    }
}



/** 
 * 
 * ****** Page Local Settings Parameters ******
 * 
 * :::::: Header Area ::::::
 * 
 * _header_switch
 * _header_sticky_switch
 * _header_initial_color
 * _header_sticky_bg_color
 * _header_menu_color
 * _header_menu_hover_color
 *
 * 
 * :::::: Banner Area ::::::
 * 
 * _page_banner_switch
 * _page_banner_type
 * _page_banner_image
 * _page_banner_color
 * _page_custom_title_switch
 * _page_custom_title
 * _page_custom_subtitle_switch
 * _page_custom_subtitle
 * 
 * 	:::::: Blog Area ::::::
 * 
 * _blog_type
 * _blog_sidebar_switch
 * _blog_page_banner
 * _blog_custom_title_switch
 * _blog_custom_title
 * _blog_custom_subtitle_switch
 * _blog_custom_subtitle
 * 
 * :::::: Footer Area ::::::
 * 
 * _footer_switch
 * _footer_layout_select
 * 
 * :::::: Copyright Area ::::::
 * 
 * _copyright_switch
 * _copyright_social_area_switch
 * _copyright_texts
 * _copyright_bg_color
 * _copyright_font_color
 * 
 * :::::: Social profile Area ::::::
 * 
 * _social_profile_get_option
 * _social_profile_switch
 * _fb_switch
 * _fb_profile_link
 * _twitter_switch
 * _tw_profile_link
 * _linkedin_switch
 * _linkedin_profile_link
 * _instagram_switch
 * _instagram_profile_link
 * _pinterest_switch
 * _pinterest_profile_link
 * _dribble_switch
 * _dribble_profile_link
 * _youtube_switch
 * _youtube_profile_link
 * 
 * :::::: WooCommerce Section ::::::
 * 
 * _woo_sidebar_switch
 * _woo_sidebar_position
 * 
 * _woo_banner_switch
 * _woo_banner_type
 * _woo_banner_image
 * _woo_banner_color
 * _woo_banner_text_color
 * _woo_custom_subtitle_switch
 * _woo_custom_subtitle
 * 
 * */

if (!function_exists('CartsyLocalOptionData')) {
    /**
     * CartsyLocalOptionData
     *
     * @param  mixed $postID
     * @param  mixed $metaKey
     * @param  mixed $boolean
     * @return string|integer
     */
    function CartsyLocalOptionData($postID, $metaKey, $boolean)
    {
        $localOptions = get_post_meta($postID, $metaKey, $boolean);
        return $localOptions;
    }
}

if (!function_exists('CartsyGetCurrentPageID')) {
    /**
     * CartsyGetCurrentPageID
     *
     * @return string|integer
     */
    function CartsyGetCurrentPageID()
    {
        if ((is_archive()) || (is_author()) || (is_category()) || (is_home()) || (is_single()) || (is_tag())) {
            $screenID = get_option('page_for_posts');
            return $screenID;
        } else {
            $screenID = get_queried_object_id();
            return $screenID;
        }
    }
}
