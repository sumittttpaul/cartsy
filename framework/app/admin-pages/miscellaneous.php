<?php
$cartsy_theme          = wp_get_theme();
if ($cartsy_theme->parent_theme) {
    $cartsy_template_dir = basename(get_theme_file_path());
    $cartsy_theme        = wp_get_theme($cartsy_template_dir);
}
$CARTSY_VERSION        = wp_get_theme()->get('Version');
$cartsy_author         =  wp_get_theme()->get('Author');

$allowed_tags = wp_kses_allowed_html('post');
$plugins = TGM_Plugin_Activation::$instance->plugins;
?>

<div class="cartsy-theme-setup-main-wrapper">
    <div class="cartsy-theme-description cartsy-theme-setup-content-wrapper">
        <!-- DESCRIPTION -->
        <div class="cartsy-getting-started-description-wrapper">
            <h1><?php esc_html_e('Miscellaneous', 'cartsy') ?></h1>
            <p>
                <?php esc_html_e('This section mainly provided with most commonly asked questions and their answers. Please read this area carefully. You may have find the openning clue of your queries from here!', 'cartsy') ?>
            </p>
        </div>

        <?php require_once get_theme_file_path('/framework/app/admin-pages/intro.php'); ?>

        <!-- faq wrapper -->
        <div class="cartsy-getting-started-faq-section">
            <h3><?php echo esc_html__('F.A.Q', 'cartsy'); ?></h3>

            <div class="cartsy-getting-started-faq-wrapper">
                <div id="cartsy_getting_started_faq">
                    <!-- Accordion Item -->
                    <h3 class="cartsy-getting-started-faq-header">
                        <span class="faq-header-icon-expand">
                            <img src="<?php echo esc_url(CARTSY_IMAGE_PATH . '/accordion-expand.svg') ?>" alt="<?php esc_attr_e('Expand', 'cartsy') ?>">
                        </span>
                        <span class="faq-header-icon-collapse">
                            <img src="<?php echo esc_url(CARTSY_IMAGE_PATH . '/accordion-collapse.svg') ?>" alt="<?php esc_attr_e('Collapse', 'cartsy') ?>">
                        </span>
                        <?php esc_html_e('How can I update the theme to a newer version?', 'cartsy') ?>
                    </h3>
                    <div class="cartsy-getting-started-faq-content">
                        <p><?php esc_html_e('To update the theme with a newer version, please download the theme from your themeforest profile. Then goto "WP_Admin > Appearance > Theme" section and deactive the current cartsy theme with any other theme. Then remove the old cartsy theme and re-install the theme you have downloaded from your ThemeForest profile.', 'cartsy') ?></p>
                    </div>

                    <!-- Accordion Item -->
                    <h3 class="cartsy-getting-started-faq-header">
                        <span class="faq-header-icon-expand">
                            <img src="<?php echo esc_url(CARTSY_IMAGE_PATH . '/accordion-expand.svg') ?>" alt="<?php esc_attr_e('Expand', 'cartsy') ?>">
                        </span>
                        <span class="faq-header-icon-collapse">
                            <img src="<?php echo esc_url(CARTSY_IMAGE_PATH . '/accordion-collapse.svg') ?>" alt="<?php esc_attr_e('Collapse', 'cartsy') ?>">
                        </span>
                        <?php esc_html_e('How can I import demo data after theme installation?', 'cartsy') ?>
                    </h3>
                    <div class="cartsy-getting-started-faq-content">
                        <p><?php esc_html_e('After installation the theme, please install all the required plugins first. After the installation and activation, setup all the necessary API keys, data in the recommeced plugins. For more help, when the all the theme installation progress done GREEN, then you can import demo content from the demo installation window.', 'cartsy') ?></p>
                    </div>

                    <!-- Accordion Item -->
                    <h3 class="cartsy-getting-started-faq-header">
                        <span class="faq-header-icon-expand">
                            <img src="<?php echo esc_url(CARTSY_IMAGE_PATH . '/accordion-expand.svg') ?>" alt="<?php esc_attr_e('Expand', 'cartsy') ?>">
                        </span>
                        <span class="faq-header-icon-collapse">
                            <img src="<?php echo esc_url(CARTSY_IMAGE_PATH . '/accordion-collapse.svg') ?>" alt="<?php esc_attr_e('Collapse', 'cartsy') ?>">
                        </span>
                        <?php esc_html_e('How can I make any custom changes any the theme?', 'cartsy') ?>
                    </h3>
                    <div class="cartsy-getting-started-faq-content">
                        <p><?php esc_html_e('It is always preferable not to do any custom changes inside the theme directly. It is always wise to work on the child theme of the current installed theme.', 'cartsy') ?></p>
                    </div>

                    <!-- Accordion Item -->
                    <h3 class="cartsy-getting-started-faq-header">
                        <span class="faq-header-icon-expand">
                            <img src="<?php echo esc_url(CARTSY_IMAGE_PATH . '/accordion-expand.svg') ?>" alt="<?php esc_attr_e('Expand', 'cartsy') ?>">
                        </span>
                        <span class="faq-header-icon-collapse">
                            <img src="<?php echo esc_url(CARTSY_IMAGE_PATH . '/accordion-collapse.svg') ?>" alt="<?php esc_attr_e('Collapse', 'cartsy') ?>">
                        </span>
                        <?php esc_html_e('Do I need to use Gutenberg plugin or the default Gutenberg facilities provided by the WordPress is enough?', 'cartsy') ?>
                    </h3>
                    <div class="cartsy-getting-started-faq-content">
                        <p><?php esc_html_e('There is no conflict whether to use default Gutenberg facilities or the Gutenberg plugin.', 'cartsy') ?></p>
                    </div>
                </div>
            </div>
        </div>
        <!-- /faq wrapper -->
    </div>
    <!-- Pagintaion -->
    <div class="cartsy-theme-setup-pagination">
        <a href="<?php echo esc_url(admin_url('admin.php?page=cartsy-plugins')); ?>" class='prev'>
            <span class="dashicons dashicons-arrow-left-alt"></span>
            <?php echo esc_html__('Previous Step', 'cartsy'); ?>
        </a>
        <a href="#" class='next disabled'>
            <?php echo esc_html__('Next Step', 'cartsy'); ?>
            <span class="dashicons dashicons-arrow-right-alt"></span>
        </a>
    </div>
</div>