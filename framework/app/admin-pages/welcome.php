<?php
$cartsy_theme = wp_get_theme();
if ($cartsy_theme->parent_theme) {
	$cartsy_template_dir = basename(get_theme_file_path());
	$cartsy_theme = wp_get_theme($cartsy_template_dir);
}
$CARTSY_VERSION = wp_get_theme()->get('Version');
$cartsy_author = wp_get_theme()->get('Author');
$cartsy_description = wp_get_theme()->get('Description');
$allowed_tags = wp_kses_allowed_html('post');
$plugins = TGM_Plugin_Activation::$instance->plugins;

/**
 * Checking algolia
 */
$OCDI_button_check = DemoImportingCheck();
$OCDI_button_class = 'disabled';

if ($OCDI_button_check != false) {
	$OCDI_button_class = 'enable';
}
?>

<div class="cartsy-theme-setup-main-wrapper">
	<div class="cartsy-theme-description cartsy-theme-setup-content-wrapper">
		<!-- LOGO -->
		<div class="cartsy-getting-started-logo-wrapper">
			<div class="cartsy-logo">
				<img src="<?php echo esc_url(CARTSY_IMAGE_PATH . 'main-logo.svg') ?>" alt="<?php echo esc_attr($cartsy_theme->get('Name')); ?>">
			</div>
			<div class="cartsy-getting-started-version">
				<span>
					<?php
					echo esc_html__('V.', 'cartsy');
					echo esc_attr($CARTSY_VERSION);
					?>
				</span>
			</div>
		</div>

		<!-- DESCRIPTION -->
		<div class="cartsy-getting-started-description-wrapper">
			<h1 class="cartsy-theme-setup-content-title"><?php esc_html_e('Description', 'cartsy') ?></h1>
			<p class="description-text">
				<?php echo esc_html($cartsy_description); ?>
			</p>
		</div>

		<?php require_once get_theme_file_path('/framework/app/admin-pages/intro.php'); ?>

		<div class="cartsy-theme-setup-import-demo-data" title='<?php echo esc_html__('Please complete all the theme setup progress above.', 'cartsy'); ?>'>
			<a href="<?php echo esc_url(admin_url('admin.php?page=cartsy-demos')); ?>" class="<?php echo esc_attr($OCDI_button_class); ?>">
				<?php echo esc_html__('Import Demo Data', 'cartsy'); ?>
			</a>
		</div>
		<!-- Basic structure set up end -->


		<!-- Info Box -->
		<div class="cartsy-getting-started-column-wrapper">
			<div class="cartsy-getting-started-column">
				<a href="<?php echo esc_url('https://member.redq.io/'); ?>" class="cartsy-misc-info-block" target="_blank" rel="noopener noreferrer">
					<div class="cartsy-misc-info-img-wrapper">
						<img src="<?php echo esc_url(CARTSY_IMAGE_PATH . '/headphone.svg') ?>" alt="<?php esc_attr_e('Customer Support', 'cartsy') ?>">
					</div>
					<h3><?php esc_html_e('Customer Support', 'cartsy'); ?></h3>
					<p><?php echo esc_html__('Please open a ticket in the support forum. [Note: It will open in new browser tab.]', 'cartsy'); ?></p>
				</a>
			</div>
			<div class="cartsy-getting-started-column">
				<a href="<?php echo esc_url('https://www.youtube.com/watch?v=UxJYqDe30Ec&list=PLUT1MYLrVpA9sFhkzfxQGQ2DNVnmU03Q_'); ?>" class="cartsy-misc-info-block" target="_blank" rel="noopener noreferrer">
					<div class="cartsy-misc-info-img-wrapper">
						<img src="<?php echo esc_url(CARTSY_IMAGE_PATH . '/film.svg') ?>" alt="<?php esc_attr_e('Video documentation', 'cartsy') ?>">
					</div>
					<h3><?php esc_html_e('Video documentation', 'cartsy') ?></h3>
					<p><?php esc_html_e('Please check our video documentation to make your next directory site. [Note: It will open in new browser tab.]', 'cartsy') ?></p>
				</a>
			</div>
			<div class="cartsy-getting-started-column">
				<a href="<?php echo esc_url('https://cartsy-doc.vercel.app/'); ?>" class="cartsy-misc-info-block" target="_blank" rel="noopener noreferrer">
					<div class="cartsy-misc-info-img-wrapper">
						<img src="<?php echo esc_url(CARTSY_IMAGE_PATH . '/document.svg') ?>" alt="<?php esc_attr_e('Online Documentaion', 'cartsy') ?>">
					</div>
					<h3><?php esc_html_e('Online Documentaion', 'cartsy') ?></h3>
					<p><?php esc_html_e('We are making the Online Documentation for better understanding about the theme. Please check the link if needed. [Note: It will open in new browser tab.]', 'cartsy') ?></p>
				</a>
			</div>
		</div>
		<!-- /Info box -->
	</div>

	<!-- Pagintaion -->
	<div class="cartsy-theme-setup-pagination">
		<a href="#" class='prev disabled'>
			<span class="dashicons dashicons-arrow-left-alt"></span>
			<?php echo esc_html__('Previous Step', 'cartsy'); ?>
		</a>
		<a href="<?php echo esc_url(admin_url('admin.php?page=cartsy-theme-setup-screen')); ?>" class='next'>
			<?php echo esc_html__('Next Step', 'cartsy'); ?>
			<span class="dashicons dashicons-arrow-right-alt"></span>
		</a>
	</div>
</div>