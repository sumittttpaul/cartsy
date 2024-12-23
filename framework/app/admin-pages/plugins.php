<?php
$cartsy_theme          = wp_get_theme();
if ($cartsy_theme->parent_theme) {
  $cartsy_template_dir = basename(get_theme_file_path());
  $cartsy_theme        = wp_get_theme($cartsy_template_dir);
}
$CARTSY_VERSION        = wp_get_theme()->get('Version');
$cartsy_author         =  wp_get_theme()->get('Author');
$plugins                = TGM_Plugin_Activation::$instance->plugins;
$cartsy_installed_plugins      = get_plugins();
foreach ($plugins as $key => $plugin) {
  if (class_exists($plugin['plugin_class_name'])) {
    $check_variable[] = 'yes';
  } else {
    $check_variable[] = 'no';
  }
}
$allowed_tags = wp_kses_allowed_html('post');
?>

<div class="cartsy-theme-setup-main-wrapper">
  <div class="cartsy-getting-started-content cartsy-theme-setup-content-wrapper">

    <!-- DESCRIPTION -->
    <div class="cartsy-getting-started-description-wrapper">
      <h1 class="cartsy-theme-setup-content-title"><?php echo esc_html__('Plugin installation', 'cartsy'); ?></h1>
      <p>
        <?php esc_html_e('This is a very important section. please install and activated all the necessary plugins for cartsy theme. Unless this beautiful theme will not work perfectly. After installed and activated all the plugins, please check all the plugins required setup. It is also very important too. Keep the Theme Setup Progress section green and move with your business. Thanks.', 'cartsy') ?>
      </p>
    </div>

    <?php require_once get_theme_file_path('/framework/app/admin-pages/intro.php'); ?>


    <div class="cartsy-plugins-bulk-list">
      <h3 class="cartsy-plugins-list-title"><?php esc_html_e('Bulk plugins list', 'cartsy') ?></h3>
      <?php if (in_array('no', $check_variable)) : ?>
        <p class="plugin-installation-notice">
          <?php esc_html_e('For Bulk Installations,', 'cartsy') ?>
          <a href="<?php echo esc_url(admin_url('themes.php?page=tgmpa-install-plugins')); ?>">
            <?php echo esc_html__("click here", 'cartsy'); ?>
          </a>
        </p>
      <?php endif ?>
    </div>


    <div class="cartsy-required-plugins-list">
      <h3><?php echo esc_html__('Required Plugins List', 'cartsy'); ?></h3>
      <div class="cartsy-plugins-activation-wrapper">
        <?php
        foreach ($plugins as $plugin) {
          $plugin_status = '';
          $file_path = $plugin['file_path'];
          $developed_by = $plugin['developed_by'];
          $required_true = $plugin['required'];
          $plugin_action = $this->cartsy_plugin_link($plugin);
        ?>
          <?php if (!empty($required_true) && $required_true === true) { ?>
            <div class="cartsy-necessary-plugins-column">

              <div class="cartsy-necessary-plugins">
                <div class="cartsy-plugins-image">
                  <?php if (isset($plugin['image_url']) && !empty($plugin['image_url'])) {  ?>
                    <img src="<?php echo esc_url($plugin['image_url']); ?>" alt="<?php echo esc_attr($plugin['name']); ?>">
                  <?php } ?>
                </div>
                <div class="cartsy-plugins-name-version">
                  <div class="cartsy-plugin-importance-tag-list">
                    <?php if (isset($plugin['required']) && $plugin['required'] && $plugin['required'] == true) : ?>
                      <span class="cartsy-plugin-importance-tag required">
                        <?php echo esc_html__('Required', 'cartsy'); ?>
                      </span>
                    <?php endif; ?>

                    <?php if (isset($plugin['recommended']) && $plugin['recommended'] && $plugin['recommended'] == true) : ?>
                      <span class="cartsy-plugin-importance-tag recommended">
                        <?php echo esc_html__('Recommended', 'cartsy'); ?>
                      </span>
                    <?php endif; ?>

                    <?php if (!empty($cartsy_installed_plugins[$plugin['file_path']]['Version']) &&  !empty($plugin['version'])) : ?>
                      <?php if (version_compare($cartsy_installed_plugins[$plugin['file_path']]['Version'], $plugin['version'], '<')) : ?>
                        <span class="cartsy-plugin-importance-tag update">
                          <?php echo esc_html__('Update Avaiable', 'cartsy'); ?>
                        </span>
                      <?php endif; ?>
                    <?php endif; ?>

                  </div>

                  <span class="plugin-name"><?php echo wp_kses($plugin['name'], $allowed_tags) ?></span>

                  <span class="plugin-install-btn">
                    <?php foreach ($plugin_action as $action) {
                      echo wp_kses($action, $allowed_tags);
                    }
                    ?>
                  </span>
                </div>
              </div>

            </div>
          <?php } ?>
        <?php } ?>
      </div>
    </div>


    <div class="cartsy-recommended-plugins-list">
      <h3><?php echo esc_html__('Recommended Plugins List', 'cartsy'); ?></h3>
      <div class="cartsy-plugins-activation-wrapper">
        <?php
        foreach ($plugins as $plugin) {
          $plugin_status = '';
          $file_path = $plugin['file_path'];
          $developed_by = $plugin['developed_by'];
          $required = $plugin['required'];
          $plugin_action = $this->cartsy_plugin_link($plugin);
        ?>
          <?php if ($required === false) { ?>
            <div class="cartsy-necessary-plugins-column">

              <div class="cartsy-necessary-plugins">
                <div class="cartsy-plugins-image">
                  <?php if (isset($plugin['image_url']) && !empty($plugin['image_url'])) {  ?>
                    <img src="<?php echo esc_url($plugin['image_url']); ?>" alt="<?php echo esc_attr($plugin['name']); ?>">
                  <?php } ?>
                </div>
                <div class="cartsy-plugins-name-version">
                  <div class="cartsy-plugin-importance-tag-list">
                    <?php if (isset($plugin['required']) && $plugin['required'] && $plugin['required'] == true) : ?>
                      <span class="cartsy-plugin-importance-tag required">
                        <?php echo esc_html__('Required', 'cartsy'); ?>
                      </span>
                    <?php endif; ?>

                    <?php if (isset($plugin['recommended']) && $plugin['recommended'] && $plugin['recommended'] == true) : ?>
                      <span class="cartsy-plugin-importance-tag recommended">
                        <?php echo esc_html__('Recommended', 'cartsy'); ?>
                      </span>
                    <?php endif; ?>

                    <?php if (!empty($cartsy_installed_plugins[$plugin['file_path']]['Version']) &&  !empty($plugin['version'])) : ?>
                      <?php if (version_compare($cartsy_installed_plugins[$plugin['file_path']]['Version'], $plugin['version'], '<')) : ?>
                        <span class="cartsy-plugin-importance-tag update">
                          <?php echo esc_html__('Update Avaiable', 'cartsy'); ?>
                        </span>
                      <?php endif; ?>
                    <?php endif; ?>
                  </div>

                  <span class="plugin-name"><?php echo wp_kses($plugin['name'], $allowed_tags) ?></span>

                  <span class="plugin-install-btn">
                    <?php foreach ($plugin_action as $action) {
                      echo wp_kses($action, $allowed_tags);
                    }
                    ?>
                  </span>
                </div>
              </div>

            </div>
          <?php } ?>
        <?php } ?>
      </div>
    </div>


  </div>
  <!-- Pagintaion -->
  <div class="cartsy-theme-setup-pagination">
    <a href="<?php echo esc_url(admin_url('admin.php?page=cartsy-plugins')); ?>" class='prev'>
      <span class="dashicons dashicons-arrow-left-alt"></span>
      <?php echo esc_html__('Previous Step', 'cartsy'); ?>
    </a>
    <a href="<?php echo esc_url(admin_url('admin.php?page=cartsy-miscellaneous')); ?>" class='next'>
      <?php echo esc_html__('Next Step', 'cartsy'); ?>
      <span class="dashicons dashicons-arrow-right-alt"></span>
    </a>
  </div>
</div>