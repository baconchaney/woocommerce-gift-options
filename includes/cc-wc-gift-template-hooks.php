<?php
/**
 * Template hooks.
 *
 * @package  Woocommerce Gift Options
 * @since    1.0.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$CC_WC_GIFT_Display = CC_WC_Gift_Display();

add_action('woocommerce_before_add_to_cart_button',array($CC_WC_GIFT_Display,'add_gift_option_template'));
