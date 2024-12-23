<?php

namespace Framework\App;


// Do not allow directly accessing this file.
if (!defined('ABSPATH')) {
  exit('Direct script access denied.');
}

class Sidebar
{
  /**
   * __construct
   *
   * @return void
   */
  public function __construct()
  {
    add_action('widgets_init', [$this, 'generate']);
  }

  /**
   * generate
   *
   * @return void
   */
  public function generate()
  {
    register_sidebar(array(
      'name'          => esc_html__('Cartsy Sidebar', 'cartsy'),
      'id'            => 'cartsy-sidebar',
      'description'   => esc_html__('Add sidebar widgets here.', 'cartsy'),
      'before_widget' => '<section id="%1$s" class="widget %2$s">',
      'after_widget'  => '</section>',
      'before_title'  => '<h2 class="widget-title">',
      'after_title'   => '</h2>',
    ));
    register_sidebar(array(
      'name'          => esc_html__('Cartsy Woo Sidebar', 'cartsy'),
      'id'            => 'cartsy-woo-sidebar',
      'description'   => esc_html__('Add sidebar widgets to WooCommerce archives.', 'cartsy'),
      'before_widget' => '<section id="%1$s" class="widget %2$s">',
      'after_widget'  => '</section>',
      'before_title'  => '<h2 class="widget-title">',
      'after_title'   => '</h2>',
    ));
  }
}
