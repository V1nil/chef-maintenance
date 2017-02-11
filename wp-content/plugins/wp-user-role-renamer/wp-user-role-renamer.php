<?php  
/**
 * WP User Role Renamer Main File
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://wordpress.org/plugins/woocommerce-role-based-price/
 * @since             3.0
 * @package           WP User Role Renamer
 *
 * @wordpress-plugin
 * Plugin Name:       WP User Role Renamer
 * Plugin URI:        https://wordpress.org/plugins/wp-user-role-renamer
 * Description:       Developer Friendly User role renamer Addon Can Work With any plugin if got integrated
 * Version:           1.1
 * Author:            Varun Sridharan
 * Author URI:        http://varunsridharan.in
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wp-user-role-renamer
 * Domain Path:       /languages
 */

if ( ! defined( 'WPINC' ) ) { die; }
 
define('WP_URR_FILE',plugin_basename( __FILE__ ));
define('WP_URR_PATH',plugin_dir_path( __FILE__ )); # Plugin DIR
define('WP_URR_INC',WP_URR_PATH.'includes/'); # Plugin INC Folder


 

require_once(WP_URR_INC.'functions.php');
require_once(plugin_dir_path(__FILE__).'bootstrap.php');

if(!function_exists('wp_user_role_renamer')){
    function wp_user_role_renamer(){
        return wp_user_role_renamer::get_instance();
    }
}
wp_user_role_renamer();