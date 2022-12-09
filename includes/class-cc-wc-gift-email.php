<?php
/**
 * The CC_WC_Gift_Email class.
 *
 * @class    CC_WC_Gift_Email
 * @package  Woocommerce Gift Options
 * @since    1.0.0
 * @version 1.1.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
if(!class_exists('CC_WC_Gift_Email')) {
    class CC_WC_Gift_Email {
        /*
        * Single instance of the class.
        * @var CC_WC_Gift_Email
        * 
        * @since 1.0
        */
        protected static $_instance = null;
        /*
        * Main instance of the class. Ensures only one instance of this class can be loaded.
        *
        * @static
        * @return CC_WC_Gift_Email
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
            // Add tracking code field to order emails
            add_filter( 'woocommerce_email_order_meta_fields', array($this,'render_order_meta'), 10, 3 );
        }
        /*
        * Render tracking code field on emails
        *
        * @return void
        * 
        * @since 1.0
		* @version 1.1.0
        */
        function render_order_meta( $fields, $sent_to_admin, $order ) {
            $tracking = $order->get_meta('tracking_details');

            if (empty($tracking)) return $fields;

            $fields['tracking_code'] = array(
                'label' => __('Order tracking code','cc_wc_gift_options'),
                'value' => $tracking
            );

            return $fields;
        }
    }
}