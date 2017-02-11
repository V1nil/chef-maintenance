<?php
/*
Plugin Name: WooCommerce - All in One SEO Pack
Plugin URI: http://www.visser.com.au/woocommerce/plugins/all-in-one-seo-pack/
Description: Manage All in One SEO Pack meta details for WooCommerce Products within the Add/Edit Products view within the WordPress Administration.
Version: 1.3.4
Author: Visser Labs
Author URI: http://www.visser.com.au/about/
License: GPL2
*/

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

define( 'WOO_AI_DIRNAME', basename( dirname( __FILE__ ) ) );
define( 'WOO_AI_RELPATH', basename( dirname( __FILE__ ) ) . '/' . basename( __FILE__ ) );
define( 'WOO_AI_PATH', plugin_dir_path( __FILE__ ) );
define( 'WOO_AI_PREFIX', 'woo_ai' );

define( 'WOO_AI_NAME', __( 'All in One SEO Pack for WooCommerce', 'woo_ai' ) );
define( 'WOO_AI_MENU', __( 'All in One SEO Pack', 'woo_ai' ) );

include_once( WOO_AI_PATH . 'includes/common.php' );
include_once( WOO_AI_PATH . 'includes/functions.php' );

function woo_ai_i18n() {

	load_plugin_textdomain( 'woo_ai', null, dirname( plugin_basename( __FILE__ ) ) . '/languages' );

}
add_action( 'init', 'woo_ai_i18n' );
?>