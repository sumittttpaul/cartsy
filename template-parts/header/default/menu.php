<?php
$siteLogo = get_theme_mod('custom_logo');
$count_posts = wp_count_posts('page');
$callingMenuClass = 'Framework\\App\\CartsyCustomNavMenuWalker';
$mobileWalker = 'Framework\\App\\CartsyMobileNavWalker';
$callingPageNavClass = 'Framework\\App\\CartsyCutomPageWalker';
$cartsy_description = get_bloginfo('description', 'display');
?>

<nav id="site-navigation" class="navigation-drawer">
    <div class="cartsy-menu-toggler">
        <span></span>
        <span></span>
        <span></span>
    </div>
    <div class="cartsy-menu-drawer">
        <div class="cartsy-menu-drawer-header">

            <?php if (empty($siteLogo)) { ?>
                <h2 class="site-title">
                    <a class="cartsy-drawer-title" href="<?php echo esc_url(home_url('/')); ?>" rel="home">
                        <?php bloginfo('name'); ?>
                    </a>
                </h2>
            <?php } else { ?>
                <?php the_custom_logo(); ?>
            <?php } ?>

            <div class="cartsy-menu-drawer-close">
                <i class="ion ion-ios-close"></i>
            </div>
        </div>

        <?php
        if (has_nav_menu('cartsy-menu')) {
            wp_nav_menu(array(
                'container'       => 'div',
                'container_class' => 'cartsy-menu-wrapper',
                'theme_location'  => 'cartsy-menu',
                'menu_id'         => 'main-menu',
                'menu_class'      => 'cartsy-main-menu',
                'walker'          => new $callingMenuClass(),
                'fallback_cb'     => 'Framework\\App\\CartsyCustomNavMenuWalker::fallback',
            ));
        } else {
            if ($count_posts) {
                $published_posts = $count_posts->publish;
                if ($published_posts !== 0) {
                    wp_page_menu(
                        array(
                            'sort_column' => 'menu_order, post_title',
                            'before'      => '<ul id="mobile-menu" class="cartsy-main-menu">',
                            'menu_id'     => 'mobile-page-menu',
                            'menu_class'  => 'cartsy-menu-wrapper',
                            'after'       => '</ul>',
                            'walker'      => new $callingPageNavClass(),
                        )
                    );
                } else {
                    wp_nav_menu(array(
                        'container'       => 'div',
                        'container_class' => 'cartsy-mobile-menu-wrapper',
                        'theme_location'  => 'cartsy-menu',
                        'menu_id'         => 'mobile-menu',
                        'menu_class'      => 'cartsy-main-menu',
                        'walker'          => new $callingMenuClass(),
                        'fallback_cb'     => 'Framework\\App\\CartsyCustomNavMenuWalker::fallback',
                    ));
                }
            }
        }
        ?>

        <?php
        /**
         * Functions hooked into cartsy_after_drawer_menu action
         *
         * @see template-hooks.php file
         * @see template-function.php file
         */
        do_action('cartsy_after_drawer_menu');
        ?>

        <?php if (is_user_logged_in()) { ?>
            <div class="cartsy-menu-drawer-logout">
                <a href="<?php echo wp_logout_url(home_url()); ?>">
                    <?php echo esc_html__('Logout', 'cartsy'); ?>
                </a>
            </div>
        <?php } ?>
    </div>
    <!-- end mobile menu -->

    <div class="cartsy-drawer-overlay">
    </div>
</nav>