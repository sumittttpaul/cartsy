<?php


namespace Framework\App;

// Do not allow directly accessing this file.
if (!defined('ABSPATH')) {
    exit('Direct script access denied.');
}


class Script
{
    /**
     * googleFont
     *
     * @return void
     */
    public function googleFont()
    {
        $fonts_url = '';
        /** 
         *Translators: If there are characters in your language that are not
         * supported by Noto Serif, translate this to 'off'. Do not translate
         * into your own language.
         */
        $notoserif = esc_html_x('on', 'Noto Serif font: on or off', 'cartsy');
        if ('off' !== $notoserif) {
            $font_families = array();
            $font_families[] = 'Noto Serif:400,400italic,700,700italic';
            $query_args = array(
                'family' => urlencode(implode('|', $font_families)),
                'subset' => urlencode('latin,latin-ext'),
            );
            $fonts_url = add_query_arg($query_args, 'https://fonts.googleapis.com/css');
        }
        return $fonts_url;
    }

    /**
     * loadJS
     *
     * @return void
     */
    public function loadJS()
    {
        wp_enqueue_script('jquery_ui', get_theme_file_uri('/assets/libs/jquery-ui.min.js'), array(), CARTSY_VERSION, true);
        wp_enqueue_script('cartsy_swiper', get_theme_file_uri('/assets/libs/swiper-bundle.min.js'), array(), CARTSY_VERSION, true);
        wp_enqueue_script('cartsy_lazyload', get_theme_file_uri('/assets/libs/lazysizes.min.js'), array(), CARTSY_VERSION, true);
        wp_enqueue_script('cartsy-navigation', get_theme_file_uri('/assets/js/navigation.js'), array(), CARTSY_VERSION, true);
        wp_enqueue_script('sticky-sidebar', get_theme_file_uri('/assets/libs/sticky-sidebar.min.js'), array(), CARTSY_VERSION, true);
        wp_enqueue_script('simple-social-share', get_theme_file_uri('/assets/libs/simpleSocialShare.min.js'), array(), CARTSY_VERSION, true);
        wp_enqueue_script('magnific-popup-js', get_theme_file_uri('/assets/libs/jquery.magnific-popup.min.js'), array(), CARTSY_VERSION, true);
        wp_enqueue_script('overlay-scrollbar-js', get_theme_file_uri('/assets/libs/jquery.overlayScrollbars.min.js'), array(), CARTSY_VERSION, true);
        wp_enqueue_script('cartsy-skip-link-focus-fix', get_theme_file_uri('/assets/js/skip-link-focus-fix.js'), array(), CARTSY_VERSION, true);
        wp_enqueue_script('cartsy_fitvid', get_theme_file_uri('/assets/libs/jquery.fitvids.js'), array(), CARTSY_VERSION, true);
        wp_enqueue_script('cartsy_lottie', get_theme_file_uri('/assets/libs/lottie-player.js'), array(), CARTSY_VERSION, true);
        wp_enqueue_script('cartsy-common-js', get_theme_file_uri('/assets/js/common.js'), array('jquery'), CARTSY_VERSION, true);
        wp_enqueue_script('cartsy-main-woo-js', get_theme_file_uri('/assets/js/main-woo-script.js'), array('jquery'), CARTSY_VERSION, true);
        wp_enqueue_script('cartsy-main-js', get_theme_file_uri('/assets/js/main-script.js'), array('jquery'), CARTSY_VERSION, true);
        if (is_singular() && comments_open() && get_option('thread_comments')) {
            wp_enqueue_script('comment-reply');
        }
    }


    /**
     * loadCSS
     *
     * @return void
     */
    public function loadCSS()
    {
        wp_enqueue_style('cartsy_swiper_css', get_template_directory_uri() . '/assets/libs/swiper-bundle.min.css');
        wp_enqueue_style('magnific-popup-css', get_template_directory_uri() . '/assets/libs/magnific-popup.css');
        wp_enqueue_style('ionicons-min-css', get_template_directory_uri() . '/assets/libs/ionicons.min.css');
        wp_enqueue_style('overlay-scrollbar-css', get_template_directory_uri() . '/assets/libs/OverlayScrollbars.css');
        wp_enqueue_style('cartsy-blocks', get_template_directory_uri() . '/assets/css/blocks.css');
        wp_enqueue_style('cartsy-fonts', $this->googleFont());
        wp_enqueue_style('cartsy-style', get_stylesheet_uri());
        wp_enqueue_style('cartsy-main-style', get_template_directory_uri() . '/cartsy-main-style.css');
        wp_style_add_data('cartsy-main-style', 'rtl', 'replace');
        // rtl manual fixing css file load
        if (is_rtl()) {
            wp_enqueue_style('cartsy-manual-rtl-style', get_template_directory_uri() . '/assets/css/rtl-manual.css');
        }
    }


    /**
     * loadGoogleFonts
     *
     * @return void
     */
    public function loadGoogleFonts()
    {
        wp_enqueue_style('cartsy-body-font', 'https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,600;0,700;0,800;1,300;1,400;1,600;1,700;1,800&display=swap', false);
        wp_enqueue_style('cartsy-special-font', 'https://fonts.googleapis.com/css2?family=Satisfy&display=swap', false);
    }


    /**
     * loadAdminCSS
     *
     * @return void
     */
    public function loadAdminCSS()
    {
        wp_enqueue_style('cartsy-getting-started', get_template_directory_uri() . '/assets/css/getting-started.css');
    }


    /**
     * loadAdminJS
     *
     * @return void
     */
    public function loadAdminJS()
    {
        wp_enqueue_script('jquery-ui-accordion');
        // wp_enqueue_script('jquery_ui_admin', get_theme_file_uri('/assets/libs/jquery-ui.min.js'), array(), CARTSY_VERSION, true);
        wp_enqueue_script('cartsy_admin_fitvid', get_theme_file_uri('/assets/libs/jquery.fitvids.js'), array(), CARTSY_VERSION, true);
        wp_enqueue_script('cartsy_lazyload', get_theme_file_uri('/assets/libs/lazysizes.min.js'), array(), CARTSY_VERSION, true);
        wp_enqueue_script('cartsy-common-js', get_theme_file_uri('/assets/js/common.js'), array('jquery'), CARTSY_VERSION, true);
        wp_enqueue_script('cartsy_admin', get_theme_file_uri('/assets/js/cartsy-admin.js'), array(), CARTSY_VERSION, true);
        wp_enqueue_script('cartsy_swiper', get_theme_file_uri('/assets/libs/swiper-bundle.min.js'), array(), CARTSY_VERSION, true);
    }

    /**
     * cartsyCustomEditoStyles
     *
     * @return void
     */
    public function cartsyCustomEditoStyles()
    {
        $h1_font = $h2_font = $h3_font = $h4_font = $h5_font = $h6_font = $body_font = $cartsy_editor_custom_css = '';
        $cartsy_h1_font_family = $cartsy_h2_font_family = $cartsy_h3_font_family = $cartsy_h4_font_family = $cartsy_h5_font_family = $cartsy_h6_font_family = 'Poppins';
        $cartsy_h1_font_weight = $cartsy_h2_font_weight = $cartsy_h3_font_weight = $cartsy_h4_font_weight = $cartsy_h5_font_weight = $cartsy_h6_font_weight = '700';
        $cartsy_h1_font_style = $cartsy_h2_font_style = $cartsy_h3_font_style = $cartsy_h4_font_style = $cartsy_h5_font_style = $cartsy_h6_font_style = 'normal';
        $cartsy_h1_font_size = '35px';
        $cartsy_h2_font_size = '25px';
        $cartsy_h3_font_size = '19px';
        $cartsy_h4_font_size = '17px';
        $cartsy_h5_font_size = '15px';
        $cartsy_h6_font_size = '13px';


        $cartsy_body_font_family = 'Muli';
        $cartsy_body_font_weight = '400';
        $cartsy_body_font_size = '15px';
        $cartsy_body_font_style = 'normal';


        wp_enqueue_style('cartsy-custom-editor-font', get_theme_file_uri('assets/css/editor-style.css'));

        if (function_exists('CartsyGlobalOptionData')) {
            $h1_font = CartsyGlobalOptionData('heading1_typography_setting');
            $cartsy_h1_font_family = $h1_font ? $h1_font['font-family'] : 'Poppins';
            $cartsy_h1_font_weight = $h1_font ? $h1_font['font-weight'] : '700';
            $cartsy_h1_font_size = $h1_font ? $h1_font['font-size'] : '35px';
            $cartsy_h1_font_style = $h1_font ? $h1_font['font-style'] : 'normal';

            $h2_font = CartsyGlobalOptionData('heading2_typography_setting');
            $cartsy_h2_font_family = !empty($h2_font) ? $h2_font['font-family'] : 'Poppins';
            $cartsy_h2_font_weight = !empty($h2_font) ? $h2_font['font-weight'] : '700';
            $cartsy_h2_font_size = !empty($h2_font) ? $h2_font['font-size'] : '25px';
            $cartsy_h2_font_style = !empty($h2_font) ? $h2_font['font-style'] : 'normal';

            $h3_font = CartsyGlobalOptionData('heading3_typography_setting');
            $cartsy_h3_font_family = !empty($h3_font) ? $h3_font['font-family'] : 'Poppins';
            $cartsy_h3_font_weight = !empty($h3_font) ? $h3_font['font-weight'] : '700';
            $cartsy_h3_font_size = !empty($h3_font) ? $h3_font['font-size'] : '19px';
            $cartsy_h3_font_style = !empty($h3_font) ? $h3_font['font-style'] : 'normal';

            $h4_font = CartsyGlobalOptionData('heading4_typography_setting');
            $cartsy_h4_font_family = !empty($h4_font) ? $h4_font['font-family'] : 'Poppins';
            $cartsy_h4_font_weight = !empty($h4_font) ? $h4_font['font-weight'] : '700';
            $cartsy_h4_font_size = !empty($h4_font) ? $h4_font['font-size'] : '17px';
            $cartsy_h4_font_style = !empty($h4_font) ? $h4_font['font-style'] : 'normal';

            $h5_font = CartsyGlobalOptionData('heading5_typography_setting');
            $cartsy_h5_font_family = !empty($h5_font) ? $h5_font['font-family'] : 'Poppins';
            $cartsy_h5_font_weight = !empty($h5_font) ? $h5_font['font-weight'] : '700';
            $cartsy_h5_font_size = !empty($h5_font) ? $h5_font['font-size'] : '15px';
            $cartsy_h5_font_style = !empty($h5_font) ? $h5_font['font-style'] : 'normal';

            $h6_font = CartsyGlobalOptionData('heading6_typography_setting');
            $cartsy_h6_font_family = !empty($h6_font) ? $h6_font['font-family'] : 'Poppins';
            $cartsy_h6_font_weight = !empty($h6_font) ? $h6_font['font-weight'] : '700';
            $cartsy_h6_font_size = !empty($h6_font) ? $h6_font['font-size'] : '13px';
            $cartsy_h6_font_style = !empty($h6_font) ? $h6_font['font-style'] : 'normal';

            $body_font = CartsyGlobalOptionData('body_typography_setting');
            $cartsy_body_font_family = !empty($body_font) ? $body_font['font-family'] : 'Muli';
            $cartsy_body_font_weight = !empty($body_font) ? $body_font['font-weight'] : '400';
            $cartsy_body_font_size = !empty($body_font) ? $body_font['font-size'] : '15px';
            $cartsy_body_font_style = !empty($body_font) ? $body_font['font-style'] : 'normal';
        }



        $cartsy_editor_custom_css = '
			body .edit-post-visual-editor.editor-styles-wrapper { 
				font-family: ' . $cartsy_body_font_family . ';
				font-weight:' . $cartsy_body_font_weight . ';
				font-size:' . $cartsy_body_font_size . ';
				font-style: ' . $cartsy_body_font_style . ';
			}

			body .editor-post-title__block .editor-post-title__input,
			body .editor-styles-wrapper h1 { 
				font-family:' . $cartsy_h1_font_family . ';
				font-weight:' . $cartsy_h1_font_weight . ';
				font-size:' . $cartsy_h1_font_size . ';
				font-style: ' . $cartsy_h1_font_style . ';
			}

			body .editor-styles-wrapper h2 { 
				font-family:' . $cartsy_h2_font_family . ';
				font-weight:' . $cartsy_h2_font_weight . ';
				font-size:' . $cartsy_h2_font_size . ';
				font-style: ' . $cartsy_h2_font_style . ';
			}
			
			body .editor-styles-wrapper h3 { 
				font-family:' . $cartsy_h3_font_family . ';
				font-weight:' . $cartsy_h3_font_weight . ';
				font-size:' . $cartsy_h3_font_size . ';
				font-style: ' . $cartsy_h3_font_style . '; 
			}
			
			body .editor-styles-wrapper h4 { 
				font-family:' . $cartsy_h4_font_family . ';
				font-weight:' . $cartsy_h4_font_weight . ';
				font-size:' . $cartsy_h4_font_size . ';
				font-style: ' . $cartsy_h4_font_style . ';
			}
			
			body .editor-styles-wrapper h5 {
				font-family:' . $cartsy_h5_font_family . ';
				font-weight:' . $cartsy_h5_font_weight . ';
				font-size:' . $cartsy_h5_font_size . ';
				font-style: ' . $cartsy_h5_font_style . ';
			}
			
			body .editor-styles-wrapper h6 { 
				font-family:' . $cartsy_h6_font_family . ';
				font-weight:' . $cartsy_h6_font_weight . ';
				font-size:' . $cartsy_h6_font_size . ';
				font-style: ' . $cartsy_h6_font_style . ';
			}
    ';


        wp_add_inline_style('cartsy-custom-editor-font', $cartsy_editor_custom_css);
        wp_enqueue_style('cartsy_swiper_css', get_template_directory_uri() . '/assets/libs/swiper-bundle.min.css');
    }
}
