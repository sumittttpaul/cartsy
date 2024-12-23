<?php

namespace Framework\App;


// Do not allow directly accessing this file.
if (!defined('ABSPATH')) {
    exit('Direct script access denied.');
}

class Cartsy
{

    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {
        $this->scripts = new Script();
        $this->initHooks();
    }

    /**
     * initHooks
     *
     * @return void
     */
    public function initHooks()
    {
        add_action('after_setup_theme', [$this, 'setupTheme']);
        add_action('wp_enqueue_scripts', [$this->scripts, 'loadCSS']);
        add_action('wp_enqueue_scripts', [$this->scripts, 'loadJS']);
        add_action('wp_enqueue_scripts', [$this->scripts, 'loadGoogleFonts']);
        add_action('admin_enqueue_scripts', [$this->scripts, 'cartsyCustomEditoStyles']);
        add_action('admin_enqueue_scripts', [$this->scripts, 'loadGoogleFonts']);
        add_action('admin_enqueue_scripts', [$this->scripts, 'loadAdminCSS']);
        add_action('admin_enqueue_scripts', [$this->scripts, 'loadAdminJS']);
        // add_action('wp_footer', [$this, 'floating_element']);
    }

    /**
     * setupTheme
     *
     * @return void
     */
    public function setupTheme()
    {
        if (!isset($content_width)) {
            $content_width = 1140;
        }
        load_theme_textdomain('cartsy', get_template_directory() . '/languages');
        add_theme_support('automatic-feed-links');
        add_theme_support('title-tag');
        add_theme_support('post-thumbnails');
        register_nav_menus(array(
            'cartsy-menu' => esc_html__('Cartsy Main Menu', 'cartsy'),
        ));
        add_theme_support('html5', array(
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
        ));
        add_theme_support('customize-selective-refresh-widgets');
        add_theme_support('custom-logo', array(
            'height' => 250,
            'width' => 250,
            'flex-width' => true,
            'flex-height' => true,
        ));
        add_theme_support('custom-background', apply_filters('cartsy_custom_background_args', array(
            'default-color' => 'ffffff',
            'default-image' => '',
        )));

        add_theme_support('align-wide');
        add_theme_support('editor-styles');
        add_theme_support('wp-block-styles');
        add_theme_support('responsive-embeds');
        add_theme_support(
            'post-formats',
            array(
                'aside',
                'image',
                'video',
                'quote',
                'link',
                'gallery',
                'status',
                'audio',
                'chat',
            )
        );

        // woocommerce
        add_theme_support('woocommerce');
        add_theme_support('wc-product-gallery-zoom');
        add_theme_support('wc-product-gallery-lightbox');
        add_theme_support('wc-product-gallery-slider');
    }

    public function log($log)
    {
        if (true === WP_DEBUG) {
            if (is_array($log) || is_object($log)) {
                error_log(print_r($log, true));
            } else {
                error_log($log);
            }
        }
    }
}
