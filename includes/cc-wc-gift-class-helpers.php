<?php
/**
 * The Woocommerce Gift Options class helpers. Used to find the current instance of classes.
 * @package  Woocommerce Gift Options
 * @since    1.0.0
 */

 if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

function CC_WC_Gift() { // The main plugin class
	return CC_WC_Gift::get_instance();
}

function CC_WC_Gift_Display(){ // The front-end display class
	return CC_WC_Gift_Display::get_instance();
}

function CC_WC_Gift_Order(){ // The admin order class
	return CC_WC_Gift_Order::get_instance();
}

function CC_WC_Gift_Cart(){ // The front end cart class
	return CC_WC_Gift_Cart::get_instance();
}

function CC_WC_Gift_Admin_Product(){ // The front end cart class
	return CC_WC_Gift_Admin_Product::get_instance();
}