<?php

/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Cartsy
 */

// Redirecting to appropriate post format
get_template_part('template-parts/post/post', get_post_format());
