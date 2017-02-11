<?php
/**
 * Common Plugin Functions
 * 
 * @link https://wordpress.org/plugins/wp-user-role-renamer
 * @package WP-User-Role-Renamer
 * @subpackage WP-User-Role-Renamer/core
 * @since 1.0
 */
if ( ! defined( 'WPINC' ) ) { die; }

if(!function_exists('wp_urr_is_request')){
    /**
	 * What type of request is this?
	 * string $type ajax, frontend or admin
	 * @return bool
	 */
    function wp_urr_is_request( $type ) {
        switch ( $type ) {
            case 'admin' :
                return is_admin();
            case 'ajax' :
                return defined( 'DOING_AJAX' );
            case 'cron' :
                return defined( 'DOING_CRON' );
            case 'frontend' :
                return ( ! is_admin() || defined( 'DOING_AJAX' ) ) && ! defined( 'DOING_CRON' );
        }
    }
}

if(!function_exists('wp_urr_current_screen')){
    /**
     * Gets Current Screen ID from wordpress
     * @return string [Current Screen ID]
     */
    function wp_urr_current_screen(){
       $screen =  get_current_screen();
       return $screen->id;
    }
}

if(!function_exists('wp_urr_get_screen_ids')){
    /**
     * Returns Predefined Screen IDS
     * @return [Array] 
     */
    function wp_urr_get_screen_ids(){
        $screen_ids = array();
        return $screen_ids;
    }
}

if(!function_exists('wp_urr_dependency_message')){
	function wp_urr_dependency_message(){
		$text = __( WP_URR_NAME . ' requires <b> WooCommerce </b> To Be Installed..  <br/> <i>Plugin Deactivated</i> ', WP_URR_TXT);
		return $text;
	}
}

if(!function_exists('wp_urr_user_roles')){
    function wp_urr_user_role(){
        $user_roles = get_editable_roles();
		$user_roles['logedout'] = array('name' => __('Visitor / LogedOut User',WC_RBP_TXT));  
        return $user_roles;
    }
}

if(!function_exists('wp_urr_get_name')){
    function wp_urr_get_name($key,$val){
        $values = get_option(WP_URR_DB.'names',array());
        if(isset($values[$key])){
            if(!empty($values[$key])){
                return $values[$key];
            }
        }
        return $val;
    }
}
?>