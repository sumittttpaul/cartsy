<?php


namespace Framework\App;

// Do not allow directly accessing this file.
if (!defined('ABSPATH')) {
    exit('Direct script access denied.');
}


class Plugin
{
    public function __construct()
    {
        add_action('tgmpa_register', [$this, 'loadPlugins']);
    }

    public function loadPlugins()
    {
        /**
         * Array of plugin arrays. Required keys are name and slug.
         * If the source is NOT from the .org repo, then source is also required.
         */
        $plugins = array(
            array(
                'name'     => esc_html__('Cartsy Theme Helper', 'cartsy'),
                'slug'     => 'cartsy-helper',
                'required' => true,
                'force_activation'   => false,
                'force_deactivation' => false,
                'plugin_class_name' => 'CartsyHelper',
                'image_url' => CARTSY_PLUGIN_IMAGE . 'carty-helper.svg',
                'source' => 'https://s3.amazonaws.com/redqteam.com/distribution/cartsy_plugins/1.4/cartsy-helper.zip',
                'version' => '1.4',
                'developed_by' => 'own'
            ),
            array(
                'name'     => esc_html__('Cartsy Algolia', 'cartsy'),
                'slug'     => 'cartsy-algolia',
                'required' => true,
                'force_activation'   => false,
                'force_deactivation' => false,
                'plugin_class_name' => 'CartsyAlgolia',
                'image_url' => CARTSY_PLUGIN_IMAGE . 'algolia.svg',
                'source' => 'https://s3.amazonaws.com/redqteam.com/distribution/cartsy_plugins/1.3/cartsy-algolia.zip',
                'version' => '1.3',
                'developed_by' => 'own'
            ),
            array(
                'name'     => esc_html__('RedQ Reuse Form', 'cartsy'),
                'slug'     => 'redq-reuse-form',
                'required' => true,
                'force_activation'   => false,
                'force_deactivation' => false,
                'plugin_class_name' => 'RedqReuseForm',
                'image_url' => CARTSY_PLUGIN_IMAGE . 'redq-reuse-form.svg',
                'source' => 'https://s3.amazonaws.com/redqteam.com/distribution/cartsy_plugins/1.2/redq-reuse-form.zip',
                'version' => '4.0.5',
                'developed_by' => 'own'
            ),
            array(
                'name'     => esc_html__('Google Map Loader', 'cartsy'),
                'slug'     => 'googlemap',
                'required' => true,
                'force_activation'   => false,
                'force_deactivation' => false,
                'plugin_class_name' => 'Load_Google_Map',
                'image_url' => CARTSY_PLUGIN_IMAGE . 'google-map.svg',
                'source' => 'https://s3.amazonaws.com/redqteam.com/distribution/cartsy_plugins/1.2/googlemap.zip',
                'version'   => '1.0.1',
                'developed_by' => 'own'
            ),
            array(
                'name'     => esc_html__('Firebase Mobile Authentication [by RedQ, Inc]', 'cartsy'),
                'slug'     => 'wp-firebase-auth',
                'required' => false,
                'force_activation'   => false,
                'force_deactivation' => false,
                'plugin_class_name' => 'WFOTP',
                'image_url' => CARTSY_PLUGIN_IMAGE . 'firebase-mobile-auth.svg',
                'source' => 'https://s3.amazonaws.com/redqteam.com/distribution/cartsy_plugins/1.2/wp-firebase-auth.zip',
                'version'   => '1.0.0',
                'developed_by' => 'own'
            ),
            array(
                'name'     => esc_html__('WooCommerce Quick View [by RedQ, Inc]', 'cartsy'),
                'slug'     => 'woocommerce-quick-view',
                'required' => false,
                'force_activation'   => false,
                'force_deactivation' => false,
                'plugin_class_name' => 'RedQWooCommerceQuickView',
                'image_url' => CARTSY_PLUGIN_IMAGE . 'pop-up.svg',
                'source' => 'https://s3.amazonaws.com/redqteam.com/distribution/cartsy_plugins/1.3.1/woocommerce-quick-view.zip',
                'version'   => '1.0.2',
                'developed_by' => 'own'
            ),
            array(
                'name'     => esc_html__('WooCommerce Rental & Booking [by RedQ, Inc]', 'cartsy'),
                'slug'     => 'woocommerce-rental-and-booking',
                'required' => false,
                'force_activation'   => false,
                'force_deactivation' => false,
                'plugin_class_name' => 'RedQ_Rental_And_Bookings',
                'image_url' => CARTSY_PLUGIN_IMAGE . 'rnb.svg',
                'source' => 'https://s3.amazonaws.com/redqteam.com/distribution/cartsy_plugins/1.4/woocommerce-rental-and-booking.zip',
                'version'   => '10.0.5',
                'developed_by' => 'own'
            ),
            array(
                'name'     => esc_html__('WooCommerce - excelling eCommerce [by Automattic]', 'cartsy'),
                'slug'     => 'woocommerce',
                'required' => true,
                'force_activation'   => false,
                'force_deactivation' => false,
                'plugin_class_name' => 'WooCommerce',
                'image_url' => CARTSY_PLUGIN_IMAGE . 'woocommerce.svg',
                'developed_by' => 'other'
            ),
            array(
                'name'     => esc_html__('Kirki Customizer Framework [by David Vongries]', 'cartsy'),
                'slug'     => 'kirki',
                'required' => true,
                'force_activation'   => false,
                'force_deactivation' => false,
                'plugin_class_name' => 'Kirki',
                'image_url' => CARTSY_PLUGIN_IMAGE . 'kirki.svg',
                'developed_by' => 'other'
            ),
            array(
                'name'     => esc_html__('Contact Form 7 [by Takayuki Miyoshi]', 'cartsy'),
                'slug'     => 'contact-form-7',
                'required' => true,
                'force_activation'   => false,
                'force_deactivation' => false,
                'plugin_class_name' => 'WPCF7',
                'image_url' => CARTSY_PLUGIN_IMAGE . 'contact-from-7.svg',
                'developed_by' => 'other',
            ),
            array(
                'name'     => esc_html__('One Click Demo Importer [by ProteusThemes]', 'cartsy'),
                'slug'     => 'one-click-demo-import',
                'required' => true,
                'force_activation'   => false,
                'force_deactivation' => false,
                'plugin_class_name' => 'OCDI_Plugin',
                'image_url' => CARTSY_PLUGIN_IMAGE . 'demo-importer.svg',
                'developed_by' => 'other'
            ),
            array(
                'name'     => esc_html__('Social Login [by Nextendweb]', 'cartsy'),
                'slug'     => 'nextend-facebook-connect',
                'required' => false,
                'force_activation'   => false,
                'force_deactivation' => false,
                'plugin_class_name' => 'NextendSocialLogin',
                'image_url' => CARTSY_PLUGIN_IMAGE . 'social-login.svg',
                'developed_by' => 'other'
            ),
            array(
                'name'     => esc_html__('Facebook Messenger [by Facebook]', 'cartsy'),
                'slug'     => 'facebook-messenger-customer-chat',
                'required' => false,
                'force_activation'   => false,
                'force_deactivation' => false,
                'plugin_class_name' => 'Facebook_Messenger_Customer_Chat',
                'image_url' => CARTSY_PLUGIN_IMAGE . 'messanger-support.svg',
                'developed_by' => 'other'
            ),
            array(
                'name'     => esc_html__('WhatsApp [by QuadLayers]', 'cartsy'),
                'slug'     => 'wp-whatsapp-chat',
                'required' => false,
                'force_activation'   => false,
                'force_deactivation' => false,
                'plugin_class_name' => 'QLWAPP',
                'image_url' => CARTSY_PLUGIN_IMAGE . 'whatsapp-support.svg',
                'developed_by' => 'other'
            ),
            array(
                'name'     => esc_html__('WPUpper Share Buttons [by Victor Freitas]', 'cartsy'),
                'slug'     => 'wpupper-share-buttons',
                'required' => false,
                'force_activation'   => false,
                'force_deactivation' => false,
                'plugin_class_name' => 'WPUSB_App',
                'image_url' => CARTSY_PLUGIN_IMAGE . 'product-social-share.svg',
                'developed_by' => 'other'
            ),
            array(
                'name'     => esc_html__('YITH WooCommerce Wishlist [by YITH]', 'cartsy'),
                'slug'     => 'yith-woocommerce-wishlist',
                'required' => false,
                'force_activation'   => false,
                'force_deactivation' => false,
                'plugin_class_name' => 'YITH_WCWL',
                'image_url' => CARTSY_PLUGIN_IMAGE . 'yith-wishlist.svg',
                'developed_by' => 'other'
            ),
            array(
                'name'     => esc_html__('Cookie Notice for GDPR & CCPA [by dFactory]', 'cartsy'),
                'slug'     => 'cookie-notice',
                'required' => false,
                'force_activation'   => false,
                'force_deactivation' => false,
                'plugin_class_name' => 'Cookie_Notice',
                'image_url' => CARTSY_PLUGIN_IMAGE . 'gdpr_cookie_notice.svg',
                'developed_by' => 'other'
            ),
            array(
                'name'     => esc_html__('WOOCS - WooCommerce Currency Switcher [by realmag777]', 'cartsy'),
                'slug'     => 'woocommerce-currency-switcher',
                'required' => false,
                'force_activation'   => false,
                'force_deactivation' => false,
                'plugin_class_name' => 'WOOCS_STARTER',
                'image_url' => CARTSY_PLUGIN_IMAGE . 'currency-switcher.svg',
                'developed_by' => 'other'
            ),
            array(
                'name'     => esc_html__('WP SVG images [by Victor KubiQ]', 'cartsy'),
                'slug'     => 'wp-svg-images',
                'required' => true,
                'force_activation'   => false,
                'force_deactivation' => false,
                'plugin_class_name' => 'WPSVG',
                'image_url' => CARTSY_PLUGIN_IMAGE . 'svg-support.svg',
                'developed_by' => 'other'
            ),
            array(
                'name'     => esc_html__('Variation Swatches for WooCommerce [by Emran Ahmed]', 'cartsy'),
                'slug'     => 'woo-variation-swatches',
                'required' => false,
                'force_activation'   => false,
                'force_deactivation' => false,
                'plugin_class_name' => 'Woo_Variation_Swatches',
                'image_url' => CARTSY_PLUGIN_IMAGE . 'variation.svg',
                'developed_by' => 'other'
            ),
        );



        /**
         * Array of configuration settings. Amend each line as needed.
         * If you want the default strings to be available under your own theme domain,
         * leave the strings uncommented.
         * Some of the strings are added into a sprintf, so see the comments at the
         * end of each line for what each argument will be.
         */
        $config = array(
            'id'           => 'cartsy',               // Unique ID for hashing notices for multiple instances of TGMPA.
            'default_path' => '',                      // Default absolute path to bundled plugins.
            'menu'         => 'tgmpa-install-plugins', // Menu slug.
            'parent_slug'  => 'themes.php',            // Parent menu slug.
            'capability'   => 'edit_theme_options',    // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
            'has_notices'  => true,                    // Show admin notices or not.
            'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
            'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
            'is_automatic' => false,                   // Automatically activate plugins after installation or not.
            'message'      => '',                      // Message to output right before the plugins table.
        );
        tgmpa($plugins, $config);
    }
}
