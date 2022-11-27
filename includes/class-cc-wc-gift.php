<?php
/**
 * The Main CC_WC_GIFT class.
 *
 * @class    CC_WC_GIFT
 * @package  Woocommerce Gift Options
 * @since    1.0.0
 */
 
 if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if(!class_exists('CC_WC_GIFT')) {
	class CC_WC_GIFT {
	
		protected static $_instance = null;
				
		public static function get_instance() {
			if ( is_null( self::$_instance ) ) {
				self::$_instance = new self();
			}
			return self::$_instance;
		}
		
		/*-----------------------------------------------------------------------------------*/
		/*  Helper Functions                                                                 */
		/*-----------------------------------------------------------------------------------*/
		/**
		 * Get the plugin url.
		 *
		 * @return string
		 */
		public function plugin_url() {
			return untrailingslashit( plugins_url( '/', CC_WC_GIFT_PLUGIN_FILE ) );
		}
		/**
		 * Get the plugin path.
		 *
		 * @return string
		 */
		public function plugin_path() {
			return untrailingslashit( plugin_dir_path( CC_WC_GIFT_PLUGIN_FILE ) );
		}
		
		/**
		 * Get the plugin base path name.
		 *
		 * @return string
		 */
		public function plugin_basename() {
			return plugin_basename( CC_WC_GIFT_PLUGIN_FILE );
		}
		
		
		public function __construct() {
			$this->initialise_plugin();
		}
		
		function initialise_plugin() {
			$this->includes();
			
			if(!is_admin()) {
				$this->frontend_includes();
			}
						
			if(is_admin()) {
				$this->admin_includes();	
				add_action('admin_enqueue_scripts','register_admin_scripts');
			}
			
			CC_WC_GIFT_Display()->get_instance();
			CC_WC_GIFT_Order()->get_instance();
			CC_WC_GIFT_Cart()->get_instance();
		}
		
		public function includes() {
			require_once( 'class-cc-wc-gift-order.php' );
			require_once( 'class-cc-wc-gift-cart.php' );
			require_once( 'class-cc-wc-gift-display.php' );
			require_once( 'cc-wc-gift-class-helpers.php' );
		}
		
		public function frontend_includes() {
			require_once( 'cc-wc-gift-template-hooks.php' );
		}
		
		public function admin_includes() {
			require_once( 'cc-wc-gift-admin-product-functions.php' );
		}
		
		
	}
}