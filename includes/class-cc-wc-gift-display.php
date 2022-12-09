<?php
/**
 * The CC_WC_Gift_Display class.
 * 
 * Used to handle displaying the front-end information.
 * 
 * @class    CC_WC_Gift_Display
 * @package  Woocommerce Gift Options
 * @since    1.0.0
 * @version 1.1.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


/*
* CC_WC_GIFT_Display Class
* 
* Woocommerce gift options front-end functions and filters.
*/
class CC_WC_Gift_Display {

	/*
	* Single instance of the class.
	* @var CC_WC_GIFT_Display
	* 
	* @since 1.0
	*/
	protected static $_instance = null;
	/*
	* Main instance of the class. Ensures only one instance of this class can be loaded.
	*
	* @static
	* @return CC_WC_GIFT_Display
	* 
	* @since 1.0
	*/
	public static function get_instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}
	/*
	* Constructor function
	*/
	public function __construct() {
		// Display "Gift" next to the line item title if option is selected.
		add_filter( 'woocommerce_cart_item_name', array($this,'append_gift_wrap_to_cart_item_title'), 10, 3 );
		// Display gift message details under the relevant line item
		add_filter( 'woocommerce_get_item_data', array($this,'display_item_gift_details'), 10, 2 );
		// Load scripts
		add_action( 'wp_enqueue_scripts', array( $this, 'register_frontend_scripts' ) );
	}


	/*
	* Modifies line item title if product is a gift.
	*
	* @param string 		$product_name
	* @param array			$cart_item
	* @param string			$cart_item_key
	* @return string
	* 
	* @since 1.0
	*/
	public function append_gift_wrap_to_cart_item_title($product_name, $cart_item,$cart_item_key){
		if( isset( $cart_item['gift_toggle'] ) ) 
		$product_name = wp_kses_post( $product_name . ' - Gift');			
		return $product_name;
	}	
	
	/*
	* Display gift item details in a user-friendly manner.
	*
	* @param array 			$item_data
	* @param array			$cart_item
	* @return array
	* 
	* @since 1.0
	*/
	public function display_item_gift_details($item_data, $cart_item) {
		if ( !empty ($cart_item['gift_toggle']) ) {
			if ( !empty ($cart_item['gift_toggle'])) {
				$item_data[] = array(
					'key' => 'Is a gift?',
					'value' => 'Yes',
				);
			}
			if ( !empty ($cart_item['gift_recipient'])) {
				$item_data[] = array(
					'key' => 'Recipient',
					'value' => $cart_item['gift_recipient'],
				);
			}
			if ( !empty ($cart_item['gift_message'])) {
				$item_data[] = array(
					'key' => 'Message',
					'value' => $cart_item['gift_message'],
				);
			}
			if ( !empty ($cart_item['gift_from'])) {
				$item_data[] = array(
					'key' => 'From',
					'value' => $cart_item['gift_from'],
				);
			}
		}
		return $item_data;	
	}

	/*
	* Gift-options template for Woocommerce Gift Options
	*
	* @return void
	* 
	* @since 1.0
	* @version 1.1.0
	*/
	public function add_gift_option_template() {
		global $product;
	
		// Enqueue scripts.
		wp_enqueue_script( 'gift_field_visbility' );
		wp_enqueue_style( 'gift-fields' );
	
		// Load the add to cart template.
		wc_get_template(
			'single-product/gift-options.php',
			array(
				'product'       => $product,
			),
			'',
			CC_WC_Gift()->plugin_path() . '/templates/'
		);
	}
	
	/*
	* Register scripts
	*
	* @since 1.0
	*/
	public function register_frontend_scripts() {
			wp_register_script( 'gift_field_visbility', CC_WC_Gift()->plugin_url() . '/assets/js/frontend/toggle-gift-fields-display.js','', '1',true );
			wp_register_style( 'gift-fields', CC_WC_Gift()->plugin_url() . '/assets/css/frontend-styles.css'  );
	}
}