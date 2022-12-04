<?php
/**
 * The CC_WC_Gift_Order class.
 *
 * @class    CC_WC_Gift_Order
 * @package  Woocommerce Gift Options
 * @since    1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/*
* CC_WC_Gift_Order Class
* 
* Handles saving data and displaying information in the admin orders.
*/
class CC_WC_Gift_Order {

	/*
	* Single instance of the class.
	* @var CC_WC_Gift_Order
	* 
	* @since 1.0
	*/
	protected static $_instance = null;
	/*
	* Main instance of the class. Ensures only one instance of this class can be loaded.
	*
	* @static
	* @return CC_WC_Gift_Order
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
		// Add in custom text field to add order tracking code to order meta
		add_action('woocommerce_admin_order_data_after_shipping_address',array( $this,'render_tracking_details_field'));
		// Save data from tracking code field
		add_action('woocommerce_process_shop_order_meta',array( $this,'save_tracking_details'));
		// Change _is_gift meta data key name to be user friendly to users
		add_filter('woocommerce_order_item_display_meta_key', array($this, 'gift_meta_key_display'), 20, 3 );
		// Change _is_gift meta data key value to be user friendly to users
		add_filter('woocommerce_order_item_display_meta_value', array($this, 'gift_meta_value_display'), 20, 3 );	
	}

	/*
	* Display is_gift meta key in a user-friendly manner
	*
	* @return void
	* 
	* @since 1.0
	*/
	public function gift_meta_key_display( $display_key, $meta, $item ) {
		if($meta->key === 'is_gift')
		$display_key = 'Is a gift';
		return $display_key;
	}
	/*
	* Display is_gift meta value in a user-friendly manner
	*
	* @return void
	* 
	* @since 1.0
	*/
	public function gift_meta_value_display( $display_value, $meta, $item ) {
		if($meta->key === 'is_gift')
		$display_value = 'Yes';
		return $display_value;
	}
	/*
	* Display tracking code field in order admin
	*
	* @return void
	* 
	* @since 1.0
	*/
	function render_tracking_details_field($order) {
		$trackingCode = $order->get_meta('tracking_details');
		
		$trackingInputField = woocommerce_wp_text_input(array(
			'id' => 'tracking',
			'label' => 'Tracking Code',
			'value' => $trackingCode,
			'wrapper_class' => 'form-field-wide',
		));
	}
	/*
	* Save tracking detail field input
	*
	* @return void
	* 
	* @since 1.0
	*/
	function save_tracking_details($order_id) {
		   update_post_meta ( $order_id, 'tracking_details',wc_clean( $_POST[ 'tracking' ] ) );
	}

		
}