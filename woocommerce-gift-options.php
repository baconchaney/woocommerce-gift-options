<?php
/**
 * Plugin Name: Woocommerce gift options
 * Plugin URI: https://github.com/baconchaney/woocommerce-gift-option-plugin
 * Description: Create the options in Woocommerce to add product gift options.
 * Version: 1
 * Author: Chris Chaney
 * Author URI: https://github.com/baconchaney/baconchaney
 * WC requires at least: 3.1.0
 * WC tested up to: 7.1.0
 */
 defined( 'ABSPATH' ) || exit;
 
 if ( ! defined( 'CC_WC_GIFT_PLUGIN_FILE' ) ) {
	define( 'CC_WC_GIFT_PLUGIN_FILE', __FILE__ );
}

 
 function cc_wc_gift_init() {
	// Dependencies are met so launch plugin.
	if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
		require_once dirname( __FILE__ ) . '/includes/class-cc-wc-gift.php';
		CC_WC_Gift::get_instance();
	} else {
		error_log("Woocommerce not detected. Aborting...");	
	}
 }

add_action( 'plugins_loaded', 'cc_wc_gift_init', 5 );