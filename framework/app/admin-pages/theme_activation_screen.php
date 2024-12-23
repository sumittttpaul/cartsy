<?php
global $cartsyActivation;
$cartsy_theme = wp_get_theme();
if ($cartsy_theme->parent_theme) {
  $cartsy_template_dir = basename(get_theme_file_path());
  $cartsy_theme        = wp_get_theme($cartsy_template_dir);
}
$CARTSY_VERSION      = wp_get_theme()->get('Version');
$cartsy_author      = wp_get_theme()->get('Author');
$cartsy_description    = wp_get_theme()->get('Description');

$allowed_tags = wp_kses_allowed_html('post');
$plugins = TGM_Plugin_Activation::$instance->plugins;
$structure = get_option('permalink_structure');
$cartsy_algolia_settings = get_option('cartsy_algolia_settings');
$googlemap_settings = get_option('googlemap_settings');

$permalinkState = false;
$permalinkStateText = '';

$licenseState = false;
$licenseStateText = '';

$algoliaState = false;
$algoliaSetupLink = '';
$algoliaStateText = '';

$googlemapState = false;
$googlemapSetupLink = '';
$googlemapStateText = '';

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

$cartsy_server_options = cartsy_b4_decode(get_option('cartsy_server_options'));
$themeActivated = true;
$licenseState = true;
$licenseStateText = esc_html__('Activated', 'cartsy');


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

<div class="cartsy-theme-setup-main-wrapper">
  <div class="cartsy-theme-description cartsy-theme-setup-content-wrapper">

    <!-- DESCRIPTION -->
    <div class="cartsy-getting-started-description-wrapper">
      <h1 class="cartsy-theme-setup-content-title"><?php esc_html_e('License Activation', 'cartsy') ?></h1>
      <p class="description-text">
        <?php echo esc_html__('License Activation related description will be attached here', 'cartsy'); ?>
      </p>
    </div>

    <!-- Basic structure set up start -->
    <h3 class='cartsy-theme-setup-title'><?php esc_html_e('License Activation Progress', 'cartsy') ?></h3>
    <div class="cartsy-theme-setup-basic-wrapper">
      <div class="cartsy-theme-setup-basic-item">
        <div class="cartsy-theme-setup-basic-status-icon">
          <?php if ($allServerRequiermentCheck != false) { ?>
            <img src="<?php echo esc_url(CARTSY_IMAGE_PATH . '/plugin-active.svg') ?>" alt="<?php esc_html_e('Success!', 'cartsy') ?>">
          <?php } else { ?>
            <img src="<?php echo esc_url(CARTSY_IMAGE_PATH . '/plugin-error.svg') ?>" alt="<?php esc_html_e('Error!', 'cartsy') ?>">
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

      <div class="cartsy-theme-setup-basic-item" title='<?php esc_html_e('Note : Set Permalink any other type except "Plain", ', 'cartsy') ?>'>
        <div class="cartsy-theme-setup-basic-status-icon">
          <?php if ($permalinkState != false) { ?>
            <img src="<?php echo esc_url(CARTSY_IMAGE_PATH . '/plugin-active.svg') ?>" alt="<?php esc_html_e('Success!', 'cartsy') ?>">
          <?php } else { ?>
            <img src="<?php echo esc_url(CARTSY_IMAGE_PATH . '/plugin-error.svg') ?>" alt="<?php esc_html_e('Error!', 'cartsy') ?>">
          <?php } ?>
        </div>

        <div class="cartsy-theme-setup-basic-infos">
          <h4><?php echo esc_html__('Permalink Setup', 'cartsy') ?></h4>
          <a href="<?php echo esc_url(admin_url('options-permalink.php')); ?>">
            <?php echo wp_kses($permalinkStateText, $allowed_tags); ?>
          </a>
        </div>
      </div>

      <div class="cartsy-theme-setup-basic-item">
        <div class="cartsy-theme-setup-basic-status-icon">
          <?php if ($allRequiredPluginCheck != false) { ?>
            <img src="<?php echo esc_url(CARTSY_IMAGE_PATH . '/plugin-active.svg') ?>" alt="<?php esc_html_e('Success!', 'cartsy') ?>">
          <?php } else { ?>
            <img src="<?php echo esc_url(CARTSY_IMAGE_PATH . '/plugin-error.svg') ?>" alt="<?php esc_html_e('Error!', 'cartsy') ?>">
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
            <img src="<?php echo esc_url(CARTSY_IMAGE_PATH . '/plugin-active.svg') ?>" alt="<?php esc_html_e('Success!', 'cartsy') ?>">
          <?php } else { ?>
            <img src="<?php echo esc_url(CARTSY_IMAGE_PATH . '/plugin-error.svg') ?>" alt="<?php esc_html_e('Error!', 'cartsy') ?>">
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
            <img src="<?php echo esc_url(CARTSY_IMAGE_PATH . '/plugin-active.svg') ?>" alt="<?php esc_html_e('Success!', 'cartsy') ?>">
          <?php } else { ?>
            <img src="<?php echo esc_url(CARTSY_IMAGE_PATH . '/plugin-error.svg') ?>" alt="<?php esc_html_e('Error!', 'cartsy') ?>">
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

    <?php
    $OCDI_button_check = DemoImportingCheck();
    $OCDI_button_class = 'disabled';
    $OCDI_button_class = 'enable';
   
    ?>
    <div class="cartsy-theme-setup-activation-data" title='<?php echo esc_html__('Please activate theme license.', 'cartsy'); ?>'>
      <?php if (isset($cartsyActivation->errors['invalid']) && !empty($cartsyActivation->errors['invalid'])) : ?>
        <div class="notice notice-error is-dismissible">
          <p><?php echo $cartsyActivation->errors['invalid'][0] ?></p>
        </div>
      <?php endif; ?>
      <?php if (isset($cartsyActivation->errors['valid']) && !empty($cartsyActivation->errors['valid'])) : ?>
        <div class="notice notice-success is-dismissible">
          <p><?php echo $cartsyActivation->errors['valid'][0] ?></p>
        </div>
      <?php endif; ?>
      <?php if ($licenseState == false) { ?>
        <h3><?php echo esc_html__('Add Activation Key', 'cartsy'); ?></h3>
        <form method="post">
          <?php wp_nonce_field('activate_license', 'activate_license_key'); ?>
          <input placeholder="<?php esc_html_e('Theme license key.', 'cartsy'); ?>" class="license-key" type="text" name="license-key" required>
          <button>Activate</button>
        </form>
      <?php } ?>
    </div>
    <div class="cartsy-theme-setup-import-demo-data" title='<?php echo esc_html__('Please complete all the theme setup progress above.', 'cartsy'); ?>'>
      <a href="<?php echo esc_url(admin_url('admin.php?page=cartsy-demos')); ?>" class="<?php echo esc_attr($OCDI_button_class); ?>">
        <?php echo esc_html__('Import Demo Data', 'cartsy'); ?>
      </a>
    </div>
    <!-- Basic structure set up end -->
  </div>

  <!-- Pagintaion -->
  <div class="cartsy-theme-setup-pagination">
    <a href="<?php echo esc_url(admin_url('admin.php?page=cartsy-theme-setup-screen')); ?>" class='prev'>
      <span class="dashicons dashicons-arrow-left-alt"></span>
      <?php echo esc_html__('Previous Step', 'cartsy'); ?>
    </a>
    <a href="<?php echo esc_url(admin_url('admin.php?page=cartsy-plugins')); ?>" class='next'>
      <?php echo esc_html__('Next Step', 'cartsy'); ?>
      <span class="dashicons dashicons-arrow-right-alt"></span>
    </a>
  </div>
</div>