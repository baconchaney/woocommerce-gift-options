<?php
/**
 * The CC_WC_Gift_Admin_Product class.
 *
 * @class    CC_WC_Gift_Admin_Product
 * @package  Woocommerce Gift Options
 * @since    1.0.0
 * @version 1.1.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class CC_WC_Gift_Admin_Product {
	/*
	* Single instance of the class.
	* @var CC_WC_Gift_Admin_Product
	* 
	* @since 1.0
	*/
	protected static $_instance = null;
	/*
	* Main instance of the class. Ensures only one instance of this class can be loaded.
	*
	* @static
	* @return CC_WC_Gift_Admin_Product
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
        add_action('woocommerce_product_options_general_product_data',array($this,'cc_wc_gift_product_gift_fields'));
        add_action('woocommerce_process_product_meta',array($this,'cc_wc_gift_save_product_gift_fields'));
        add_action('admin_enqueue_scripts',array($this,'register_admin_scripts'));
    }
    /*
	* Renders the gift option fields on the product admin pages
	*
	* @return void
	* 
	* @since 1.0
	* @version 1.1.0
	*/
    public function cc_wc_gift_product_gift_fields() {
        global $woocommerce, $post;
            
        $_giftwrapping_option = get_post_meta($post->ID, 'cc_wc_gift_giftwrapping_option');
        $_giftwrapping_price = get_post_meta($post->ID, 'cc_wc_gift_giftwrapping_price');
		$_currency_symbol = get_woocommerce_currency_symbol();
                    
        echo '<div class="gift_fields options_group">';
            $radioGift = woocommerce_wp_radio(array(
                    'id' => 'cc_wc_gift_giftwrapping_option',
                    'label' => __('Allow giftwrapping?','cc_wc_gift_options'),
                    'value'=> ($_giftwrapping_option)? $_giftwrapping_option[0]: '0',
                    'options' => array(
                        '0' => __('No','cc_wc_gift_options'),
                        '1' => __('Enabled by default (no charge)','cc_wc_gift_options'),
                        '2' => __('Yes but chargeable','cc_wc_gift_options')
                    ),
                    'default' => ($_giftwrapping_option)? $_giftwrapping_option[0]: '0',
                    'style' => 'width:16px',
                    'wrapper_class' => 'form-field form-field-wide',
                ));	
                
                woocommerce_wp_text_input(array(
                    'id' => 'cc_wc_gift_giftwrapping_price',
                    'label' => sprintf(__('Price for giftwrapping (%s)','cc_wc_gift_options'),$_currency_symbol),
                    'desc_tip' => 'true',
                    'description' => __('Price to be added if chosen by customer','cc_wc_gift_options'),
                    'value'=> ($_giftwrapping_price)? $_giftwrapping_price[0] : '',
                    'default' => '0.00',
                    'wrapper_class' => 'form-field form-field-wide',
                    'class' => 'short wc_input_price',
                    'type' => 'price',
                ));	

            echo '</div>';
    }
    /*
	* Saves the data entered as post meta data
	*
	* @return void
	* 
	* @since 1.0
	*/
    public function cc_wc_gift_save_product_gift_fields($post_id) {
        $_giftwrapping_option = $_POST['cc_wc_gift_giftwrapping_option'];
        if (!empty($_giftwrapping_option))
        update_post_meta($post_id, 'cc_wc_gift_giftwrapping_option', esc_attr($_giftwrapping_option));
        
        $_giftwrapping_price = $_POST['cc_wc_gift_giftwrapping_price'];
        if (!empty($_giftwrapping_price))
        update_post_meta( $post_id, 'cc_wc_gift_giftwrapping_price', wc_format_localized_price( $_POST[ 'cc_wc_gift_giftwrapping_price' ] ) );
    }
    /*
	* Register scripts
	*
	* @since 1.0
	*/
    public function register_admin_scripts() {
        wp_register_script( 'gift_field_visbility', cc_wc_Gift()->plugin_url() . '/assets/js/admin/gift-field-visibility.js','', '1',true );
        
        // Get admin screen id.
        $screen    = get_current_screen();
        $screen_id = $screen ? $screen->id : '';
        
        if ( 'product' === $screen_id ) {
            wp_enqueue_script('gift_field_visbility');	
        }
        
    }

}