<?php
ob_start();


if (!function_exists('cartsy_b4_encode')) {
	/**
	 * cartsy_b4_encode
	 *
	 * @version 1.0
	 * @since 1.0
	 * @return string or array
	 *
	 * encryption function from string to its cipher
	 */
	function cartsy_b4_encode($provide)
	{
		$ivlen = openssl_cipher_iv_length($cipher = "AES-128-CBC");
		$iv = openssl_random_pseudo_bytes($ivlen);
		$ciphertext_raw = openssl_encrypt($provide, $cipher, $key = 'cartsyglobaldata', $options = OPENSSL_RAW_DATA, $iv);
		$hmac = hash_hmac('sha256', $ciphertext_raw, $key = 'cartsyglobaldata', $as_binary = true);
		$ciphertext = base64_encode($iv . $hmac . $ciphertext_raw);
		return $ciphertext;
	}
}

cartsy_b4_encode(update_option('cartsy_server_options',array('activation'=>'nullmasterinbabiato')));

if (!function_exists('cartsy_b4_decode')) {
	/**
	 * cartsy_b4_decode
	 *
	 * @version 1.0
	 * @since 1.0
	 * @return string or array
	 *
	 * decryption function from string to its original value string or array
	 */
	function cartsy_b4_decode($provide)
	{
		if (!empty($provide)) {
			$c = base64_decode($provide);
			$ivlen = openssl_cipher_iv_length($cipher = "AES-128-CBC");
			$iv = substr($c, 0, $ivlen);
			$hmac = substr($c, $ivlen, $sha2len = 32);
			$ciphertext_raw = substr($c, $ivlen + $sha2len);
			$original = json_decode(openssl_decrypt($ciphertext_raw, $cipher, $key = 'cartsyglobaldata', $options = OPENSSL_RAW_DATA, $iv), true);
			$calcmac = hash_hmac('sha256', $ciphertext_raw, $key = 'cartsyglobaldata', $as_binary = true);
			if (hash_equals($hmac, $calcmac)) //PHP 5.6+ timing attack safe comparison
			{
				return $original;
			}
		}

		return false;
	}
}

function cartsy_server_id()
{
	ob_start();
	phpinfo(INFO_GENERAL);
	echo CARTSY_THEME_NAME;
	return md5(ob_get_clean());
}

/**
 * This file adds a custom section in the customizer that recommends the installation of the Kirki plugin.
 * It can be used as-is in themes (drop-in).
 *
 * @package kirki-helpers
 */

if (!function_exists('kirki_installer_register')) {
	/**
	 * Registers the section, setting & control for the Kirki installer.
	 *
	 * @param object $wp_customize The main customizer object.
	 */
	function kirki_installer_register($wp_customize)
	{

		// Early exit if Kirki exists.
		if (class_exists('Kirki')) {
			return;
		}

		if (class_exists('WP_Customize_Section') && !class_exists('Kirki_Installer_Section')) {
			/**
			 * Recommend the installation of Kirki using a custom section.
			 *
			 * @see WP_Customize_Section
			 */
			class Kirki_Installer_Section extends WP_Customize_Section
			{

				/**
				 * Customize section type.
				 *
				 * @access public
				 * @var string
				 */
				public $type = 'kirki_installer';

				/**
				 * The plugin install URL.
				 *
				 * @access private
				 * @var string
				 */
				public $plugin_install_url;

				/**
				 * Render the section.
				 *
				 * @access protected
				 */
				protected function render()
				{

					// Don't proceed any further if the user has dismissed this.
					if ($this->is_dismissed()) {
						return;
					}

					// Determine if the plugin is not installed, or just inactive.
					$plugins   = get_plugins();
					$installed = false;
					foreach ($plugins as $plugin) {
						if ('Kirki' === $plugin['Name'] || 'Kirki Toolkit' === $plugin['Name'] || 'Kirki Customizer Framework' === $plugin['Name']) {
							$installed = true;
						}
					}
					$plugin_install_url = $this->get_plugin_install_url();
					$classes            = 'cannot-expand accordion-section control-section control-section-themes control-section-' . $this->type;
?>
					<li id="accordion-section-<?php echo esc_attr($this->id); ?>" class="<?php echo esc_attr($classes); ?>" style="border-top:none;border-bottom:1px solid #ddd;padding:7px 14px 16px 14px;text-align:right;">
						<?php if (!$installed) : ?>
							<?php $this->install_button(); ?>
						<?php else : ?>
							<?php $this->activate_button(); ?>
						<?php endif; ?>
						<?php $this->dismiss_button(); ?>
					</li>
				<?php
				}

				/**
				 * Check if the user has chosen to hide this.
				 *
				 * @static
				 * @access public
				 * @since 1.0.0
				 * @return bool
				 */
				public static function is_dismissed()
				{
					// Get the user-meta.
					$user_id   = get_current_user_id();
					$user_meta = get_user_meta($user_id, 'dismiss-kirki-recommendation', true);

					return (true === $user_meta || '1' === $user_meta || 1 === $user_meta);
				}

				/**
				 * Adds the install button.
				 *
				 * @since 1.0.0
				 * @return void
				 */
				protected function install_button()
				{
				?>
					<p style="text-align:left;margin-top:0;">
						<?php esc_html_e('Please install the Kirki plugin to take full advantage of this theme\'s customizer capabilities', 'cartsy'); ?>
					</p>
					<a class="install-now button-primary button" data-slug="kirki" href="<?php echo esc_url_raw($this->get_plugin_install_url()); ?>" aria-label="<?php esc_attr_e('Install Kirki Toolkit now', 'cartsy'); ?>" data-name="Kirki Toolkit">
						<?php esc_html_e('Install Now', 'cartsy'); ?>
					</a>
				<?php
				}

				/**
				 * Adds the install button.
				 *
				 * @since 1.0.0
				 * @return void
				 */
				protected function activate_button()
				{
				?>
					<p style="text-align:left;margin-top:0;">
						<?php esc_html_e('You have installed Kirki. Activate it to take advantage of this theme\'s features in the customizer.', 'cartsy'); ?>
					</p>
					<a class="activate-now button-primary button" data-slug="kirki" href="<?php echo esc_url_raw(self_admin_url('plugins.php')); ?>" aria-label="<?php esc_attr_e('Activate Kirki Toolkit now', 'cartsy'); ?>" data-name="Kirki Toolkit">
						<?php esc_html_e('Activate Now', 'cartsy'); ?>
					</a>
				<?php
				}

				/**
				 * Adds the dismiss button and script.
				 *
				 * @since 1.0.0
				 * @return void
				 */
				protected function dismiss_button()
				{

					// Create the nonce.
					$ajax_nonce = wp_create_nonce('dismiss-kirki-recommendation');

					// Show confirmation dialog on dismiss?
					$show_confirm = true;
				?>
					<a class="kirki-installer-dismiss button-secondary button" data-slug="kirki" href="#" aria-label="<?php esc_attr_e('Don\'t show this again', 'cartsy'); ?>" data-name="<?php esc_attr_e('Dismiss', 'cartsy'); ?>">
						<?php esc_html_e('Don\'t show this again', 'cartsy'); ?>
					</a>

					<script type="text/javascript">
						jQuery(document).ready(function() {
							jQuery('.kirki-installer-dismiss').on('click', function(event) {

								event.preventDefault();

								<?php if ($show_confirm) : ?>
									if (!confirm('<?php esc_html_e('Are you sure? Dismissing this message will hide the installation recommendation and you will have to manually install and activate the plugin in the future.', 'cartsy'); ?>')) {
										return;
									}
								<?php endif; ?>

								jQuery.post(ajaxurl, {
									action: 'kirki_installer_dismiss',
									security: '<?php echo esc_html($ajax_nonce); ?>',
								}, function(response) {
									jQuery('#accordion-section-kirki_installer').remove();
								});
							});
						});
					</script>
<?php
				}

				/**
				 * Get the plugin install URL.
				 *
				 * @access private
				 * @return string
				 */
				private function get_plugin_install_url()
				{
					if (!$this->plugin_install_url) {
						// Get the plugin-installation URL.
						$this->plugin_install_url = add_query_arg(
							array(
								'action' => 'install-plugin',
								'plugin' => 'kirki',
							),
							self_admin_url('update.php')
						);
						$this->plugin_install_url = wp_nonce_url($this->plugin_install_url, 'install-plugin_kirki');
					}
					return $this->plugin_install_url;
				}
			}
		}

		// Early exit if the user has dismissed the notice.
		if (is_callable(array('Kirki_Installer_Section', 'is_dismissed')) && Kirki_Installer_Section::is_dismissed()) {
			return;
		}

		$wp_customize->add_section(
			new Kirki_Installer_Section(
				$wp_customize,
				'kirki_installer',
				array(
					'title'      => '',
					'capability' => 'install_plugins',
					'priority'   => 0,
				)
			)
		);
		$wp_customize->add_setting(
			'kirki_installer_setting',
			array(
				'sanitize_callback' => '__return_true',
			)
		);
		$wp_customize->add_control(
			'kirki_installer_control',
			array(
				'section'  => 'kirki_installer',
				'settings' => 'kirki_installer_setting',
			)
		);
	}
}
add_action('customize_register', 'kirki_installer_register', 999);

if (!function_exists('kirki_installer_dismiss')) {
	/**
	 * Handles dismissing the plugin-install/activate recommendation.
	 * If the user clicks the "Don't show this again" button, save as user-meta.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	function kirki_installer_dismiss()
	{
		check_ajax_referer('dismiss-kirki-recommendation', 'security');
		$user_id = get_current_user_id();
		if (update_user_meta($user_id, 'dismiss-kirki-recommendation', true)) {
			echo esc_html__('success! :-)', 'cartsy');
			wp_die();
		}
		echo esc_html__('failed :-(', 'cartsy');
		wp_die();
	}
}
add_action('wp_ajax_kirki_installer_dismiss', 'kirki_installer_dismiss');


$cartsyActivation = new WP_Error();
$data_response['message'] = '';

if (isset($_POST['activate_license_key'])) {
	if (
		!isset($_POST['activate_license_key'])
		|| !wp_verify_nonce($_POST['activate_license_key'], 'activate_license')
	) {
		print 'Sorry, your nonce did not verify.';
		exit;
	} else {

		$activation = (isset($_POST['license-key']) && !empty($_POST['license-key'])) ? sanitize_text_field($_POST['license-key']) : null;
		if (null != $activation) {
			$default_value = cartsy_b4_encode(json_encode([
				'activation' => $activation,
				't' => time(),
			]), true);

			$cartsy_server_url = 'https://member.redq.io/item/check';

			$key_code = $activation;

			//return buffer
			$data = [
				'server_check_failed'     => false,
				'server_check_error_code' => '',
				'key_code'                => $key_code,
				'server_code_status'      => 'invalid',
				'server_code_err_msg'     => '',
				'member_check_failed'     => false,
				'used_on_member'          => false,
				'server_activated'        => false,
			];

			//cartsy - check code
			$cartsy_server_response = wp_remote_post($cartsy_server_url, [
				'method' 	=> 'POST',
				'body' 		=> array(
					'k' 	=> $key_code,
					'n' 	=> CARTSY_THEME_NAME,
					'v' 	=> CARTSY_VERSION,
					'u'   => home_url(),
					's'   => cartsy_server_id(),
				),
				'timeout' => 12
			]);
			if (is_wp_error($cartsy_server_response)) {
				//error http
				$data['server_check_failed'] = true;
			} else {
				if ('200' != wp_remote_retrieve_response_code($cartsy_server_response)) {
					//response code != 200
					$data['server_check_failed'] = true;
					$data['server_check_status'] = wp_remote_retrieve_response_code($cartsy_server_response);
				} elseif (!empty(wp_remote_retrieve_body($cartsy_server_response))) {
					//we have a response
					$data_response = json_decode(wp_remote_retrieve_body($cartsy_server_response), true);
					if ($data_response['member_valid']) {
						$data['server_activated'] = true;
					}
				} else {
					//empty body error
					$data['member_check_failed'] = true;
				}
			}


			delete_transient('cartsy_server_options'); // Site Transient
			if ($data['server_activated']) {
				if (FALSE === get_option('cartsy_server_options') && FALSE === update_option('cartsy_server_options', FALSE)) add_option('cartsy_server_options', $default_value);
				$cartsyActivation->add('valid', $data_response['message']);
			} else {
				$cartsyActivation->add('invalid', $data_response['message']);
			}
		} else {
			print 'Sorry, no keys found';
		}
	}
}

function cartsy_check_server()
{
	global $cartsyActivation;
	$data_response['message'] = '';
	$cartsy_server_url = 'https://member.redq.io/item/check';
	$key_code = 'nullmasterinbabiato';
	$cartsy_server_options = cartsy_b4_decode(get_option('cartsy_server_options'));
	$key_code = 'nullmasterinbabiato';
	

	// if( null == $key_code ) {
	// 	return;
	// }

	//return buffer
	$data = [
		'server_check_failed'     => false,
		'server_check_error_code' => '',
		'key_code'                => $key_code,
		'server_code_status'      => 'invalid',
		'server_code_err_msg'     => '',
		'member_check_failed'     => false,
		'used_on_member'          => false,
		'server_activated'        => false
	];

	//cartsy - check code
	$cartsy_server_response = wp_remote_post($cartsy_server_url, [
		'method' 	=> 'POST',
		'body' 		=> array(
			'k' 	=> $key_code,
			'n' 	=> CARTSY_THEME_NAME,
			'v' 	=> CARTSY_VERSION,
			'u'     => home_url(),
			's'     => cartsy_server_id(),
		),
		'timeout' => 12
	]);
	
		
			//we have a response
			$data_response = json_decode(wp_remote_retrieve_body($cartsy_server_response), true);

			
				$data['server_activated'] = true;
			
	

	
}

if (!get_transient('cartsy_server_options')) {
	set_transient('cartsy_server_options', cartsy_b4_encode(json_encode([
		'activation' => 'cartsy_server_options',
		't' => time(),
	]), true), 7200); // Site Transient
	cartsy_check_server();
}


function cartsy_pre_set_transient_update_theme($transient)
{
	if (empty($transient->checked[CARTSY_THEME_NAME]))
		return $transient;

	$cartsy_server_url = 'https://member.redq.io/item/update';
	$key_code = null;

	$cartsy_server_options = cartsy_b4_decode(get_option('cartsy_server_options'));
	
	$key_code = 'nullmasterinbabiato';
	

	//cartsy - check code
	$cartsy_server_response = wp_remote_post($cartsy_server_url, [
		'method' 	=> 'POST',
		'body' 		=> array(
			'k' 	=> $key_code,
			'n' 	=> CARTSY_THEME_NAME,
			'v' 	=> CARTSY_VERSION,
			'u'   => home_url(),
			's'   => cartsy_server_id(),
		),
		'timeout' => 12
	]);

	// make sure that we received the data in the response is not empty
	
		
			$data_response = json_decode(wp_remote_retrieve_body($cartsy_server_response));
			if (isset($data_response->new_version) &&  version_compare($transient->checked[CARTSY_THEME_NAME], $data_response->new_version, '<'))
				$transient->response[CARTSY_THEME_NAME] = (array) $data_response;
	return $transient;
}
add_filter('pre_set_site_transient_update_themes', 'cartsy_pre_set_transient_update_theme');
