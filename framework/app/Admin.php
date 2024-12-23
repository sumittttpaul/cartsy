<?php

namespace Framework\App;

use TGM_Plugin_Activation;
// Do not allow directly accessing this file.
if (!defined('ABSPATH')) {
	exit('Direct script access denied.');
}

class Admin
{
	/**
	 * Normalized path to includes folder.
	 *
	 * @since 5.1.0
	 *
	 * @access private
	 * @var string
	 */
	private $includes_path = '';

	/**
	 * Construct the admin object.
	 *
	 * @since 1.0.0
	 */
	public function __construct()
	{
		$this->includes_path = wp_normalize_path(dirname(__FILE__));
		add_action('admin_init', [$this, 'cartsyPluginSetupAction']);
		add_action('admin_menu', [$this, 'admin_menu']);
		add_action('after_switch_theme', [$this, 'activation_redirect']);
	}

	/**
	 * Redirect to admin page on theme activation.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return void
	 */
	public function activation_redirect()
	{
		if (current_user_can('switch_themes')) {
			header('Location:' . admin_url() . 'admin.php?page=cartsy');
		}
	}

	/**
	 * Adds the admin menu.
	 *
	 * @access  public
	 * @return void
	 */
	public function admin_menu()
	{
		if (current_user_can('switch_themes')) {

			$plugins_callback = [$this, 'plugins_tab'];

			if (isset($_GET['tgmpa-install']) || isset($_GET['tgmpa-update'])) { // phpcs:ignore WordPress.Security
				require_once $this->includes_path . '/../helpers/class-tgm-plugin-activation.php';
				remove_action('admin_notices', [$GLOBALS['tgmpa'], 'notices']);
				$plugins_callback = [$GLOBALS['tgmpa'], 'install_plugins_page'];
			}

			// Work around for theme check.
			$cartsy_menu_page_creation_method    = 'add_menu_page';
			$cartsy_submenu_page_creation_method = 'add_submenu_page';

			$welcome_screen = $cartsy_menu_page_creation_method(
				'Cartsy',
				'Cartsy',
				'switch_themes',
				'cartsy',
				[$this, 'welcome_screen'],
				'dashicons-admin-site-alt3'
			);

			$theme_setup_screen = $cartsy_submenu_page_creation_method(
				'cartsy',
				esc_html__('Theme Requirements', 'cartsy'),
				esc_html__('Theme Requirements', 'cartsy'),
				'switch_themes',
				'cartsy-theme-setup-screen',
				[$this, 'theme_setup_screen']
			);

			$theme_activation_screen = $cartsy_submenu_page_creation_method(
				'cartsy',
				esc_html__('License Activation', 'cartsy'),
				esc_html__('License Activation', 'cartsy'),
				'switch_themes',
				'cartsy-activate-license',
				[$this, 'theme_activation_screen']
			);

			if (class_exists('OCDI_Plugin')) {
				$demoImporterCheck = DemoImportingCheck();
				if ($demoImporterCheck != false) {
					$demos = $cartsy_submenu_page_creation_method(
						'cartsy',
						esc_html__('Demos', 'cartsy'),
						esc_html__('Demos', 'cartsy'),
						'manage_options',
						'cartsy-demos',
						[$this, null]
					);
				}
			}

			$plugins = $cartsy_submenu_page_creation_method(
				'cartsy',
				esc_html__('Plugins', 'cartsy'),
				esc_html__('Plugins', 'cartsy'),
				'install_plugins',
				'cartsy-plugins',
				$plugins_callback
			);

			$miscellaneous = $cartsy_submenu_page_creation_method(
				'cartsy',
				esc_html__('FAQs', 'cartsy'),
				esc_html__('FAQs', 'cartsy'),
				'switch_themes',
				'cartsy-miscellaneous',
				[$this, 'miscellaneous_tab']
			);
		}
	}

	/**
	 * Include file.
	 *
	 * @access  public
	 * @return void
	 */
	public function welcome_screen()
	{
		require_once $this->includes_path . '/admin-pages/welcome.php';
	}

	/**
	 * Include file.
	 *
	 * @access  public
	 * @return void
	 */
	public function theme_setup_screen()
	{
		require_once $this->includes_path . '/admin-pages/theme_setup_screen.php';
	}

	/**
	 * Include file.
	 *
	 * @access  public
	 * @return void
	 */
	public function theme_activation_screen()
	{
		require_once $this->includes_path . '/admin-pages/theme_activation_screen.php';
	}

	/**
	 * Include file.
	 *
	 * @access  public
	 * @return void
	 */
	public function miscellaneous_tab()
	{
		require_once $this->includes_path . '/admin-pages/miscellaneous.php';
	}

	/**
	 * Include file.
	 *
	 * @access  public
	 * @return void
	 */
	public function plugins_tab()
	{
		require_once $this->includes_path . '/admin-pages/plugins.php';
	}

	/**
	 * cartsy_plugin_link
	 *
	 * @param  mixed $item
	 * @return void
	 */
	public function cartsy_plugin_link($item)
	{

		$cartsy_installed_plugins = get_plugins();
		$item['sanitized_plugin'] = $item['name'];
		$plugin_base_class =  $item['plugin_class_name'];
		$cartsy_plugin_actions = array();
		if (!$item['version']) {
			$item['version'] = TGM_Plugin_Activation::$instance->does_plugin_have_update($item['slug']);
		}


		if (!isset($cartsy_installed_plugins[$item['file_path']])) {
			$cartsy_plugin_actions = array(
				'install' => sprintf(
					'<a href="%1$s" class="cartsy-plugin-activation-link install-color">' . esc_html__("Install", "cartsy") . '</a>',
					esc_url(wp_nonce_url(
						add_query_arg(
							array(
								'page'          => urlencode(TGM_Plugin_Activation::$instance->menu),
								'plugin'        => urlencode($item['slug']),
								'plugin_name'   => urlencode($item['sanitized_plugin']),
								'plugin_source' => urlencode($item['source']),
								'tgmpa-install' => 'install-plugin',
							),
							TGM_Plugin_Activation::$instance->get_tgmpa_url()
						),
						'tgmpa-install',
						'tgmpa-nonce'
					)),
					$item['sanitized_plugin']
				),
			);
		} elseif (is_plugin_inactive($item['file_path'])) {
			$cartsy_plugin_actions = array(
				'activate' => sprintf(
					'<a href="%1$s" class="cartsy-plugin-activation-link activate-needed">' . esc_html__("Activate", "cartsy") . '</a>',
					esc_url(add_query_arg(
						array(
							'plugin'               => urlencode($item['slug']),
							'plugin_name'          => urlencode($item['sanitized_plugin']),
							'plugin_source'        => urlencode($item['source']),
							'cartsy-activate'       => 'activate-plugin',
							'cartsy-activate-nonce' => wp_create_nonce('cartsy-activate'),
						),
						esc_url(admin_url('admin.php?page=cartsy-plugins'))
					)),
					$item['sanitized_plugin']
				),
			);
		} elseif (version_compare($cartsy_installed_plugins[$item['file_path']]['Version'], $item['version'], '<')) {
			$cartsy_plugin_actions = array(
				'update' => sprintf(
					'<a href="%1$s" class="cartsy-plugin-activation-link update-needed">' . esc_html__("Update", "cartsy") . '</a>',
					wp_nonce_url(
						add_query_arg(
							array(
								'page'          => urlencode(TGM_Plugin_Activation::$instance->menu),
								'plugin'        => urlencode($item['slug']),
								'tgmpa-update'  => 'update-plugin',
								'plugin_source' => urlencode($item['source']),
								'version'       => urlencode($item['version']),
							),
							TGM_Plugin_Activation::$instance->get_tgmpa_url()
						),
						'tgmpa-update',
						'tgmpa-nonce'
					),
					$item['sanitized_plugin']
				),
			);
		} elseif (class_exists($plugin_base_class)) {
			$cartsy_plugin_actions = array(
				'deactivate' => sprintf(
					'<a href="%1$s" class="cartsy-plugin-activation-link deactive">' . esc_html__("Deactivate", "cartsy") . '</a>',
					esc_url(add_query_arg(
						array(
							'plugin'                 => urlencode($item['slug']),
							'plugin_name'            => urlencode($item['sanitized_plugin']),
							'plugin_source'          => urlencode($item['source']),
							'cartsy-deactivate'       => 'deactivate-plugin',
							'cartsy-deactivate-nonce' => wp_create_nonce('cartsy-deactivate'),
						),
						esc_url(admin_url('admin.php?page=cartsy-plugins'))
					)),
					$item['sanitized_plugin']
				),
			);
		}
		return $cartsy_plugin_actions;
	}

	public function cartsyPluginSetupAction()
	{
		if (current_user_can('edit_theme_options')) {
			if (isset($_GET['cartsy-deactivate']) && 'deactivate-plugin' == $_GET['cartsy-deactivate']) {
				check_admin_referer('cartsy-deactivate', 'cartsy-deactivate-nonce');
				$plugins = TGM_Plugin_Activation::$instance->plugins;
				foreach ($plugins as $plugin) {
					if ($plugin['slug'] == $_GET['plugin']) {
						deactivate_plugins($plugin['file_path']);
					}
				}
			}
			if (isset($_GET['cartsy-activate']) && 'activate-plugin' == $_GET['cartsy-activate']) {
				check_admin_referer('cartsy-activate', 'cartsy-activate-nonce');
				$plugins = TGM_Plugin_Activation::$instance->plugins;
				foreach ($plugins as $plugin) {
					if (isset($_GET['plugin']) && $plugin['slug'] == $_GET['plugin']) {
						activate_plugin($plugin['file_path']);
						wp_redirect(esc_url(admin_url('admin.php?page=cartsy-plugins')));
						exit;
					}
				}
			}
		}
	}
}
