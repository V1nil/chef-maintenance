<?php
/**
 * Plugin Name: WP Featured Users By Scripty Team 
 * Plugin URI: http://www.scriptyteam.com
 * Description: Allows the administrator to make users featured by adding star column in Users list table   
 *      and checkbox field in Edit User Profile Page.You can retrieve the featured users using User Meta  	
 *      "wpfui2i_featured_user" or the shortcode [list_featured_users].
 * Author:Scripty Team
 * Version: 1.1
 * Author URI: http://www.scriptyteam.com
 *License: GPLv2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 */
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

/**
 * [wpfui2i_load_scripts load scripts to backend] * 
 */
function wpfui2i_load_scripts() {
    $wpfui2i_js_script_ajax_nonce = wp_create_nonce( "wpfui2i_js_script_ajax_nonce" );
    wp_enqueue_script( 'wpfui2i_js_script', plugins_url( 'wpfui2i_script.js', __FILE__ ) );
    wp_localize_script( 'wpfui2i_js_script', 'wpfui2i_vars', array( 'wpfui2i_ajax_url'   => admin_url( 'admin-ajax.php' ),'wpfui2i_plugin_dir'   => plugins_url('',__FILE__) ,'wpfui2i_js_script_ajax_nonce'=>$wpfui2i_js_script_ajax_nonce));    
}
add_action( 'admin_enqueue_scripts', 'wpfui2i_load_scripts' );

/**
 * [wpfui2i_add_users_column Add column to Users Table called "Featured"] 
 */
function wpfui2i_add_users_column( $column ) {
    $column['wpfui2i_featured_user'] = 'Featured';
    return apply_filters('wpfui2i_featured_col_name',$column);
}
add_filter( 'manage_users_columns', 'wpfui2i_add_users_column' );

/**
 * [wpfui2i_add_featured_user_row Add the row value(Star img) for Featured column] 
 */
function wpfui2i_add_featured_user_row( $val, $column_name, $user_id ) {    
    switch ( $column_name ) {
        case 'wpfui2i_featured_user' :
            $is_featured_user = sanitize_text_field(get_user_meta( $user_id , 'wpfui2i_featured_user' ,true ));

            if( $is_featured_user )
            {
            	return '<img src="'. apply_filters('wpfui2i_featured_user_img',
            		plugins_url( 'active_user.png', __FILE__ )) .'" class="wpfui2i_featured_user" width="16px" height="16px" featured="yes" user-id="'. $user_id .'" >';
            }
            else{
            	return '<img src="'. apply_filters('wpfui2i_not_featured_user_img',
            		plugins_url( 'inactive_user.png', __FILE__ )).'" class="wpfui2i_featured_user" width="16px" height="16px" featured="no" user-id="'. $user_id .'" >';
            }            
            break;
        default:
    }
    
    return; 
}
add_action('manage_users_custom_column',  'wpfui2i_add_featured_user_row', 10, 3);

/**
 * [wpfui2i_toggle_featured_user_status description]
 * @return [type] [description]
 */
function wpfui2i_toggle_featured_user_status() {
    if ( !current_user_can( 'edit_user', $user_id ) ) return false;

    //Ajax nonce
    check_ajax_referer( 'wpfui2i_js_script_ajax_nonce', 'wpfui2i_js_script_ajax_nonce' );

	$is_featured_user = sanitize_text_field($_POST["featured"]);
	$user_id = intval($_POST["user_id"]);

	if( $is_featured_user == 'yes' )
    {
		update_user_meta( $user_id, 'wpfui2i_featured_user' , 'yes' );
	} 
	else {
		delete_user_meta( $user_id, 'wpfui2i_featured_user' );
	}

	echo "User Featured Status Is Changed";
   
}
add_action( 'wp_ajax_wpfui2i_toggle_featured_user_status', 'wpfui2i_toggle_featured_user_status' );

/**
 * [add_featured_checkBox_to_userprofile Add checkbox option user edit page] 
 */
function wpfui2i_add_featured_checkBox_userEditPage( $user ){    
    $user_id = $user->ID;               
    $is_featured_user  = sanitize_text_field(get_user_meta( $user_id, "wpfui2i_featured_user", true ));               
    ?> 
    <table class="form-table">
    	<hr><h3>WP Featured Users Setting</h3>
	    <tr class="user-admin-bar-front-wrap">
			<th scope="row">Featured User</th>
			<td><fieldset><legend class="screen-reader-text"><span>Featured User</span></legend>
				<label for="wpfui2i_featured_user">
				<input name="wpfui2i_featured_user" type="checkbox" id="wpfui2i_featured_user" value="yes" <?php if ( $is_featured_user == 'yes' ){ ?> checked="checked"<?php } ?> >
				Feature this user</label><br>
				</fieldset>
			</td>
		</tr>		
	</table>   
    <?php    
} 
add_action( 'edit_user_profile', 'wpfui2i_add_featured_checkBox_userEditPage',999 );

/**
 * [wpfui2i_save_featured_checkBox_userEditPage  Save the featured option in the user edit page ]
 */
function wpfui2i_save_featured_checkBox_userEditPage( $user_id ){ 	        
	if ( !current_user_can( 'edit_user', $user_id ) ) return false;

	// update this users meta
	if ( isset( $_POST['wpfui2i_featured_user'] ) && sanitize_text_field($_POST['wpfui2i_featured_user']) == "yes" )
    {                     
    	update_user_meta( $user_id, 'wpfui2i_featured_user' , 'yes' );
    }
	else {
	    delete_user_meta( $user_id, 'wpfui2i_featured_user' );
	}                           
} 
add_action( 'edit_user_profile_update', 'wpfui2i_save_featured_checkBox_userEditPage');


/**
* [wpfui2i_get_featured_users Get list of the featured users by shortcode]
*/
function wpfui2i_get_featured_users($atts) {
	$default_atts=array();
	$default_atts['fields']= "ID,user_login,display_name,user_email";
	$default_atts['output']="table"; 
	if(!$atts)
	{	
		$atts['fields']=$default_atts['fields'];
		$atts['output']=$default_atts['output'];
	}
	elseif (!$atts['fields']) 
	{
		$atts['fields']=$default_atts['fields'];
	}
	elseif (!$atts['output']) 
	{
		$atts['output']=$default_atts['output'];
	}

	$atts['fields']=explode(",",$atts['fields']);

    $args = array(
                   'meta_key'     => 'wpfui2i_featured_user',
                   'meta_value'   => 'yes',
                   'fields'       => $atts['fields'],
                  );

    $featured_users = get_users( apply_filters('wpfui2i_get_users_args',$args) ); 

    if( $featured_users ) {

    	if($atts['output']=="array")
    	{    		
    		return apply_filters('wpfui2i_featured_array',$featured_users);
    	}
    	else{
    		$featured_table="<table class='wpfui2i_table'>";
    		//Get Table headers
    		foreach ($atts['fields'] as $header_item) {
    			$featured_table .="<th>".$header_item."</th>";
    		}
    		//Get Table data
    		foreach ($featured_users as $object) {
    			$featured_table .="<tr>";    			
    			foreach ($object as $key => $value) {					
					$featured_table .="<td>".$value."</td>";    			  			
    			}
    			$featured_table .="</tr>";  
    		}
    		$featured_table .="</table>";    		
    		return apply_filters('wpfui2i_print_table',$featured_table);
    	}        
    }
    else{
    	return apply_filters('wpfui2i_no_featured_message','No featured Users');    	
    }
    
}
// Register a new shortcode: [list_featured_users]
add_shortcode( 'list_featured_users', 'wpfui2i_get_featured_users' );
// print it using: do_shortcode( '[list_featured_users]' );

