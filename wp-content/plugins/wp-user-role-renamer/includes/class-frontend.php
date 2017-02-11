<?php
/**
 * Dependency Checker
 *
 * Checks if required Dependency plugin is enabled
 *
 * @link https://wordpress.org/plugins/wp-user-role-renamer
 * @package WP-User-Role-Renamer
 * @subpackage WP-User-Role-Renamer/FrontEnd
 * @since 1.0
 */
if ( ! defined( 'WPINC' ) ) { die; }

class wp_user_role_renamer_Functions {

	public function __construct() {
        add_filter('wc_rbpfs_wp_user_roles',array($this,'rename_roles'),10,2);
        add_filter('wc_rbp_wp_user_roles',array($this,'rename_roles'),10,2);
        add_shortcode('wp_urr',array($this,'rename_roles_shortcode'));
    }    
    
    public function rename_roles($roles){
        $return = $roles;
        foreach ($roles as $roleID => $roleVal){
           $return[$roleID]['name'] = wp_urr_get_name($roleID,$roleVal['name']);
        }
        return $return;
    }
    
    public function wc_rbp_rename_fields($roles){
		foreach($roles as $roleSlug => $roleVal){  
			$roles[$roleSlug]['name'] = wp_urr_get_name($roleSlug,$roleVal['name']);
		}
		return $roles;
	}
    
    public function rename_roles_shortcode($atts){
        $atts = shortcode_atts( array('role' => '','value' => ''), $atts, 'wp_urr' );
        return wp_urr_get_name($atts['role'],$atts['value']);
    }
}