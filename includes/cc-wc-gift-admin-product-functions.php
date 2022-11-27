<?php
/**
 * CC WC Gift admin functions
 *
 * @package  Woocommerce Gift Options
 * @since    1.0.0
 */

 defined( 'ABSPATH' ) || exit;
 
add_action('woocommerce_product_options_general_product_data','cc_wc_gift_product_gift_fields');
add_action('woocommerce_process_product_meta','cc_wc_gift_save_product_gift_fields');

function cc_wc_gift_product_gift_fields() {
	global $woocommerce, $post;
		
	$_giftwrapping_option = get_post_meta($post->ID, 'cc_wc_gift_giftwrapping_option');
	$_giftwrapping_price = get_post_meta($post->ID, 'cc_wc_gift_giftwrapping_price');
				
	echo '<div class="gift_fields options_group">';
		$radioGift = woocommerce_wp_radio(array(
				'id' => 'cc_wc_gift_giftwrapping_option',
				'label' => 'Allow giftwrapping?',
				'value'=> ($_giftwrapping_option)? $_giftwrapping_option[0]: '0',
				'options' => array(
					'0' => 'No',
					'1' => 'Enabled by default (no charge)',
					'2' => 'Yes but chargeable'
				),
				'default' => ($_giftwrapping_option)? $_giftwrapping_option[0]: '0',
				'style' => 'width:16px',
				'wrapper_class' => 'form-field form-field-wide',
			));	
			
			woocommerce_wp_text_input(array(
				'id' => 'cc_wc_gift_giftwrapping_price',
				'label' => 'Price for giftwrapping (£)',
				'desc_tip' => 'true',
				'description' => 'Price to be added if chosen by customer',
				'value'=> ($_giftwrapping_price)? $_giftwrapping_price[0] : '',
				'default' => '0.00',
				'wrapper_class' => 'form-field form-field-wide',
				'class' => 'short wc_input_price',
				'type' => 'price',
			));	
			
		echo '</div>';
}

function cc_wc_gift_save_product_gift_fields($post_id) {
	$_giftwrapping_option = $_POST['cc_wc_gift_giftwrapping_option'];
	if (!empty($_giftwrapping_option))
	update_post_meta($post_id, 'cc_wc_gift_giftwrapping_option', esc_attr($_giftwrapping_option));
	
	$_giftwrapping_price = $_POST['cc_wc_gift_giftwrapping_price'];
	if (!empty($_giftwrapping_price))
	update_post_meta( $post_id, 'cc_wc_gift_giftwrapping_price', wc_format_localized_price( $_POST[ 'cc_wc_gift_giftwrapping_price' ] ) );
}

function register_admin_scripts() {
	wp_register_script( 'gift_field_visbility', cc_wc_Gift()->plugin_url() . '/assets/js/admin/gift-field-visibility.js','', '1',true );
	
	// Get admin screen id.
	$screen    = get_current_screen();
	$screen_id = $screen ? $screen->id : '';
	
	if ( 'product' === $screen_id ) {
		wp_enqueue_script('gift_field_visbility');	
	}
	
}
