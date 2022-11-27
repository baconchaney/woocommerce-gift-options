<?php
/**
 * The CC_WC_Gift_Cart class.
 *
 * @class    CC_WC_Gift_Cart
 * @package  Woocommerce Gift Options
 * @since    1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class CC_WC_Gift_Cart {
	/*
	* Single instance of the class.
	* @var CC_WC_Gift_Cart
	* 
	* @since 1.0
	*/
	protected static $_instance = null;
	/*
	* Main instance of the class. Ensures only one instance of this class can be loaded.
	*
	* @static
	* @return CC_WC_Gift_Cart
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
		// Modify product price
		add_filter( 'woocommerce_add_cart_item_data', array($this,'sanitize_cart_item_input'), 10, 3 );
		// Update cart item gift information such as modified price and message details
		add_action( 'woocommerce_before_calculate_totals', array($this,'update_cart_item_gift_data'), 10, 1 );
		//Save gift information to access in orders, emails, and thank you pages
		add_action( 'woocommerce_checkout_create_order_line_item', array( $this, 'add_item_meta' ), 20,4);

	}

	/*
	* Modifies the existing $cart_item_data to update the price in the basket and sanitize the gift input fields.
	*
	* @param array 		$cart_item_data
	* @param string 	$product_id
	* @param string		$variation_id
	* @return array
	* 
	* @since 1.0
	*/
	function sanitize_cart_item_input( $cart_item_data, $product_id, $variation_id ) {
		
		$product = wc_get_product( $product_id );
		$gift_option = get_post_meta($product_id, 'cc_wc_gift_giftwrapping_option',true);
										
		if ($gift_option == 0) return $cart_item_data;
				
		if( ! empty( $_POST['gift_toggle'] ) ) {
			
			if ($gift_option == 2) {
				$giftWrapPrice = get_post_meta($product_id, 'cc_wc_gift_giftwrapping_price',true);
				$price = $product->get_price();
				$cart_item_data['new_price'] = $price + $giftWrapPrice;
			}
			$cart_item_data['gift_toggle'] = $_POST['gift_toggle'];
			if( ! empty( $_POST['recipient'] ) ) $cart_item_data['gift_recipient'] = sanitize_text_field($_POST['recipient']);
			if( ! empty( $_POST['message'] ) ) $cart_item_data['gift_message'] = sanitize_textarea_field($_POST['message']);
			if( ! empty( $_POST['from'] ) ) $cart_item_data['gift_from'] = sanitize_text_field($_POST['from']);
		}
		return $cart_item_data;
	}

	/*
	* Save modified cart_item_data to be accessed in orders.
	*
	* @param obj 		$cart_obj
	* @return object
	* 
	* @since 1.0
	*/
	function update_cart_item_gift_data( $cart_obj ) {
		if ( is_admin() && ! defined( 'DOING_AJAX' ) ) return;
		// Iterate through each cart item
		foreach( $cart_obj->get_cart() as $key=>$cart_item_data ) {
			if( isset( $cart_item_data['new_price'] ) ) {
				$price = $cart_item_data['new_price'];
				$cart_item_data['data']->set_price( ( $price ) );
			}
			if( isset( $cart_item_data['gift_toggle'] ) ) {
				$cart_item_data['data']->add_meta_data('gift_settings',$cart_item_data['gift_toggle'],true );
			}
			if( isset( $cart_item_data['gift_recipient'] ) ) {
				$cart_item_data['data']->add_meta_data('gift_recipient',$cart_item_data['gift_recipient'],true );
			}
			if( isset( $cart_item_data['gift_message'] ) ) {
				$cart_item_data['data']->add_meta_data('gift_message',$cart_item_data['gift_message'],true );
			}
			if( isset( $cart_item_data['gift_from'] ) ) {
				$cart_item_data['data']->add_meta_data('gift_from',$cart_item_data['gift_from'],true );
			}
			
		}
	}

	/*
	* Save data submitted as order line item meta data
	*
	* @return void
	* 
	* @since 1.0
	*/
	public function add_item_meta( $item, $cart_item_key, $values, $order ) {	
		if( array_key_exists('gift_toggle',$values) ) {
			$item->add_meta_data('is_gift',true,true );
		}
		if( array_key_exists('gift_recipient',$values) ) {
			$item->add_meta_data('Recipient',$values['gift_recipient'],true );
		}
		if( array_key_exists('gift_message',$values) ) {
			$item->add_meta_data('Message',$values['gift_message'],true );
		}
		if( array_key_exists('gift_from',$values) ) {
			$item->add_meta_data('From',$values['gift_from'],true );
		}
	}
}