<?php

if (!function_exists('cartsy_is_blog')) {
    /**
     * Check whether blog template or not
     *
     * @since 1.2
     */
    function cartsy_is_blog()
    {
        if ((is_archive() || is_author() || is_category() || is_home() || is_tag() || is_search()) && (get_post_type() === 'post')) {
            return true;
        }
        return false;
    }
}


if (!function_exists('cartsy_is_woo_page')) {
    /**
     * Check whether woocommerce archive template or not
     *
     * @since 1.2
     */
    function cartsy_is_woo_page()
    {
        if (class_exists('WooCommerce') && (is_archive() || is_shop() || is_cart() || is_account_page() || is_checkout())) {
            return true;
        }

        return false;
    }
}

if (!function_exists('cartsy_get_header_layout')) {
    /**
     * Header layout
     *
     * @since 1.2
     */
    function cartsy_get_header_layout()
    {
        $layout = 'default';
        return get_theme_mod('cartsy_header_layout', $layout);
    }
}

if (!function_exists('cartsy_get_footer_layout')) {
    /**
     * Footer layout
     *
     * @since 1.2
     */
    function cartsy_get_footer_layout()
    {
        $layout = 'default';
        return get_theme_mod('cartsy_footer_layout', $layout);
    }
}


if (!function_exists('cartsy_get_copyright_layout')) {
    /**
     * Copyright layout
     *
     * @since 1.2
     */
    function cartsy_get_copyright_layout()
    {
        $layout = 'default';
        return get_theme_mod('cartsy_copyright_layout', $layout);
    }
}

if (!function_exists('cartsy_get_header_template_slug')) {
    /**
     * Header templates slug
     *
     * @since 1.2
     */
    function cartsy_get_header_template_slug()
    {
        return 'template-parts/header';
    }
}


if (!function_exists('cartsy_get_banner_template_slug')) {
    /**
     * Banner templates slug
     *
     * @since 1.2
     */
    function cartsy_get_banner_template_slug()
    {
        return 'template-parts/banner';
    }
}


if (!function_exists('cartsy_get_footer_template_slug')) {
    /**
     * Footer templates slug
     *
     * @since 1.2
     */
    function cartsy_get_footer_template_slug()
    {
        return 'template-parts/footer';
    }
}

if (!function_exists('cartsy_get_copyright_template_slug')) {
    /**
     * Copyright templates slug
     *
     * @since 1.2
     */
    function cartsy_get_copyright_template_slug()
    {
        return 'template-parts/copyright';
    }
}

if (!function_exists('cartsy_get_global_template_slug')) {
    /**
     * Header templates slug
     *
     * @since 1.2
     */
    function cartsy_get_global_template_slug()
    {
        return 'template-parts/global';
    }
}


if (!function_exists('cartsy_get_multi_lang_args')) {
    /**
     * Multi-language args
     *
     * @since 1.2
     */
    function cartsy_get_multi_lang_args()
    {
        if (!class_exists('SitePress')) {
            return;
        }

        global $sitepress;

        $languages = $sitepress->get_ls_languages();
        $display_as = get_theme_mod('cartsy_lang_switcher_as', 'translated_name');
        $active_language = [];
        $inactive_languages = [];

        foreach ($languages as $key => $language) {
            if ($language['active']) {
                $active_language[$key] = $language;
                $active_language[$key]['display_as'] = $display_as;
            } else {
                $inactive_languages[$key] = $language;
                $inactive_languages[$key]['display_as'] = $display_as;
            }
        }

        $args = [
            'languages'          => $languages,
            'active_language'    => reset($active_language),
            'inactive_languages' => $inactive_languages,
            'display_as'         => $display_as,
            'css_class' => get_theme_mod('cartsy_lang_switcher_position', 'horizontal_menu') === 'horizontal_menu' ? 'header-language' : 'drawer-language',
        ];

        return $args;
    }
}

/**
 * is_rental_product
 *
 * @param mixed $product_id
 *
 * @return bool
 */
function cartsy_rental_product($product_id)
{
    $is_product = wc_get_product($product_id);
    $product_type = $is_product ? $is_product->get_type() : '';

    return (isset($product_type) && $product_type === 'redq_rental');
}


/**
 * Generate css class if rnb plugin installed
 *
 * @return string
 */
function cartsy_rental_checkout_class(){
	if (class_exists('WC_Product_Redq_Rental')){
		return 'rnb-rental-checkout';
	}

	return '';
}
