<?php
/* 
Plugin Name: Boat and Yacht Charter Booking System for WordPress
Plugin URI: https://1.envato.market/boat-and-yacht-charter-booking-system-for-wordpress
Description: Boat and Yacht Charter Booking System is a powerful watercraft reservation WordPress plugin for companies of all sizes. The system will work both in a small water equipment rental business, e.g. a rental of rowing boats, kayaks, pedal boats, as well as the main booking system for servicing a large water port or marina. The plugin will handle a large number of vessels and allows you to handle unlimited locations
Author: QuanticaLabs
Version: 1.6
Author URI: https://1.envato.market/quanticalabs-portfolio
*/
	
load_plugin_textdomain('boat-charter-booking-system',false,dirname(plugin_basename(__FILE__)).'/languages/');

require_once('include.php');

$Plugin=new BCBSPlugin();
$WooCommerce=new BCBSWooCommerce();

register_activation_hook(__FILE__,array($Plugin,'pluginActivation'));

add_action('init',array($Plugin,'init'));
add_action('after_setup_theme',array($Plugin,'afterSetupTheme'));
add_filter('woocommerce_locate_template',array($WooCommerce,'locateTemplate'),1,3);

$WidgetBookingForm=new BCBSWidgetBookingForm();
$WidgetBookingForm->register();