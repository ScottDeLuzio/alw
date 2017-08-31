<?php
/**
 * Plugin Name: Link widget for displaying simple links
 * Plugin URI: https://scottdeluzio.com
 * Description: Provides a simple interface for creating links and displaying them in a widget.
 * Author: Scott DeLuzio
 * Author URI: https://scottdeluzio.com
 * Version: 0.1
 *
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! defined( 'ALW_VERSION' ) ) {
	define( 'ALW_VERSION', '0.1' );
}
if( ! defined( 'ALW_PLUGIN_URL' ) ) {
	define( 'ALW_PLUGIN_URL', plugins_url( '', __FILE__ ) );
}
if( ! defined( 'ALW_PLUGIN_DIR' ) ) {
	define( 'ALW_PLUGIN_DIR', dirname( __FILE__ ) );
}

include( ALW_PLUGIN_DIR . '/includes/widget.php' );
include( ALW_PLUGIN_DIR . '/includes/dashboard-input.php' );


add_action( 'admin_enqueue_scripts', 'alw_admin_style' );
function alw_admin_style(){
	wp_register_style( 'alw-css', ALW_PLUGIN_URL . '/includes/alw.css', __FILE__ );
	wp_enqueue_style( 'alw-css' );
}
