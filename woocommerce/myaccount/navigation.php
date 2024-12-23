<?php

/**
 * My Account navigation
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/navigation.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 2.6.0
 */

if (!defined('ABSPATH')) {
  exit;
}

$currentUser = wp_get_current_user();

// set icon for woocommerce my account nav
function cartsy_woocommerce_my_account_nav_icon($icon)
{
  switch ($icon) {
    case 'Dashboard':
      return '<span class="dashicons dashicons-dashboard"></span>';

    case 'Orders':
      return '<span class="dashicons dashicons-cart"></span>';

    case 'Downloads':
      return '<span class="dashicons dashicons-media-archive"></span>';

    case 'Addresses':
      return '<span class="dashicons dashicons-admin-home"></span>';

    case 'Account details':
      return '<span class="dashicons dashicons-admin-users"></span>';

    case 'View Collection':
      return '<span class="dashicons dashicons-chart-bar"></span>';

    case 'Request Quote':
      return '<span class="dashicons dashicons-media-default"></span>';

    case 'Logout':
      return '<span class="dashicons dashicons-upload" style="transform: rotate(90deg);"></span>';

    default:
      return '<span class="dashicons dashicons-arrow-right-alt"></span>';
      break;
  }
}
?>

<?php do_action('woocommerce_before_account_navigation'); ?>

<nav class="woocommerce-MyAccount-navigation">
  <!-- <div class="user-avatar">
		<?php // echo get_avatar($currentUser->ID, 80); 
    ?>
	</div> -->
  <ul>
    <?php foreach (wc_get_account_menu_items() as $endpoint => $label) : ?>
      <li class="<?php echo wc_get_account_menu_item_classes($endpoint); ?>">
        <a href="<?php echo esc_url(wc_get_account_endpoint_url($endpoint)); ?>">
          <?php echo cartsy_woocommerce_my_account_nav_icon($label); ?>
          <?php echo esc_html($label); ?>
        </a>
      </li>
    <?php endforeach; ?>
  </ul>
</nav>

<?php do_action('woocommerce_after_account_navigation'); ?>