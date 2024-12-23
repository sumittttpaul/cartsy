<?php
global $wpdb, $wp_version;
$cartsy_theme = wp_get_theme();
if ($cartsy_theme->parent_theme) {
    $cartsy_template_dir = basename(get_theme_file_path());
    $cartsy_theme = wp_get_theme($cartsy_template_dir);
}
$CARTSY_VERSION = wp_get_theme()->get('Version');
$cartsy_author =  wp_get_theme()->get('Author');
$allowed_tags = wp_kses_allowed_html('post');
$plugins = TGM_Plugin_Activation::$instance->plugins;

$WP_VERSION = '5.0.0';
$WP_MEMORY_LIMIT = '256M';
$PHP_VERSION = '7.0.0';
$PHP_MAX_INPUT_VARIABLES = '3000';
$PHP_MAX_EXECUTION_TIME = '30';
$PHP_MAX_POST_SIZE = '8M';
$MAX_UPLOAD_SIZE = '16 MB';
$DB_SCHEMA = '';
$MYSQL_VERSION = '5.6';
$MARIA_DB_VERSION = '10.1';

$serverVersion = $wpdb->get_var('SELECT VERSION()');
if (strpos($serverVersion, 'MariaDB') !== false) {
    $DB_SCHEMA = 'mariaDB';
} else {
    $DB_SCHEMA = 'mysql';
}

?>
<div class="cartsy-theme-setup-main-wrapper">
    <div class="cartsy-getting-started-content cartsy-theme-setup-content-wrapper">

        <!-- DESCRIPTION -->
        <div class="cartsy-getting-started-description-wrapper">
            <h1 class="cartsy-theme-setup-content-title"><?php esc_html_e('Theme Requirment', 'cartsy') ?></h1>
            <p><?php esc_html_e('cartsy is now installed and ready to use! Get ready to build your listing business. Please register your purchase to get automatic theme updates, import cartsy demos and install premium plugins. Check out the Support tab to learn how to receive product support. We hope you enjoy it!', 'cartsy') ?></p>
        </div>

        <?php require_once get_theme_file_path('/framework/app/admin-pages/intro.php'); ?>

        <!-- server info section start -->
        <div class="cartsy-theme-plugins-status-wrapper">
            <h3><?php esc_html_e('Mandatory site configuration', 'cartsy') ?></h3>
            <div class="cartsy-theme-plugins-status-table">
                <div class="plugin-status-table-head">
                    <div class="plugin-status-table-column name-column">
                        <?php esc_html_e('Plugin name', 'cartsy'); ?>
                    </div>
                    <div class="plugin-status-table-column status-column">
                        <?php esc_html_e('Required status', 'cartsy'); ?>
                    </div>
                    <div class="plugin-status-table-column status-column">
                        <?php esc_html_e('Current status', 'cartsy'); ?>
                    </div>
                </div>
                <div class="plugin-status-table-body">

                    <div class="plugin-status-table-row">
                        <div class="plugin-status-table-column name-column">
                            <?php esc_html_e('WordPress version', 'cartsy'); ?>
                        </div>
                        <div class="plugin-status-table-column status-column">
                            <?php echo esc_attr($WP_VERSION); ?>
                        </div>
                        <div class="plugin-status-table-column status-column">
                            <?php if ($wp_version >= $WP_VERSION) : ?>
                                <span class="requirement-success">
                                    <?php echo esc_attr($wp_version); ?>
                                </span>
                            <?php else : ?>
                                <span class="requirement-error">
                                    <?php echo esc_attr($wp_version); ?>
                                </span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="plugin-status-table-row">
                        <div class="plugin-status-table-column name-column">
                            <?php esc_html_e('WordPress Memory Limit', 'cartsy'); ?>
                        </div>
                        <div class="plugin-status-table-column status-column">
                            <?php echo esc_attr($WP_MEMORY_LIMIT); ?>
                        </div>
                        <div class="plugin-status-table-column status-column">
                            <?php if ((int) filter_var(WP_MEMORY_LIMIT, FILTER_SANITIZE_NUMBER_INT) >= (int) filter_var($WP_MEMORY_LIMIT, FILTER_SANITIZE_NUMBER_INT)) : ?>
                                <span class="requirement-success">
                                    <?php echo esc_attr(WP_MEMORY_LIMIT); ?>
                                </span>
                            <?php else : ?>
                                <span class="requirement-error">
                                    <?php echo esc_attr(WP_MEMORY_LIMIT); ?>
                                </span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="plugin-status-table-row">
                        <div class="plugin-status-table-column name-column">
                            <?php esc_html_e('PHP version', 'cartsy'); ?>
                        </div>
                        <div class="plugin-status-table-column status-column">
                            <?php
                            esc_html_e('>= ', 'cartsy');
                            echo esc_attr($PHP_VERSION);
                            ?>
                        </div>
                        <div class="plugin-status-table-column status-column">
                            <?php if (phpversion() >= $PHP_VERSION) : ?>
                                <span class="requirement-success">
                                    <?php echo phpversion(); ?>
                                </span>
                            <?php else : ?>
                                <span class="requirement-error">
                                    <?php echo phpversion(); ?>
                                </span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="plugin-status-table-row">
                        <div class="plugin-status-table-column name-column">
                            <?php esc_html_e('PHP max input variables', 'cartsy'); ?>
                        </div>
                        <div class="plugin-status-table-column status-column">
                            <?php echo esc_attr($PHP_MAX_INPUT_VARIABLES); ?>
                        </div>
                        <div class="plugin-status-table-column status-column">
                            <?php if (ini_get('max_input_vars') >= $PHP_MAX_INPUT_VARIABLES) : ?>
                                <span class="requirement-success">
                                    <?php echo esc_attr(ini_get('max_input_vars')); ?>
                                </span>
                            <?php else : ?>
                                <span class="requirement-error">
                                    <?php echo esc_attr(ini_get('max_input_vars')); ?>
                                </span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="plugin-status-table-row">
                        <div class="plugin-status-table-column name-column">
                            <?php esc_html_e('PHP maximum execution time', 'cartsy'); ?>
                        </div>
                        <div class="plugin-status-table-column status-column">
                            <?php echo esc_attr($PHP_MAX_EXECUTION_TIME); ?>
                        </div>
                        <div class="plugin-status-table-column status-column">
                            <?php if (ini_get('max_execution_time') >= $PHP_MAX_EXECUTION_TIME) : ?>
                                <span class="requirement-success">
                                    <?php echo esc_attr(ini_get('max_execution_time')); ?>
                                </span>
                            <?php else : ?>
                                <span class="requirement-error">
                                    <?php echo esc_attr(ini_get('max_execution_time')); ?>
                                </span>
                            <?php endif; ?>
                        </div>
                    </div>


                    <div class="plugin-status-table-row">
                        <div class="plugin-status-table-column name-column">
                            <?php esc_html_e('PHP post maximum size', 'cartsy'); ?>
                        </div>
                        <div class="plugin-status-table-column status-column">
                            <?php echo esc_attr($PHP_MAX_POST_SIZE); ?>
                        </div>
                        <div class="plugin-status-table-column status-column">
                            <?php if (ini_get('post_max_size') >= (int) filter_var($PHP_MAX_POST_SIZE, FILTER_SANITIZE_NUMBER_INT)) : ?>
                                <span class="requirement-success">
                                    <?php echo esc_attr(ini_get('post_max_size')); ?>
                                </span>
                            <?php else : ?>
                                <span class="requirement-error">
                                    <?php echo esc_attr(ini_get('post_max_size')); ?>
                                </span>
                            <?php endif; ?>

                        </div>
                    </div>


                    <div class="plugin-status-table-row">
                        <div class="plugin-status-table-column name-column">
                            <?php esc_html_e('Maximum Upload Size', 'cartsy'); ?>
                        </div>
                        <div class="plugin-status-table-column status-column">
                            <?php echo esc_attr($MAX_UPLOAD_SIZE); ?>
                        </div>
                        <div class="plugin-status-table-column status-column">
                            <?php if ((int) filter_var(size_format(wp_max_upload_size()), FILTER_SANITIZE_NUMBER_INT) >= (int) filter_var($MAX_UPLOAD_SIZE, FILTER_SANITIZE_NUMBER_INT)) : ?>
                                <span class="requirement-success">
                                    <?php echo esc_attr(size_format(wp_max_upload_size())); ?>
                                </span>
                            <?php else : ?>
                                <span class="requirement-error">
                                    <?php echo esc_attr(size_format(wp_max_upload_size())); ?>
                                </span>
                            <?php endif; ?>
                        </div>
                    </div>


                    <?php if ($DB_SCHEMA === 'mysql') { ?>
                        <div class="plugin-status-table-row">
                            <div class="plugin-status-table-column name-column">
                                <?php esc_html_e('MySQL version', 'cartsy'); ?>
                            </div>
                            <div class="plugin-status-table-column status-column">
                                <?php
                                esc_html_e('>= ', 'cartsy');
                                echo esc_attr($MYSQL_VERSION);
                                ?>
                            </div>
                            <div class="plugin-status-table-column status-column">
                                <?php if ($wpdb->db_version() >= $MYSQL_VERSION) : ?>
                                    <span class="requirement-success">
                                        <?php echo esc_attr($wpdb->db_version()); ?>
                                    </span>
                                <?php else : ?>
                                    <span class="requirement-error">
                                        <?php echo esc_attr($wpdb->db_version()); ?>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php } else { ?>
                        <div class="plugin-status-table-row">
                            <div class="plugin-status-table-column name-column">
                                <?php esc_html_e('MariaDB version', 'cartsy'); ?>
                            </div>
                            <div class="plugin-status-table-column status-column">
                                <?php
                                esc_html_e('>= ', 'cartsy');
                                echo esc_attr($MARIA_DB_VERSION);
                                ?>
                            </div>
                            <div class="plugin-status-table-column status-column">
                                <?php if ($wpdb->db_version() >= $MARIA_DB_VERSION) : ?>
                                    <span class="requirement-success">
                                        <?php echo esc_attr($wpdb->db_version()); ?>
                                    </span>
                                <?php else : ?>
                                    <span class="requirement-error">
                                        <?php echo esc_attr($wpdb->db_version()); ?>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php } ?>


                </div>
            </div>
        </div>
        <!-- server info section end -->


        <!-- plugin info section start -->
        <div class="cartsy-theme-plugins-status-wrapper">
            <h3><?php esc_html_e('Mandatory Plugin Setup', 'cartsy') ?></h3>

            <div class="cartsy-theme-plugins-status-table">
                <div class="plugin-status-table-head">
                    <div class="plugin-status-table-column name-column"><?php esc_html_e('Plugin name', 'cartsy'); ?></div>
                    <div class="plugin-status-table-column status-column"><?php esc_html_e('Plugin status', 'cartsy'); ?></div>
                </div>
                <div class="plugin-status-table-body">
                    <?php
                    foreach ($plugins as $key => $plugin) {
                        $plugin_action = $this->cartsy_plugin_link($plugin);
                        $plugin_status = array_keys($plugin_action)[0];
                        if (class_exists($plugin['plugin_class_name'])) {
                            $check_variable[] = 'yes';
                        } else {
                            $check_variable[] = 'no';
                        }
                    ?>
                        <div class="plugin-status-table-row">
                            <div class="plugin-status-table-column name-column">
                                <?php echo wp_kses($plugin['name'], $allowed_tags) ?>
                            </div>
                            <div class="plugin-status-table-column status-column">
                                <?php if ($plugin_status === 'install') { ?>
                                    <img src="<?php echo esc_url(CARTSY_IMAGE_PATH . '/plugin-error.svg') ?>" alt="<?php echo wp_kses($plugin['name'], $allowed_tags) ?>">
                                <?php } elseif ($plugin_status === 'deactivate') { ?>
                                    <img src="<?php echo esc_url(CARTSY_IMAGE_PATH . '/plugin-active.svg') ?>" alt="<?php echo wp_kses($plugin['name'], $allowed_tags) ?>">
                                <?php } elseif ($plugin_status === 'update') { ?>
                                    <img src="<?php echo esc_url(CARTSY_IMAGE_PATH . '/plugin-alert.svg') ?>" alt="<?php echo wp_kses($plugin['name'], $allowed_tags) ?>">
                                <?php } else { ?>
                                    <img src="<?php echo esc_url(CARTSY_IMAGE_PATH . '/plugin-alert.svg') ?>" alt="<?php echo wp_kses($plugin['name'], $allowed_tags) ?>">
                                <?php } ?>

                            </div>
                        </div>
                    <?php } ?>
                </div>
                <div class="plugin-status-table-footer">
                    <div class="plugin-status-table-row">
                        <div class="plugin-status-table-column name-column"><?php esc_html_e('For complete your theme plugin setup', 'cartsy') ?></div>
                        <div class="plugin-status-table-column status-column">
                            <a href="<?php echo esc_url(admin_url('admin.php?page=cartsy-plugins')); ?>"><?php esc_html_e('Click Here', 'cartsy') ?></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- plugin info section end -->
    </div>
    <!-- Pagintaion -->
    <div class="cartsy-theme-setup-pagination">
        <a href="<?php echo esc_url(admin_url('admin.php?page=cartsy')); ?>" class='prev'>
            <span class="dashicons dashicons-arrow-left-alt"></span>
            <?php echo esc_html__('Previous Step', 'cartsy'); ?>
        </a>
        <a href="<?php echo esc_url(admin_url('admin.php?page=cartsy-activate-license')); ?>" class='next'>
            <?php echo esc_html__('Next Step', 'cartsy'); ?>
            <span class="dashicons dashicons-arrow-right-alt"></span>
        </a>
    </div>
</div>