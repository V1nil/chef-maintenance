<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Simple_Job_Board_Rewrite class.
 *
 * @link        https://wordpress.org/plugins/simple-job-board
 * @since       2.1.0
 *
 * @package     Simple_Job_Board
 * @subpackage  Simple_Job_Board/includes
 */

/**
 * This is used to define custom post types.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since       2.1.0
 * @package     Simple_Job_Board
 * @subpackage  Simple_Job_Board/includes
 * @author      PressTigers <support@presstigers.com>
 */
class Simple_Job_Board_Rewrite
{
    /**
     * Constructor
     */
    public function __construct()
    {
        //add_action( 'init', array ( $this, 'job_board_rewrite' ) );
    }
    
    /**
     * job_board_rewrite function.
     *
     * @access public
     * @return void
     */
    public function job_board_rewrite ()
    {
        if ( ! function_exists( 'get_home_path' ) ) {
            require_once( ABSPATH . 'wp-admin/includes/file.php' );
        }
        $root_path = get_home_path ();
        $file_existing_permission = '';

        /* Getting Rules */
        $rules = ( 'yes' === get_option ( 'job_board_anti_hotlinking' )) ? $this->job_board_rewrite_rules() : '';
                    
        /* Rules Force Files to be Downloaded  */
        $forcedownload_rule = "AddType application/octet-stream .pdf .txt\n";
        
        /* Changing File to Writable Mode  */
        if ( file_exists ( $root_path . '.htaccess' ) && ! is_writable ( $root_path . '.htaccess' ) )  {
            $file_existing_permission = substr ( decoct ( fileperms ( $root_path . '.htaccess' ) ), -4 );
            chmod ( $root_path . '.htaccess', 0777 );
        }

        /* Appending .htaccess  */
        if ( file_exists ( $root_path . '.htaccess' ) && is_writable ( $root_path . '.htaccess' ) ) {
            
            $rules = explode ( "\n", $rules );
            $forcedownload_rule = explode ( "\n", $forcedownload_rule );
            
            // Anti-Hotlinking Rules Writing in .htaccess file
            if ( ! function_exists( 'insert_with_markers' ) ) {
                require_once( ABSPATH . 'wp-admin/includes/misc.php' );
            }
            
            insert_with_markers ( $root_path . '.htaccess', 'Hotlinking', $rules); 
            
            // Force Download Rules Writing in .htaccess file 
            insert_with_markers ( $root_path . '.htaccess', 'Force Download', $forcedownload_rule);            

            /* Revert File Permission  */
            if(!empty ( $file_existing_permission ) )
            chmod ( $root_path . '.htaccess', $file_existing_permission );
        }
    }
    
    /**
     * job_board_rewrite_rules function.
     *
     * @access public
     * @return string
     */
    public function job_board_rewrite_rules ()
    {
        $site_url = get_site_url ();
        $site_url = trailingslashit ( $site_url );
        $allowed_extensions = get_option ( 'job_board_allowed_extensions' );
        
        if ( $allowed_extensions ) {
            /* Retrieve String from Array Separated by |  */
            $hotlink_extension = implode ( '|', $allowed_extensions );

            /* Anti Hotlinking Rules */
            $rules = "<IfModule mod_rewrite.c>\n"
                    . "RewriteEngine On\n"
                    . "RewriteCond %{HTTP_REFERER} !^$\n"
                    . "RewriteCond %{HTTP_REFERER} !^" . $site_url . ".*$ [NC]\n"
                    . "RewriteRule \.(" . $hotlink_extension . ")$ [R=302,L]\n"
                    . "</IfModule>\n";

            return $rules;
        }
    }
}
new Simple_Job_Board_Rewrite();