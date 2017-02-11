<?php 
/**
 * Plugin Name: Change Product Author for WooCommerce
 * Description: Makes it easy to change the author assigned to a WooCommerce product post type
 * Version: 1.0.0
 * Author: Ollie Murphy
 * Author URI: https://github.com/omurphy27
 * Text Domain: woo-change-product-author
 *
 * License: GNU General Public License v3.0
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 */

if ( ! defined( 'ABSPATH' ) ) { 
    exit; // Exit if accessed directly
}

// include required plugin class
include( 'classes/class-woo-change-product-author.php' );

// perform the initialization on the plugins loaded action
add_action( 'plugins_loaded', 'omcpa_initialize_plugin' );

function omcpa_initialize_plugin() {
	$omcpa_class = new OMCPA_Woo_Change_Product_Author();
}

?>