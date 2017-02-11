<?php
/*
Plugin Name: All Meta Stats All in One SEO Pack Addon
Plugin URI: http://www.netattingo.com/
Description: With the help of this add-on we can see the stats of Keywords for All in One SEO Pack.
Author: NetAttingo Technologies
Version: 1.0.0
Author URI: http://www.netattingo.com/
*/


//initilize constant
define('MSAIOSPA_DIR', plugin_dir_path(__FILE__));
define('MSAIOSPA_URL', plugin_dir_url(__FILE__));
define('MSAIOSPA_PAGE_DIR', plugin_dir_path(__FILE__).'pages/');
define('MSAIOSPA_INCLUDE_URL', plugin_dir_url(__FILE__).'includes/');

//Include menu and assign page
function msaispa_plugin_menu() {
    $icon = MSAIOSPA_URL. 'includes/icon.png';
	add_menu_page("Meta Stats All One SEO", "Meta Stats All One SEO", "administrator", "msaispa-keyword-stats", "msaispa_plugin_pages", $icon ,41);
	add_submenu_page("msaispa-keyword-stats", "Keywords Stats", "Keywords Stats", "administrator", "msaispa-keyword-stats", "msaispa_plugin_pages");
	add_submenu_page("msaispa-keyword-stats", "Descriptions Stats", "Descriptions Stats", "administrator", "msaispa-description-stats", "msaispa_plugin_pages");
	add_submenu_page("msaispa-keyword-stats", "Titles Stats", "Titles Stats", "administrator", "msaispa-title-stats", "msaispa_plugin_pages");
	add_submenu_page("msaispa-keyword-stats", "About Us", "About Us", "administrator", "msaispa-about-us", "msaispa_plugin_pages");
}
add_action("admin_menu", "msaispa_plugin_menu");

function msaispa_plugin_pages() {
   $itm = MSAIOSPA_PAGE_DIR.$_GET["page"].'.php';
   include($itm);
}

//add admin css
function msaispa_admin_css() {
  wp_register_style('msaispa_admin_css', plugins_url('includes/admin-style.css',__FILE__ ));
  wp_enqueue_style('msaispa_admin_css');
}
add_action( 'admin_init','msaispa_admin_css');


?>