<?php
$siteLogo = get_theme_mod('custom_logo');
$cartsy_description = get_bloginfo('description', 'display');
?>

<div class="site-branding">
    <?php if (!empty($siteLogo)) { ?>
        <div class="cartsy-header-logo-wrapper">
            <h2 class="site-title">
                <?php the_custom_logo(); ?>
            </h2>
        </div>
    <?php } else { ?>
        <div class="cartsy-header-logo-wrapper">
            <?php if (is_front_page() && is_home()) : ?>
                <h2 class="site-title"><a href="<?php echo esc_url(home_url('/')); ?>" rel="home"><?php bloginfo('name'); ?></a></h2>
            <?php else : ?>
                <h2 class="site-title"><a href="<?php echo esc_url(home_url('/')); ?>" rel="home"><?php bloginfo('name'); ?></a></h2>
            <?php endif; ?>

            <?php if ($cartsy_description || is_customize_preview()) : ?>
                <p class="site-description">
                    <?php echo esc_attr($cartsy_description); /* WPCS: xss ok. */ ?>
                </p>
            <?php endif; ?>
        </div>
    <?php } ?>
</div>