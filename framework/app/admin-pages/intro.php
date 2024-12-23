<?php
$cartsy_theme = wp_get_theme();
if ($cartsy_theme->parent_theme) {
    $cartsy_template_dir = basename(get_theme_file_path());
    $cartsy_theme        = wp_get_theme($cartsy_template_dir);
}
$CARTSY_VERSION            = wp_get_theme()->get('Version');
$cartsy_author            = wp_get_theme()->get('Author');
$cartsy_description        = wp_get_theme()->get('Description');

$allowed_tags = wp_kses_allowed_html('post');
$plugins = TGM_Plugin_Activation::$instance->plugins;
$structure = get_option('permalink_structure');
$cartsy_algolia_settings = get_option('cartsy_algolia_settings');
$googlemap_settings = get_option('googlemap_settings');

$permalinkState = false;
$permalinkStateText = '';

$algoliaState = false;
$algoliaSetupLink = '';
$algoliaStateText = '';

$googlemapState = false;
$googlemapSetupLink = '';
$googlemapStateText = '';

$licenseState = false;
$licenseStateText = '';
$themeActivated = false;

$cartsy_server_options = cartsy_b4_decode(get_option('cartsy_server_options'));
$themeActivated = true;


if ($themeActivated != '') {
    $licenseState = true;
    $licenseStateText = esc_html__('Activated', 'cartsy');
} else {
    $licenseState = false;
    $licenseStateText = esc_html__('Activate License', 'cartsy');
}


/**
 * Checking permalink
 */

if ($structure != '') {
    $permalinkState = true;
    $permalinkStateText = esc_html__('Done', 'cartsy');
} else {
    $permalinkState = false;
    $permalinkStateText = esc_html__('Configure from here', 'cartsy');
}

/**
 * Checking algolia
 */

if (class_exists('CartsyAlgolia')) {
    if (
        !empty($cartsy_algolia_settings)
        &&
        isset($cartsy_algolia_settings['la_application_id'])
        && $cartsy_algolia_settings['la_application_id'] != ''
        && $cartsy_algolia_settings['la_search_only_api_key'] != ''
        && $cartsy_algolia_settings['la_admin_api_key'] != ''
        && $cartsy_algolia_settings['la_index_name'] != ''
    ) {
        $algoliaState = true;
        $algoliaStateText = esc_html__('Done', 'cartsy');
        $algoliaSetupLink = admin_url('admin.php?page=cartsy');
    } else {
        $algoliaState = false;
        $algoliaSetupLink = admin_url('admin.php?page=cartsy-algolia-settings');
        $algoliaStateText = esc_html__('Setup from here', 'cartsy');
    }
} else {
    $algoliaState = false;
    $algoliaSetupLink = admin_url('admin.php?page=cartsy-plugins');
    $algoliaStateText = esc_html__('Install from here', 'cartsy');
}

/**
 * Checking google map
 */
if (class_exists('Load_Google_Map')) {
    if (isset($googlemap_settings['googlemap_api_key']) && $googlemap_settings['googlemap_api_key'] != '') {
        $googlemapState = true;
        $googlemapStateText = esc_html__('Done', 'cartsy');
        $googlemapSetupLink = admin_url('admin.php?page=cartsy');
    } else {
        $googlemapState = false;
        $googlemapSetupLink = admin_url('admin.php?page=load_google_map');
        $googlemapStateText = esc_html__('Setup from here', 'cartsy');
    }
} else {
    $googlemapState = false;
    $googlemapSetupLink = admin_url('admin.php?page=cartsy-plugins');
    $googlemapStateText = esc_html__('Install from here', 'cartsy');
}

$allRequiredPluginCheck = ThemeRelatedPluginCheck();
$allServerRequiermentCheck = ThemeServerRequirmentCheck();
?>

<!-- Basic structure set up start -->
<h3 class='cartsy-theme-setup-title'>
    <?php esc_html_e('Theme Setup Progress', 'cartsy') ?>
</h3>
<div class="cartsy-theme-setup-basic-wrapper">
    <div class="cartsy-theme-setup-basic-item">
        <div class="cartsy-theme-setup-basic-status-icon">
            <?php if ($allServerRequiermentCheck != false) { ?>
                <img src="<?php echo esc_url(CARTSY_IMAGE_PATH . '/plugin-active.svg') ?>" alt="<?php esc_attr_e('Success!', 'cartsy') ?>">
            <?php } else { ?>
                <img src="<?php echo esc_url(CARTSY_IMAGE_PATH . '/plugin-error.svg') ?>" alt="<?php esc_attr_e('Error!', 'cartsy') ?>">
            <?php } ?>
        </div>
        <div class="cartsy-theme-setup-basic-infos">
            <h4><?php echo esc_html__('Server Configuration', 'cartsy') ?></h4>
            <?php if ($allServerRequiermentCheck != false) { ?>
                <a href="<?php echo esc_url(admin_url('admin.php?page=cartsy')); ?>">
                    <?php echo esc_html__('Done', 'cartsy'); ?>
                </a>
            <?php } else { ?>
                <a href="<?php echo esc_url(admin_url('admin.php?page=cartsy-theme-setup-screen')); ?>">
                    <?php echo esc_html__('Check from here', 'cartsy'); ?>
                </a>
            <?php } ?>

        </div>
    </div>

    <div class="cartsy-theme-setup-basic-item" title='<?php esc_html_e('Note : Set Permalink any other type except "Plain", ', 'cartsy') ?>'>
        <div class="cartsy-theme-setup-basic-status-icon">
            <?php if ($permalinkState != false) { ?>
                <img src="<?php echo esc_url(CARTSY_IMAGE_PATH . '/plugin-active.svg') ?>" alt="<?php esc_attr_e('Success!', 'cartsy') ?>">
            <?php } else { ?>
                <img src="<?php echo esc_url(CARTSY_IMAGE_PATH . '/plugin-error.svg') ?>" alt="<?php esc_attr_e('Error!', 'cartsy') ?>">
            <?php } ?>
        </div>

        <div class="cartsy-theme-setup-basic-infos">
            <h4><?php echo esc_html__('Permalink Setup', 'cartsy') ?></h4>
            <a href="<?php echo esc_url(admin_url('options-permalink.php')); ?>">
                <?php echo wp_kses($permalinkStateText, $allowed_tags); ?>
            </a>
        </div>
    </div>

    <div class="cartsy-theme-setup-basic-item" title='<?php esc_html_e('Note : Please activate license to get up and running with cartsy automatic theme updates and more.', 'cartsy') ?>'>
        <div class="cartsy-theme-setup-basic-status-icon">
            <?php if ($licenseState != false) { ?>
                <img src="<?php echo esc_url(CARTSY_IMAGE_PATH . '/plugin-active.svg') ?>" alt="<?php esc_html_e('Success!', 'cartsy') ?>">
            <?php } else { ?>
                <img src="<?php echo esc_url(CARTSY_IMAGE_PATH . '/plugin-error.svg') ?>" alt="<?php esc_html_e('Error!', 'cartsy') ?>">
            <?php } ?>
        </div>

        <div class="cartsy-theme-setup-basic-infos">
            <h4><?php echo esc_html__('License Activation', 'cartsy') ?></h4>
            <?php if ($licenseState != false) { ?>
                <a href="<?php echo esc_url(admin_url('admin.php?page=cartsy-activate-license')); ?>">
                    <?php echo wp_kses($licenseStateText, $allowed_tags); ?>
                </a>
            <?php } else { ?>
                <a style="background-color: #f55e50;" href="<?php echo esc_url(admin_url('admin.php?page=cartsy-activate-license')); ?>">
                    <?php echo wp_kses($licenseStateText, $allowed_tags); ?>
                </a>
            <?php } ?>
        </div>
    </div>

    <div class="cartsy-theme-setup-basic-item">
        <div class="cartsy-theme-setup-basic-status-icon">
            <?php if ($allRequiredPluginCheck != false) { ?>
                <img src="<?php echo esc_url(CARTSY_IMAGE_PATH . '/plugin-active.svg') ?>" alt="<?php esc_attr_e('Success!', 'cartsy') ?>">
            <?php } else { ?>
                <img src="<?php echo esc_url(CARTSY_IMAGE_PATH . '/plugin-error.svg') ?>" alt="<?php esc_attr_e('Error!', 'cartsy') ?>">
            <?php } ?>
        </div>
        <div class="cartsy-theme-setup-basic-infos">
            <h4><?php echo esc_html__('All plugin Setup', 'cartsy') ?></h4>
            <?php if ($allRequiredPluginCheck != false) { ?>
                <a href="<?php echo esc_url(admin_url('admin.php?page=cartsy')); ?>">
                    <?php echo esc_html__('Done', 'cartsy'); ?>
                </a>
            <?php } else { ?>
                <a href="<?php echo esc_url(admin_url('admin.php?page=cartsy-plugins')); ?>">
                    <?php echo esc_html__('Install from here', 'cartsy'); ?>
                </a>
            <?php } ?>

        </div>
    </div>

    <div class="cartsy-theme-setup-basic-item">
        <div class="cartsy-theme-setup-basic-status-icon">
            <?php if ($googlemapState != false) { ?>
                <img src="<?php echo esc_url(CARTSY_IMAGE_PATH . '/plugin-active.svg') ?>" alt="<?php esc_attr_e('Success!', 'cartsy') ?>">
            <?php } else { ?>
                <img src="<?php echo esc_url(CARTSY_IMAGE_PATH . '/plugin-error.svg') ?>" alt="<?php esc_attr_e('Error!', 'cartsy') ?>">
            <?php } ?>
        </div>

        <div class="cartsy-theme-setup-basic-infos">
            <h4><?php echo esc_html__('Google Map Setup', 'cartsy') ?></h4>
            <a href="<?php echo esc_url($googlemapSetupLink); ?>">
                <?php echo wp_kses($googlemapStateText, $allowed_tags); ?>
            </a>
        </div>
    </div>

    <div class="cartsy-theme-setup-basic-item">
        <div class="cartsy-theme-setup-basic-status-icon">
            <?php if ($algoliaState != false) { ?>
                <img src="<?php echo esc_url(CARTSY_IMAGE_PATH . '/plugin-active.svg') ?>" alt="<?php esc_attr_e('Success!', 'cartsy') ?>">
            <?php } else { ?>
                <img src="<?php echo esc_url(CARTSY_IMAGE_PATH . '/plugin-error.svg') ?>" alt="<?php esc_attr_e('Error!', 'cartsy') ?>">
            <?php } ?>
        </div>

        <div class="cartsy-theme-setup-basic-infos">
            <h4><?php echo esc_html__('Algolia Setup', 'cartsy') ?></h4>
            <a href="<?php echo esc_url($algoliaSetupLink); ?>">
                <?php echo wp_kses($algoliaStateText, $allowed_tags); ?>
            </a>
        </div>
    </div>
</div>