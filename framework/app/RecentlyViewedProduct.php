<?php

namespace Framework\App;

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

/**
 * Class for generate ids based on view
 */
if ( ! class_exists( 'RecentlyViewedProduct' ) ) {
	class RecentlyViewedProduct {

		/**
		 * RecentlyViewedProduct constructor.
		 */
		public function __construct() {
			add_action( 'init', [ $this, 'cartsyStartSession' ], 10 );
			add_action( 'init', [ $this, 'cartsyInitSession' ], 15 );
			add_action( 'wp', [ $this, 'cartsyUpdateProducts' ] );
			add_action( 'init', [ $this, 'cartsyLoadRecentlyViewedTemplates' ] );
		}

		/**
		 * If there is not session started yet then initialize the session
		 */
		public function cartsyStartSession() {
			if ( ! session_id() ) {
				session_start();
			}
		}

		/**
		 * Generate the session name based on the user
		 * If user already logged in then session name will be based on user id
		 * otherwise session prefix will be guest
		 *
		 * @return string
		 */
		public function cartsySessionName() {
			if ( is_user_logged_in() ) {
				$userId      = get_current_user_id();
				$sessionName = 'cartsy_products_' . $userId;
			} else {
				$sessionName = 'cartsy_products_guest';
			}

			return $sessionName;
		}

		/**
		 * Create the session when user open the site
		 */
		public function cartsyInitSession() {
			if ( ! isset( $_SESSION[ $this->cartsySessionName() ] ) ) {
				$_SESSION[ $this->cartsySessionName() ] = serialize( array() );
			}
		}

		/**
		 * Get product list from the session ids
		 *
		 * @return false|mixed
		 */
		public function cartsyGetProducts() {

			if ( ! isset( $_SESSION[ $this->cartsySessionName() ] ) ) {
				return false;
			}

			return unserialize( $_SESSION[ $this->cartsySessionName() ] );
		}

		/**
		 * Update products by current product id
		 *
		 * If there is already a product id available on the session
		 * then it'll move current product to array's last element
		 *
		 * @return false | void
		 */
		public function cartsyUpdateProducts() {

			$products = $this->cartsyGetProducts();

			// if not single product page
			if ( ! is_product() ) {
				return false;
			}

			//if current product not found in products array
			if ( ! in_array( get_the_ID(), $products ) ) {
				$products[] = get_the_ID();
			} else {
				//if current product found in products array
				$currentProductKey = array_search( get_the_ID(), $products );
				unset( $products[ $currentProductKey ] );
				$products[] = get_the_ID();
			}

			//update the existing session
			$_SESSION[ $this->cartsySessionName() ] = serialize( $products );
		}

		/**
		 * Load the frontend template function
		 */
		public function cartsyLoadRecentlyViewedTemplates() {
			// Include additional template files
			include get_theme_file_path( '/template-parts/product-general/recently-viewed-products.php' );
		}

	}
}
