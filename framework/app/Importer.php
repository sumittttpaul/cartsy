<?php

namespace Framework\App;

// Do not allow directly accessing this file.
if (!defined('ABSPATH')) {
	exit('Direct script access denied.');
}

use WP_Query;

class Importer
{

	/**
	 * Construct the admin object.
	 *
	 * @since 1.0.0
	 */
	public function __construct()
	{
		add_filter('pt-ocdi/plugin_page_setup', [$this, 'importerPageSetup']);
		add_filter('pt-ocdi/plugin_page_title', [$this, 'importerPageTitle']);
		add_filter('pt-ocdi/plugin_intro_text', [$this, 'pluginIntroText']);
		add_filter('pt-ocdi/disable_pt_branding',  [$this, 'disabledPTBranding']);
		add_filter('pt-ocdi/import_files', [$this, 'importDemoFiles']);
		add_action('pt-ocdi/after_import', [$this, 'importAfterSetup']);
		add_action('pt-ocdi/after_all_import_execution', [$this, 'afterImportDemoData'], 10, 3);
	}

	/**
	 * disableCustomerSaveImage
	 *
	 * @param  mixed $data
	 * @return bool
	 */
	public function disableCustomerSaveImage($data)
	{
		return false;
	}
	/**
	 * enableWpCustomizeSaveHooks
	 *
	 * @param  mixed $data
	 * @return bool
	 */
	public function enableWpCustomizeSaveHooks($data)
	{
		return false;
	}


	/**
	 * importerPageSetup
	 *
	 * @param mixed $default_settings
	 *
	 * @return array
	 */
	public function importerPageSetup($default_settings)
	{
		$default_settings['parent_slug'] = 'admin.php';
		$default_settings['page_title'] = esc_html__('Cartsy Demos', 'cartsy');
		$default_settings['menu_title'] = esc_html__('Cartsy Demos', 'cartsy');
		$default_settings['capability'] = 'import';
		$default_settings['menu_slug'] = 'cartsy-demos';
		return $default_settings;
	}

	/**
	 * importerPageTitle
	 *
	 * @param mixed $intro_text
	 *
	 * @return void
	 */
	public function importerPageTitle($intro_text)
	{
		// Start output buffer for displaying the plugin intro text.
		ob_start();
?>
		<h1 class="ocdi__title  dashicons-before  dashicons-upload">
			<?php esc_html_e('Cartsy Demo Importer', 'cartsy'); ?>
		</h1>
	<?php
		$importer_page_title = ob_get_clean();
		return $importer_page_title;
	}


	/**
	 * pluginIntroText
	 *
	 * @param mixed $intro_text
	 *
	 * @return void
	 */
	function pluginIntroText($intro_text)
	{
		// Start output buffer for displaying the plugin intro text.
		ob_start();
	?>
		<div class="cartsy-theme-setup-main-wrapper">
			<div class="cartsy-theme-description cartsy-theme-setup-content-wrapper">

				<?php if (FALSE == get_option('cartsy_server_options')) { ?>
					<!-- DESCRIPTION -->
					<div class="cartsy-getting-started-description-wrapper">
						<h1 class="cartsy-theme-setup-content-title">
							<?php esc_html_e('Sorry!', 'cartsy') ?>
						</h1>
						<p class="description-text">
							<?php die(esc_html__('Cartsy theme license is not activated yet, Please activate the license first to import the demo data.', 'cartsy')); ?>
						</p>
					</div>
				<?php } else { ?>
					<!-- DESCRIPTION -->
					<div class="cartsy-getting-started-description-wrapper">
						<h1 class="cartsy-theme-setup-content-title"><?php esc_html_e('Description', 'cartsy') ?></h1>
						<p class="description-text">
							<?php esc_html_e('When you import the data, the following things might happen : ', 'cartsy'); ?>
						</p>
						<ul>
							<li>
								<?php esc_html_e('1. No existing posts, pages, categories, images, custom post types or any other data will be deleted or modified.', 'cartsy'); ?>
							</li>
							<li>
								<?php esc_html_e('2. Posts, pages, images, widgets, menus and other theme settings will get imported.', 'cartsy'); ?>
							</li>
							<li>
								<b><?php esc_html_e('3. Please click on the Import button only once and wait, it can take a couple of minutes.', 'cartsy'); ?>
								</b>
							</li>
						</ul>
						<hr>
					</div>
				<?php } ?>
			</div>
		</div>
<?php
		$notices = ob_get_clean();
		return $notices;
	}


	/**
	 * disabledPTBranding
	 *
	 * @return boolean
	 */
	function disabledPTBranding()
	{
		return true;
	}


	/**
	 * importAfterSetup
	 *
	 * @return void
	 */
	public function importAfterSetup()
	{
		// Assign menus to their locations.
		$main_menu = get_term_by('name', 'Main menu', 'nav_menu');
		set_theme_mod(
			'nav_menu_locations',
			array(
				'cartsy-menu' => $main_menu->term_id,
			)
		);

		// delete hello-world
		$dummyBlog = get_posts(array('name' => 'hello-world'));
		if (count($dummyBlog) && isset($dummyBlog[0]->ID)) {
			wp_delete_post($dummyBlog[0]->ID);
		}

		// front page
		$front_page_id = get_page_by_title('Products');
		if (isset($front_page_id->ID)) {
			update_option('page_on_front', $front_page_id->ID);
		}
		update_option('show_on_front', 'page');

		// blog page
		$blog_page  = get_page_by_title('Blog');
		if (isset($blog_page->ID)) {
			update_option('page_for_posts', $blog_page->ID);
		}
	}

	/**
	 * getImportedItem
	 *
	 * @param  array $array
	 * @param  int $selected_index
	 * @return array
	 */
	public function getImportedItem($array, $selected_index)
	{
		$i = 0;
		foreach ($array as $value) {
			if ($i == $selected_index) {
				return $value;
			}
			$i++;
		}
		return [];
	}


	/**
	 * afterImportDemoData
	 *
	 * @param  array $selected_import_files
	 * @param  array $import_files
	 * @param  integer $selected_index
	 * @return void
	 */
	public function afterImportDemoData($selected_import_files, $import_files, $selected_index)
	{
		$seletedDemo = $this->getImportedItem($import_files, $selected_index);
		if (!empty($seletedDemo) && $seletedDemo['import_file_name'] === 'Rental & Booking') {
			$args = array(
				'post_type'   => 'product',
				'posts_per_page' => -1,
				'fields' => 'ids',
				'suppress_filters' => 0,
			);
			$products_query = new WP_Query($args);
			$products = $products_query->posts;
			if (!empty($products)) {

				foreach ($products as $key => $product) {
					$post_id = $product;
					if (class_exists('RedQ_Rental_And_Bookings') && is_rental_product($post_id)) {

						global $wpdb;
						$values = array();
						$fields = array();

						$pivot_table = $wpdb->prefix . 'rnb_inventory_product';

						$wpdb->delete($pivot_table, array('product' => $post_id), array('%d'));

						$inventory_data = get_post_meta($post_id, '_redq_product_inventory', true);

						if (isset($inventory_data) && !empty($inventory_data)) {
							foreach ($inventory_data as $pvi) {
								$values[] = "(%d, %d)";
								$fields[] = $pvi;
								$fields[] = $post_id;
							}
						}
						$values = implode(",", $values);

						$wpdb->query($wpdb->prepare(
							"INSERT INTO $pivot_table ( inventory, product ) VALUES $values",
							$fields
						));

						$result = rnb_get_product_price($post_id);
						$price = $result['price'];
						update_post_meta($post_id, '_price', $price);
					}
				}
			}
		}
	}

	/**
	 * importDemoFiles
	 *
	 * @return array
	 */
	public function importDemoFiles()
	{
		return array(
			array(
				'import_file_name'				=> 'Grocery',
				'categories'					=> array('Grocery & Bakery'),
				'import_file_url'				=> 'https://s3.amazonaws.com/redqteam.com/distribution/cartsy_demos/1.2/grocery/cartsy_grocery.xml',
				'import_customizer_file_url'	=> 'https://s3.amazonaws.com/redqteam.com/distribution/cartsy_demos/1.2/grocery/cartsy_grocery.dat',
				'import_widget_file_url'   		=> '',
				'import_preview_image_url'		=> CARTSY_IMAGE_PATH . 'grocery.jpg',
				'import_notice'            		=> esc_html__('Grocery demo data is ready to import.', 'cartsy'),
				'preview_url'					=> 'https://cartsy.redq.io/',
			),
			array(
				'import_file_name'				=> 'Bakery',
				'categories'					=> array('Grocery & Bakery'),
				'import_file_url'				=> 'https://s3.amazonaws.com/redqteam.com/distribution/cartsy_demos/1.2/bakery/cartsy_bakery.xml',
				'import_customizer_file_url'	=> 'https://s3.amazonaws.com/redqteam.com/distribution/cartsy_demos/1.2/bakery/cartsy_bakery.dat',
				'import_widget_file_url'   		=> '',
				'import_preview_image_url'		=> CARTSY_IMAGE_PATH . 'bakery.jpg',
				'import_notice'            		=> esc_html__('Bakery demo data is ready to import.', 'cartsy'),
				'preview_url'					=> 'https://cartsy.redq.io/bakery/',
			),
			array(
				'import_file_name'				=> 'Furniture',
				'categories'					=> array('Furniture'),
				'import_file_url'				=> 'https://s3.amazonaws.com/redqteam.com/distribution/cartsy_demos/1.2/furniture/cartsy_furniture.xml',
				'import_customizer_file_url'	=> 'https://s3.amazonaws.com/redqteam.com/distribution/cartsy_demos/1.2/furniture/cartsy_furniture.dat',
				'import_widget_file_url'   		=> '',
				'import_notice'              	=> esc_html__('Furniture demo data is ready to import.', 'cartsy'),
				'import_preview_image_url'		=> CARTSY_IMAGE_PATH . 'furniture.jpg',
				'preview_url'					=> 'https://cartsy.redq.io/furniture/',
			),

			array(
				'import_file_name'				=> 'Rental & Booking',
				'categories'					=> array('Rental'),
				'import_file_url'				=> 'https://s3.amazonaws.com/redqteam.com/distribution/cartsy_demos/1.4/rnb/cartsy_rental.xml',
				'import_customizer_file_url'	=> 'https://s3.amazonaws.com/redqteam.com/distribution/cartsy_demos/1.4/rnb/cartsy_rental.dat',
				'import_widget_file_url'   		=> '',
				'import_preview_image_url'		=> CARTSY_IMAGE_PATH . 'rnb.png',
				'import_notice'            		=> esc_html__('Rental & Booking demo data is ready to import.', 'cartsy'),
				'preview_url'					=> 'https://cartsy.redq.io/car-rental/',
			),

			array(
				'import_file_name'				=> 'Medicine',
				'categories'					=> array('Medicine'),
				'import_file_url'				=> 'https://s3.amazonaws.com/redqteam.com/distribution/cartsy_demos/1.2/medicine/cartsy_medicine.xml',
				'import_customizer_file_url'	=> 'https://s3.amazonaws.com/redqteam.com/distribution/cartsy_demos/1.2/medicine/cartsy_medicine.dat',
				'import_widget_file_url'   		=> '',
				'import_preview_image_url'		=> CARTSY_IMAGE_PATH . 'medicine.jpg',
				'import_notice'            		=> esc_html__('Medicine demo data is ready to import.', 'cartsy'),
				'preview_url'					=> 'https://cartsy.redq.io/medicine/',
			),

			array(
				'import_file_name'				=> 'Gadgets',
				'categories'					=> array('Gadgets & Electronics'),
				'import_file_url'				=> 'https://s3.amazonaws.com/redqteam.com/distribution/cartsy_demos/1.2/gadgets/cartsy_gadgets.xml',
				'import_customizer_file_url'	=> 'https://s3.amazonaws.com/redqteam.com/distribution/cartsy_demos/1.2/gadgets/cartsy_gadgets.dat',
				'import_widget_file_url'   		=> '',
				'import_preview_image_url'		=> CARTSY_IMAGE_PATH . 'gadgets.jpg',
				'import_notice'            		=> esc_html__('Gadgets demo data is ready to import.', 'cartsy'),
				'preview_url'					=> 'https://cartsy.redq.io/gadgets/',
			),

			array(
				'import_file_name'				=> 'Home Appliance',
				'categories'					=> array('Gadgets & Electronics'),
				'import_file_url'				=> 'https://s3.amazonaws.com/redqteam.com/distribution/cartsy_demos/1.2/home_appliance/cartsy_home_appliance.xml',
				'import_customizer_file_url'	=> 'https://s3.amazonaws.com/redqteam.com/distribution/cartsy_demos/1.2/home_appliance/cartsy_home_appliance.dat',
				'import_widget_file_url'   		=> '',
				'import_preview_image_url'		=> CARTSY_IMAGE_PATH . 'home-appliance.jpg',
				'import_notice'            		=> esc_html__('Home Appliance demo data is ready to import.', 'cartsy'),
				'preview_url'					=> 'https://cartsy.redq.io/home-appliance/',
			),

			array(
				'import_file_name'				=> 'Baby Care',
				'categories'					=> array('Baby Care'),
				'import_file_url'				=> 'https://s3.amazonaws.com/redqteam.com/distribution/cartsy_demos/1.2/baby_care/cartsy_baby_care.xml',
				'import_customizer_file_url'	=> 'https://s3.amazonaws.com/redqteam.com/distribution/cartsy_demos/1.2/baby_care/cartsy_baby_care.dat',
				'import_widget_file_url'   		=> '',
				'import_preview_image_url'		=> CARTSY_IMAGE_PATH . 'baby_care.jpg',
				'import_notice'            		=> esc_html__('Baby Care demo data is ready to import.', 'cartsy'),
				'preview_url'					=> 'https://cartsy.redq.io/baby-care/',
			),

			array(
				'import_file_name'				=> 'Micro Greens',
				'categories'					=> array('Greens'),
				'import_file_url'				=> 'https://s3.amazonaws.com/redqteam.com/distribution/cartsy_demos/1.2/microgreen/cartsy_microgreen.xml',
				'import_customizer_file_url'	=> 'https://s3.amazonaws.com/redqteam.com/distribution/cartsy_demos/1.2/microgreen/cartsy_microgreen.dat',
				'import_widget_file_url'   		=> '',
				'import_preview_image_url'		=> CARTSY_IMAGE_PATH . 'microgreen.jpg',
				'import_notice'            		=> esc_html__('Micro Greens demo data is ready to import.', 'cartsy'),
				'preview_url'					=> 'https://cartsy.redq.io/microgreen/',
			),

			array(
				'import_file_name'				=> 'Fashion',
				'categories'					=> array('Clothing'),
				'import_file_url'				=> 'https://s3.amazonaws.com/redqteam.com/distribution/cartsy_demos/1.3/fashion/cartsy_fashion.xml',
				'import_customizer_file_url'	=> 'https://s3.amazonaws.com/redqteam.com/distribution/cartsy_demos/1.3/fashion/cartsy_fashion.dat',
				'import_widget_file_url'   		=> '',
				'import_preview_image_url'		=> CARTSY_IMAGE_PATH . 'fashion.jpg',
				'import_notice'            		=> esc_html__('Fashion demo data is ready to import.', 'cartsy'),
				'preview_url'					=> 'https://cartsy.redq.io/fashion/',
			),

			array(
				'import_file_name'				=> 'Plants',
				'categories'					=> array('Greens'),
				'import_file_url'				=> 'https://s3.amazonaws.com/redqteam.com/distribution/cartsy_demos/1.3/plants/cartsy_plants.xml',
				'import_customizer_file_url'	=> 'https://s3.amazonaws.com/redqteam.com/distribution/cartsy_demos/1.3/plants/cartsy_plants.dat',
				'import_widget_file_url'   		=> '',
				'import_preview_image_url'		=> CARTSY_IMAGE_PATH . 'plants.jpg',
				'import_notice'            		=> esc_html__('Plants demo data is ready to import.', 'cartsy'),
				'preview_url'					=> 'https://cartsy.redq.io/plants/',
			),

		);
	}
}
