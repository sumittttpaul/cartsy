<?php


namespace Framework\App;

// Do not allow directly accessing this file.
if (!defined('ABSPATH')) {
    exit('Direct script access denied.');
}


class Jetpack
{
    public function __construct()
    {
        if (defined('JETPACK__VERSION')) {
            add_action('after_setup_theme', [$this, 'setup']);
        }
    }

    public function setup()
    {
        add_theme_support('infinite-scroll', array(
            'container' => 'main',
            'render'    => [$this, 'infiniteScroll'],
            'footer'    => 'page',
        ));

        // Add theme support for Responsive Videos.
        add_theme_support('jetpack-responsive-videos');

        // Add theme support for Content Options.
        add_theme_support('jetpack-content-options', array(
            'post-details'    => array(
                'stylesheet' => 'cartsy-style',
                'date'       => '.posted-on',
                'categories' => '.cat-links',
                'tags'       => '.tags-links',
                'author'     => '.byline',
                'comment'    => '.comments-link',
            ),
            'featured-images' => array(
                'archive'    => true,
                'post'       => true,
                'page'       => true,
            ),
        ));
    }


    /**
     * Custom render function for Infinite Scroll.
     */
    function infiniteScroll()
    {
        while (have_posts()) {
            the_post();
            if (is_search()) :
                get_template_part('template-parts/content', 'search');
            else :
                get_template_part('template-parts/content', get_post_type());
            endif;
        }
    }
}
