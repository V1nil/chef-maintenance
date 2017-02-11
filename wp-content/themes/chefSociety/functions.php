<?php
/**
 * @package   Gantry 5 Theme
 * @author    RocketTheme http://www.rockettheme.com
 * @copyright Copyright (C) 2007 - 2016 RocketTheme, LLC
 * @license   GNU/GPLv2 and later
 *
 * http://www.gnu.org/licenses/gpl-2.0.html
 */

defined('ABSPATH') or die;

// Note: This file must be PHP 5.2 compatible.

// Check min. required version of Gantry 5
$requiredGantryVersion = '5.2.0';

// Bootstrap Gantry framework or fail gracefully.
$gantry_include = get_stylesheet_directory() . '/includes/gantry.php';
if (!file_exists($gantry_include)) {
    $gantry_include = get_template_directory() . '/includes/gantry.php';
}
$gantry = include_once $gantry_include;

if (!$gantry) {
    return;
}

if (!$gantry->isCompatible($requiredGantryVersion)) {
    $current_theme = wp_get_theme();
    $error = sprintf(__('Please upgrade Gantry 5 Framework to v%s (or later) before using %s theme!', 'g5_chefSociety'), strtoupper($requiredGantryVersion), $current_theme->get('Name'));

    if(is_admin()) {
        add_action('admin_notices', function () use ($error) {
            echo '<div class="error"><p>' . $error . '</p></div>';
        });
    } else {
        wp_die($error);
    }
}

/** @var \Gantry\Framework\Theme $theme */
$theme = $gantry['theme'];

// Theme helper files that can contain useful methods or filters
$helpers = array(
    'includes/helper.php', // General helper file
);

foreach ($helpers as $file) {
    if (!$filepath = locate_template($file)) {
        trigger_error(sprintf(__('Error locating %s for inclusion', 'g5_chefSociety'), $file), E_USER_ERROR);
    }

    require $filepath;
}
add_filter( 'woocommerce_checkout_fields' , 'custom_override_checkout_fields' );
 
function custom_override_checkout_fields( $fields ) {
    unset($fields['billing']['billing_first_name']);
    unset($fields['billing']['billing_last_name']);
    unset($fields['billing']['billing_company']);
    unset($fields['billing']['billing_address_1']);
    unset($fields['billing']['billing_address_2']);
    unset($fields['billing']['billing_city']);
    unset($fields['billing']['billing_postcode']);
    unset($fields['billing']['billing_country']);
    unset($fields['billing']['billing_state']);
    unset($fields['billing']['billing_phone']);
    unset($fields['order']['order_comments']);
    unset($fields['billing']['billing_address_2']);
    unset($fields['billing']['billing_postcode']);
    unset($fields['billing']['billing_company']);
    unset($fields['billing']['billing_last_name']);
    unset($fields['billing']['billing_email']);
    unset($fields['billing']['billing_city']);
    return $fields;
}
add_action ( 'wp_footer' , 'menu_decoration_url' );

function menu_decoration_url() {
	
	echo '<script>$(function() {
  var loc = window.location.href; // returns the full URL
  if(/que-se-cuece/.test(loc)) {
    $(".g-menu-item-52").addClass("active");
	$(".g-menu-item-87").addClass("active");
  }
  
  if(/taller/.test(loc)) {
    $(".g-menu-item-53").addClass("active");
	$(".g-menu-item-85").addClass("active");
  }
  
  if(/recipe/.test(loc)) {
    $(".g-menu-item-54").addClass("active");
	$(".g-menu-item-86").addClass("active");
  }
  
  if(/promocion/.test(loc)) {
    $(".g-menu-item-55").addClass("active");
	$(".g-menu-item-88").addClass("active");
  }
});</script>';
   
}

function skyverge_empty_cart_notice() {
    
	    if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
 
    $count = WC()->cart->cart_contents_count;
     if($count != 0) {
	echo '<style>
	.carrito a .fa-lg {
		color:#be1622 !important;
	}
  </style>';
          } 
    } 
}
// Add to shop archives & product pages
add_action( 'wp_footer', 'skyverge_empty_cart_notice' );
/*function redirect_to_checkout() {
    return WC()->cart->get_checkout_url();
}*/