<?php

/**
 * CartsyBreadcrumb
 *
 * @param mixed $arrow_sign
 * @return void
 */

if (!function_exists('CartsyBreadcrumb')) {
    function CartsyBreadcrumb($arrow_sign = '&#x2192;')
    {
        /* === OPTIONS === */
        $text['home'] = esc_html__('Home', 'cartsy'); // text for the 'Home' link
        $text['category'] = esc_html__('Archive by Category "%s"', 'cartsy'); // text for a category page
        $text['tax'] = esc_html__('Archive for "%s"', 'cartsy'); // text for a taxonomy page
        $text['search'] = esc_html__('Search Results for "%s" Query', 'cartsy'); // text for a search results page
        $text['tag'] = esc_html__('Posts Tagged "%s"', 'cartsy'); // text for a tag page
        $text['author'] = esc_html__('Articles Posted by %s', 'cartsy'); // text for an author page
        $text['404'] = esc_html__('Error 404', 'cartsy'); // text for the 404 page

        $showCurrent = 1; // 1 - show current post/page title in breadcrumbs, 0 - don't show
        $showOnHome = 1; // 1 - show breadcrumbs on the homepage, 0 - don't show
        $delimiter = '&nbsp; / &nbsp;'; // delimiter between crumbs
        $before = '<span class="current">'; // tag before the current crumb
        $after = '</span>'; // tag after the current crumb
        /* === END OF OPTIONS === */

        global $post;
        $homeLink = home_url() . '/';
        $linkBefore = '<span typeof="v:Breadcrumb">';
        $linkAfter = '</span>';
        $linkAttr = ' rel="v:url" property="v:title"';
        $link = $linkBefore . '<a' . $linkAttr . ' href="%1$s">%2$s</a>' . $linkAfter;

        if (is_home() || is_front_page()) {

            if ($showOnHome == 1) echo '<div class="cartsy-breadcrumb"> <a href="' . $homeLink . '">' . $text['home'] . '</a></div>';
        } else {

            echo '<div class="cartsy-breadcrumb">' . sprintf($link, $homeLink, $text['home']) . $delimiter;


            if (is_category()) {
                $thisCat = get_category(get_query_var('cat'), false);
                if ($thisCat->parent != 0) {
                    $cats = get_category_parents($thisCat->parent, TRUE, $delimiter);
                    $cats = str_replace('<a', $linkBefore . '<a' . $linkAttr, $cats);
                    $cats = str_replace('</a>', '</a>' . $linkAfter, $cats);
                    echo esc_attr($cats);
                }
                echo sprintf($before . $text['category'], single_cat_title('', false) . $after);
            } elseif (is_tax()) {
                $thisCat = get_category(get_query_var('cat'), false);
                if ($thisCat->parent != 0) {
                    $cats = get_category_parents($thisCat->parent, TRUE, $delimiter);
                    $cats = str_replace('<a', $linkBefore . '<a' . $linkAttr, $cats);
                    $cats = str_replace('</a>', '</a>' . $linkAfter, $cats);
                    echo esc_attr($cats);
                }
                echo sprintf($before . $text['tax'], single_cat_title('', false) . $after);
            } elseif (is_search()) {
                echo sprintf($before . $text['search'], get_search_query() . $after);
            } elseif (is_day()) {
                echo sprintf($link, get_year_link(get_the_time('Y')), get_the_time('Y')) . $delimiter;
                echo sprintf($link, get_month_link(get_the_time('Y'), get_the_time('m')), get_the_time('F')) . $delimiter;
                echo sprintf($before . get_the_time('d') . $after);
            } elseif (is_month()) {
                echo sprintf($link, get_year_link(get_the_time('Y')), get_the_time('Y')) . $delimiter;
                echo sprintf($before . get_the_time('F') . $after);
            } elseif (is_year()) {
                echo sprintf($before . get_the_time('Y') . $after);
            } elseif (is_single() && !is_attachment()) {
                if (get_post_type() != 'post') {
                    if (get_post_type() == 'product') {
                        if (class_exists('WooCommerce')) {
                            printf($link, get_permalink(wc_get_page_id('shop')), 'products');
                            if ($showCurrent == 1) echo sprintf($delimiter . $before . get_the_title() . $after);
                        }
                    } else {
                        $post_type = get_post_type_object(get_post_type());
                        $slug = $post_type->rewrite;
                        printf($link, $homeLink . '/' . $slug['slug'] . '/', $post_type->labels->singular_name);
                        if ($showCurrent == 1) echo sprintf($delimiter . $before . get_the_title() . $after);
                    }
                } else {
                    $cat = get_the_category();
                    $cat = $cat[0];
                    $cats = get_category_parents($cat, TRUE, $delimiter);
                    if ($showCurrent == 0) $cats = preg_replace("#^(.+)$delimiter$#", "$1", $cats);
                    $cats = str_replace('<a', $linkBefore . '<a' . $linkAttr, $cats);
                    $cats = str_replace('</a>', '</a>' . $linkAfter, $cats);
                    echo sprintf($cats);
                    if ($showCurrent == 1) echo sprintf("%s %s %s", $before, get_the_title(), $after);
                }
            } elseif (!is_single() && !is_page() && get_post_type() != 'post' && !is_404()) {
                $post_type = get_post_type_object(get_post_type());

                if (isset($post_type) && !empty($post_type)) {
                    echo sprintf($before . $post_type->labels->singular_name . $after);
                }
            } elseif (is_attachment()) {
                $parent = get_post($post->post_parent);
                $cat = get_the_category($parent->ID);
                $cat = $cat[0];
                $cats = get_category_parents($cat, TRUE, $delimiter);
                $cats = str_replace('<a', $linkBefore . '<a' . $linkAttr, $cats);
                $cats = str_replace('</a>', '</a>' . $linkAfter, $cats);
                echo sprintf($cats);
                printf($link, get_permalink($parent), $parent->post_title);
                if ($showCurrent == 1) echo sprintf($delimiter . $before . get_the_title() . $after);
            } elseif (is_page() && !$post->post_parent) {
                if ($showCurrent == 1) echo sprintf($before . get_the_title() . $after);
            } elseif (is_page() && $post->post_parent) {
                $parent_id = $post->post_parent;
                $breadcrumbs = array();
                while ($parent_id) {
                    $page = get_post($parent_id);
                    $breadcrumbs[] = sprintf($link, get_permalink($page->ID), get_the_title($page->ID));
                    $parent_id = $page->post_parent;
                }
                $breadcrumbs = array_reverse($breadcrumbs);
                for ($i = 0; $i < count($breadcrumbs); $i++) {
                    echo sprintf($breadcrumbs[$i]);
                    if ($i != count($breadcrumbs) - 1) echo sprintf($delimiter);
                }
                if ($showCurrent == 1) echo sprintf($delimiter . $before . get_the_title() . $after);
            } elseif (is_tag()) {
                echo sprintf($before . $text['tag'], single_tag_title('', false) . $after);
            } elseif (is_author()) {
                global $author;
                $userdata = get_userdata($author);
                echo sprintf($before . $text['author'], $userdata->display_name . $after);
            } elseif (is_404()) {
                echo sprintf($before . $text['404'] . $after);
            }

            if (get_query_var('paged')) {
                if (is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author()) echo ' (';
                echo __('Page', 'cartsy') . ' ' . get_query_var('paged');
                if (is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author()) echo ')';
            }

            echo '</div>';
        }
    }
}
