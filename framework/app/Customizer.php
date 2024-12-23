<?php


namespace Framework\App;

use WP_Customize_Control;

// Do not allow directly accessing this file.
if (!defined('ABSPATH')) {
    exit('Direct script access denied.');
}

use WP_Customize_Image_Control;

class Customizer
{
    public function __construct()
    {
        add_action('customize_register', [$this, 'register']);
        add_action('customize_preview_init', [$this, 'previewJS']);
        // add_action('customize_register', [$this, 'cartsyTransparentLogo']);
    }

    public function cartsyTransparentLogo($wp_customize)
    {
        $wp_customize->add_setting(
            'cartsy_transparent_logo',
            array(
                'default' => '',
                'type' => 'theme_mod', // you can also use 'theme_mod'
                'capability' => 'edit_theme_options'
            ),
            array(
                'sanitize_callback' => '__return_true',
            )
        );

        $wp_customize->add_control(
            new WP_Customize_Image_Control(
                $wp_customize,
                'cartsy_transparent_logo',
                array(
                    'label'      => esc_html__('Transparent Header Logo', 'cartsy'),
                    'section'    => 'title_tagline',
                    'settings'   => 'cartsy_transparent_logo',
                    'context'    => 'cartsy_transparent_logo',
                    'priority'   => 9
                )
            )
        );
    }

    public function register($wp_customize)
    {
        $wp_customize->get_setting('blogname')->transport         = 'postMessage';
        $wp_customize->get_setting('blogdescription')->transport  = 'postMessage';
        $wp_customize->get_setting('header_textcolor')->transport = 'postMessage';
        if (isset($wp_customize->selective_refresh)) {
            $wp_customize->selective_refresh->add_partial('blogname', array(
                'selector'        => '.site-title a',
                'render_callback' => function () {
                    bloginfo('name');
                },
            ));
            $wp_customize->selective_refresh->add_partial('blogdescription', array(
                'selector'        => '.site-description',
                'render_callback' => function () {
                    bloginfo('description');
                },
            ));
        }
    }


    public function previewJS()
    {
        wp_enqueue_script('cartsy-customizer', get_template_directory_uri() . '/assets/js/customizer.js', array('customize-preview'), CARTSY_VERSION, true);
    }
}
