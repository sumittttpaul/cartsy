<?php

/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Cartsy
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1 maximum-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <?php wp_head(); ?>
</head>


<body <?php body_class(); ?>>

    <?php
    if (function_exists('wp_body_open')) {
        wp_body_open();
    }
    ?>

    <a class="skip-link screen-reader-text" href="#content"><?php esc_html_e('Skip to content', 'cartsy'); ?></a>

    <header id="masthead" class="site-header">

        <?php
        /**
         * Functions hooked into cartsy_header action
         *
         * @see template-hooks.php file
         * @see template-function.php file
         */
        do_action('cartsy_header_' . cartsy_get_header_layout());
        ?>

    </header>

    <?php
    /**
     * Functions hooked into cartsy_before_content action
     *
     * @function cartsy_banner() - 5
     */
    do_action('cartsy_before_content');
    ?>

    <div id="page" class="site">
        <div id="content" class="site-content">