<?php
/**
 * Plugin Name: Woocommerce gift options
 * Plugin URI: https://github.com/baconchaney/woocommerce-gift-option-plugin
 * Description: Create the options in Woocommerce to add product gift options.
 * Version: 1.2.0
 * Author: Chris Chaney
 * Author URI: https://github.com/baconchaney/baconchaney
 * Text Domain: cc_wc_gift_options
 * Domain Path: /languages
 * WC requires at least: 3.1.0
 * WC tested up to: 7.1.0
 */
 defined( 'ABSPATH' ) || exit;
 
if ( ! defined( 'CC_WC_GIFT_PLUGIN_FILE' ) ) {
	define( 'CC_WC_GIFT_PLUGIN_FILE', __FILE__ );
}
if ( ! defined( 'CC_WC_GIFT_PLUGIN_SLUG' ) ) {
	define( 'CC_WC_GIFT_PLUGIN_SLUG', plugin_basename( __DIR__ ) );
}

use YahnisElsts\PluginUpdateChecker\v5\PucFactory;

 
 function cc_wc_gift_init() {
	// Dependencies are met so launch plugin.
	if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {

		require_once dirname( __FILE__ ) . '/includes/class-cc-wc-gift.php';
		CC_WC_Gift::get_instance();
		/*require_once dirname( __FILE__ ) . '/utility/updates.php';
		WC_CC_GIFT_UPDATES::get_instance();*/
		
		require dirname( __FILE__ ) . '/utility/plugin-update-checker/plugin-update-checker.php';
			$myUpdateChecker = PucFactory::buildUpdateChecker(
			'https://chrischaney.co.uk/plugin/woocommerce_gift_options/info.json',
			__FILE__, //Full path to the main plugin file or functions.php.
			CC_WC_GIFT_PLUGIN_FILE
		);

	} else {
		error_log("Woocommerce not detected. Aborting...");	
	}
 }

add_action( 'plugins_loaded', 'cc_wc_gift_init', 5 );