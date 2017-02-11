<?php
/**
 * Plugin's Admin code
 *
 * @link https://wordpress.org/plugins/wp-user-role-renamer
 * @package WP-User-Role-Renamer
 * @subpackage WP-User-Role-Renamer/Admin
 * @since 1.0
 */
if ( ! defined( 'WPINC' ) ) { die; }

class wp_user_role_renamer_Admin {

    /**
	 * Initialize the class and set its properties.
	 * @since      0.1
	 */
	public function __construct() {
         
        add_action( 'admin_init', array( $this, 'admin_init' ));

        add_filter( 'plugin_row_meta', array($this, 'plugin_row_links' ), 10, 2 );
        add_filter( 'plugin_action_links_'.WP_URR_FILE, array($this,'plugin_action_links'),10,10);
        add_action( 'admin_menu', array( $this, 'admin_menu' ) );
	}

    /**
     * Inits Admin Sttings
     */
    public function admin_init(){
       # new wp_user_role_renamer_Admin_Sample_Class;
    }
    
    
    function admin_menu() {
        add_submenu_page('tools.php',
        __('WP User Role Renamer',WP_URR_TXT),
        __('WP User Role Renamer',WP_URR_TXT),
        'administrator',WP_URR_SLUG, array( $this, 'admin_page' ) );
	}
 
    public function check_db_update(){
        if(isset($_POST['wp_urr'])){
            update_option(WP_URR_DB.'names',$_POST['wp_urr']);
            echo '<div class="updated settings-error notice is-dismissible" id="setting-error-settings_updated"> 
<p><strong>Settings saved.</strong></p><button class="notice-dismiss" type="button"><span class="screen-reader-text">Dismiss this notice.</span></button></div>';
        }
    }
    
    public function admin_page(){
        $this->check_db_update();
        $roles = wp_urr_user_role();
        
        echo '<div class="wrap">
            <h3>User Role Renamer</h3>
            
            <table class="form-table">
            <tr>
                <td><b> This plugin is integrated with : </b><br/>
            1. <a href="http://wordpress.org/plugins/woocommerce-role-based-price" > WooCommerce Role Based Price</a> <br/>
            2. <a href="https://wpovernight.com/downloads/woocommerce-role-based-force-sell/" > WooCommerce Role Based Force Sell</a> <br/></td>
            
            
            <td> 1. Call <code> wp_urr_get_name($key,$val);</code><br/> <b>$key</b> : User Role Slug  & <b>$val</b> : Default Value When No Value Exist </td> 
            
            <td> 2. Use shortcode <code>[wp_urr role="" value=""]</code> <br/> <b>$key</b> : User Role Slug  & <b>$val</b> : Default Value When No Value Exist </td>
            
            </tr>
            </table>
            
            
                <form method="post">
                <table class="form-table">
        ';
        $values = get_option(WP_URR_DB.'names',array());
        foreach($roles as $roleK => $roleV){
            $name = isset($values[$roleK]) ? $values[$roleK] : '' ;
            echo '<tr>';
                echo '<th><label for="'.$roleK.'">'.$roleV['name'].'</label></th>';
                echo '<td> <input class="regular-text" type="text" id="'.$roleK.'" name="wp_urr['.$roleK.']" placeholder="'.$roleV['name'].'" value="'.$name.'" /> </td>';
            echo '</tr>';
            
        }
        echo '</table>
        <p class="submit"><input type="submit" value="Save Changes" class="button button-primary" name="submit"></p>
        </form></div>';
    }
   
     
 
    /**
	 * Adds Some Plugin Options
	 * @param  array  $plugin_meta
	 * @param  string $plugin_file
	 * @since 0.11
	 * @return array
	 */
    public function plugin_action_links($action,$file,$plugin_meta,$status){
        $url = admin_url('tools.php?page=wp-user-role-renamer');
        $actions[] = sprintf('<a href="%s">%s</a>', $url, __('Settings',WP_URR_TXT) );
        $actions[] = sprintf('<a href="%s">%s</a>', 'http://varunsridharan.in/plugin-support/', __('Contact Author',WP_URR_TXT) );
        $action = array_merge($actions,$action);
        return $action;
    }
    
    /**
	 * Adds Some Plugin Options
	 * @param  array  $plugin_meta
	 * @param  string $plugin_file
	 * @since 0.11
	 * @return array
	 */
	public function plugin_row_links( $plugin_meta, $plugin_file ) {
		if ( WP_URR_FILE == $plugin_file ) {
            $plugin_meta[] = sprintf('<a href="%s">%s</a>', 'https://wordpress.org/plugins/wp-user-role-renamer/', __('F.A.Q',WP_URR_TXT) );
            $plugin_meta[] = sprintf('<a href="%s">%s</a>', 'https://github.com/technofreaky/wp-user-role-renamer/', __('View On Github',WP_URR_TXT) );
            $plugin_meta[] = sprintf('<a href="%s">%s</a>', 'https://github.com/technofreaky/wp-user-role-renamer/', __('Report Issue',WP_URR_TXT) );
		}
		return $plugin_meta;
	}	    
}

?>