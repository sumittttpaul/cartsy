<?php

/**
 * Custom template categories for this theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Cartsy
 */

if (!function_exists('cartsy_post_category')) {

  /**
   * cartsy_post_category
   *
   * @return void
   */
  function cartsy_post_category()
  {
    $categories              = get_the_category();
    $categoriesLength        = count($categories);
    $remaincategoriesLength  = $categoriesLength - 2;
    $categories              = $categoriesLength >= 2 ? array_slice($categories, 0, 2) : $categories;
    $home_url                = home_url('/');
    $allowedHTML             = wp_kses_allowed_html('post');
    $html                    = '';

    if ($categoriesLength > 0) {
      $html .= '<span class="categories">';
      foreach ($categories as $category) {
        $html .= '<a class="category" href="' . $home_url . esc_html__('category', 'cartsy') . '/' . $category->slug . '">' . $category->name . '</a>';
      }
      if ($categoriesLength > 2) {
        $html .= '<a class="more" href="' . esc_url(get_permalink()) . '">' . $remaincategoriesLength . '+</a>';
      }
      $html .= '</span>';

      echo wp_kses($html, $allowedHTML);
    }
  }
}
