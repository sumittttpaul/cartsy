<?php

/**
 * Cartsy hooks
 *
 * @package Cartsy
 */

/**
 * Global hooks
 *
 * @see  cartsy_loaded()
 */
add_action('wp_body_open', 'cartsy_loaded', 10);
add_filter('body_class', 'cartsy_body_classes');
add_action('wp_head', 'cartsy_pingback_header');
add_action('wp_footer', 'cartsy_popup_newsletter');
add_action('wp_footer', 'cartsy_popup_authentication');

/**
 * Header Layout (Default)
 *
 * @see  template-functions.php
 */
add_action('cartsy_header_default', 'cartsy_header_wrapper_start', 5);
add_action('cartsy_header_default', 'cartsy_header_menu', 10);
add_action('cartsy_header_default', 'cartsy_site_branding', 15);
add_action('cartsy_header_default', 'cartsy_header_search', 20);
add_action('cartsy_header_default', 'cartsy_header_lang', 21);
add_action('cartsy_header_default', 'cartsy_woo_link', 25);
add_action('cartsy_header_default', 'cartsy_header_wrapper_end', 30);

/**
 * After drawer menu
 *
 * @see  template-functions.php
 */
add_action('cartsy_after_drawer_menu', 'cartsy_drawer_menu_lang', 21);

/**
 * Before content
 *
 * @see  template-functions.php
 */
add_action('cartsy_before_content', 'cartsy_banner', 5);


/**
 * Footer Layout (Default)
 *
 * @see  template-functions.php
 */
add_action('cartsy_footer_default', 'cartsy_footer', 5);

/**
 * Copyright Layout (Default)
 *
 * @see  template-functions.php
 */
add_action('cartsy_copyright_default', 'cartsy_copyright', 5);
