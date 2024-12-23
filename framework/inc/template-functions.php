<?php

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function cartsy_body_classes($classes)
{
    if (!is_singular()) {
        $classes[] = 'cartsy-page';
    }

    if (!is_active_sidebar('cartsy-sidebar')) {
        $classes[] = 'no-sidebar';
    }

    return $classes;
}

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function cartsy_pingback_header()
{
    if (is_singular() && pings_open()) {
        printf('<link rel="pingback" href="%s">', esc_url(get_bloginfo('pingback_url')));
    }
}

if (!function_exists('cartsy_loaded')) {
    /**
     * Page loader
     *
     * @since 1.2
     */
    function cartsy_loaded()
    {
        if (get_theme_mod('site_loader', 'on') === 'on') {
            $template = cartsy_get_global_template_slug() . '/loader';
        } else {
            $template = '';
        }
        get_template_part($template);
    }
}

if (!function_exists('cartsy_header_wrapper_start')) {
    /**
     * Header wrapper start
     *
     * @since 1.2
     */
    function cartsy_header_wrapper_start()
    {
        $layout   = cartsy_get_header_layout();
        $template = cartsy_get_header_template_slug() . '/' . $layout . '/wrapper-start';

        get_template_part($template);
    }
}

if (!function_exists('cartsy_header_wrapper_end')) {
    /**
     * Header wrapper end
     *
     * @since 1.2
     */
    function cartsy_header_wrapper_end()
    {
        $layout   = cartsy_get_header_layout();
        $template = cartsy_get_header_template_slug() . '/' . $layout . '/wrapper-end';

        get_template_part($template);
    }
}

if (!function_exists('cartsy_header_menu')) {
    /**
     * Header menu
     *
     * @since 1.2
     */
    function cartsy_header_menu()
    {
        $layout   = cartsy_get_header_layout();
        $template = cartsy_get_header_template_slug() . '/' . $layout . '/menu';

        get_template_part($template);
    }
}

if (!function_exists('cartsy_site_branding')) {
    /**
     * Site branding
     *
     * @since 1.2
     */
    function cartsy_site_branding()
    {
        $layout   = cartsy_get_header_layout();
        $template = cartsy_get_header_template_slug() . '/' . $layout . '/branding';

        get_template_part($template);
    }
}

if (!function_exists('cartsy_header_search')) {
    /**
     * Header search
     *
     * @since 1.2
     */
    function cartsy_header_search()
    {
        $layout   = cartsy_get_header_layout();
        $template = cartsy_get_header_template_slug() . '/' . $layout . '/search';

        get_template_part($template);
    }
}

if (!function_exists('cartsy_header_lang')) {
    /**
     * Header language
     *
     * @since 1.2
     */
    function cartsy_header_lang()
    {
        if (!class_exists('SitePress')) {
            return;
        }

        $langSwitcher         = get_theme_mod('cartsy_lang_switcher', 'off');
        $langSwitcherPosition = get_theme_mod('cartsy_lang_switcher_position', 'horizontal_menu');

        if ($langSwitcher === 'off' || $langSwitcherPosition !== 'horizontal_menu') {
            return;
        }

        $template = cartsy_get_global_template_slug() . '/language';
        get_template_part($template);
    }
}

if (!function_exists('cartsy_drawer_menu_lang')) {
    /**
     * Header language
     *
     * @since 1.2
     */
    function cartsy_drawer_menu_lang()
    {
        $langSwitcher         = get_theme_mod('cartsy_lang_switcher', 'off');
        $langSwitcherPosition = get_theme_mod('cartsy_lang_switcher_position', 'horizontal_menu');

        if ($langSwitcher === 'off' || $langSwitcherPosition !== 'drawer_menu') {
            return;
        }

        $template = cartsy_get_global_template_slug() . '/language';
        get_template_part($template);
    }
}

if (!function_exists('cartsy_woo_link')) {
    /**
     * Header woo-links[my account, mini-cart]
     *
     * @since 1.2
     */
    function cartsy_woo_link()
    {
        $layout   = cartsy_get_header_layout();
        $template = cartsy_get_header_template_slug() . '/' . $layout . '/woolink';

        get_template_part($template);
    }
}

if (!function_exists('cartsy_banner')) {
    /**
     * Cartsy banner
     *
     * @return void
     */
    function cartsy_banner()
    {
        if (cartsy_is_blog()) {
            $name = 'banner-blog';
        } elseif (is_singular('post')) {
            $name = 'banner-single';
        } elseif (cartsy_is_woo_page()) {
            $name = 'banner-shop';
        } elseif (class_exists('WooCommerce') && is_product()) {
            $name = 'banner-none';
        } else {
            $name = 'banner';
        }

        $template = cartsy_get_banner_template_slug() . '/' . $name;

        get_template_part($template);
    }
}

if (!function_exists('cartsy_footer')) {
    /**
     * Cartsy footer
     *
     * @return void
     */
    function cartsy_footer()
    {
        $layout   = cartsy_get_footer_layout();
        $template = cartsy_get_footer_template_slug() . '/' . $layout . '/footer';

        get_template_part($template);
    }
}

if (!function_exists('cartsy_copyright')) {
    /**
     * Cartsy copyright
     *
     * @return void
     */
    function cartsy_copyright()
    {
        $layout   = cartsy_get_copyright_layout();
        $template = cartsy_get_copyright_template_slug() . '/' . $layout . '/copyright';

        get_template_part($template);
    }
}

if (!function_exists('cartsy_popup_newsletter')) {
    /**
     * Cartsy popup newsletter
     *
     * @return void
     */
    function cartsy_popup_newsletter()
    {
        if (function_exists('cartsyNewsLetterInit')) {
            cartsyNewsLetterInit();
        }
    }
}

if (!function_exists('cartsy_popup_authentication')) {
    /**
     * Cartsy popup authentication
     *
     * @return void
     */
    function cartsy_popup_authentication()
    {
        if (function_exists('cartsyPopUpAuthentication')) {
            cartsyPopUpAuthentication();
        }
    }
}
